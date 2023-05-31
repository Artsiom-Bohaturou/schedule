@extends('adminlte::page')

@section('content')

    <div class="d-flex justify-content-between pt-4 pb-2">
        <x-adminlte-button icon="fa fa-lg fa-fw fa-upload" data-toggle="modal" data-target="#modalImport" class="bg-primary"
            label="{{ trans('admin.schedule_import') }}" />
        <a href="{{ route('schedule.create') }}">
            <x-adminlte-button id="createButton" icon="fa fa-lg fa-fw fa-plus" class="bg-success"
                label="{{ trans('admin.create') }}" />
        </a>
    </div>

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="subjectTab" data-toggle="tab" href="#subject" role="tab"
                aria-controls="subjectTab" aria-selected="true">{{ trans('admin.schedule_subject_tab') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="examTab" data-toggle="tab" href="#exam" role="tab" aria-controls="examTab"
                aria-selected="false">{{ trans('admin.schedule_exam_tab') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active pt-4" id="subject" role="tabpanel" aria-labelledby="subjectTab">

            <table id="subjectTable" class="table table-bordered table-hover table-striped dataTable no-footer"
                style="width:100%">
                <thead class="thead-dark custom-head">
                    <tr>
                        <th class="text-center align-middle">{{ trans('admin.group_name') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_teacher') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.subject_full') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_type') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_week_number') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_weekday') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_building') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_auditory') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_subgroup') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.schedule_time') }}</th>
                        <th class="text-center align-middle">{{ trans('admin.actions') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedule as $row)
                        @if (!$row->date)
                            <tr>
                                <td class="text-center align-middle">{{ $row->group->name }}</td>
                                <td class="text-center align-middle">{{ $row->teacher->full_name }}</td>
                                <td class="text-center align-middle">{{ $row->subject->full_name }}</td>
                                <td class="text-center align-middle">{{ $row->subjectType->abbreviated_name }}</td>
                                <td class="text-center align-middle">{{ $row->week_numbers }}</td>
                                <td class="text-center align-middle"><span
                                        hidden>{{ $row->weekday->id }}</span>{{ $row->weekday->name }}
                                </td>
                                <td class="text-center align-middle">{{ $row->building }}</td>
                                <td class="text-center align-middle">{{ $row->auditory }}</td>
                                <td class="text-center align-middle">{{ $row->subgroup ? $row->subgroup : '-' }}</td>
                                <td class="text-center align-middle">
                                    <nobr>
                                        @php
                                            $fullTime = $time[$row->subject_time_id - 1]->time_start . ' - ' . $time[$row->subject_time_id - 1]->time_end;
                                        @endphp
                                        {{ $row->subject_time_id }} ({{ $fullTime }})
                                    </nobr>
                                </td>
                                <td class="text-center align-middle">
                                    <nobr>
                                        <a href="{{ route('schedule.show', $row['id']) }}">
                                            <x-adminlte-button icon="fa fa-lg fa-fw fa-eye" class="bg-primary" />
                                        </a>
                                    </nobr>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="tab-pane fade pt-4" id="exam" role="tabpanel" aria-labelledby="examTab">
            @php
                $heads = [trans('admin.group_name'), trans('admin.schedule_teacher'), trans('admin.subject_full'), trans('admin.schedule_type'), trans('admin.schedule_building'), trans('admin.schedule_auditory'), trans('admin.schedule_time'), ['label' => trans('admin.actions'), 'no-export' => true, 'width' => 5]];
                
                $config = [
                    'order' => [[0, 'asc']],
                    'bInfo' => false,
                    'language' => [
                        'sProcessing' => trans('admin.datatable_processing'),
                        'sZeroRecords' => trans('admin.datatable_zero_records'),
                        'sEmptyTable' => trans('admin.datatable_empty'),
                        'sSearch' => trans('admin.datatable_search'),
                        'sLoadingRecords' => trans('admin.datatable_loading'),
                        'sLengthMenu' => trans('admin.datatable_length'),
                        'oPaginate' => [
                            'sFirst' => trans('admin.datatable_first'),
                            'sLast' => trans('admin.datatable_last'),
                            'sNext' => trans('admin.datatable_next'),
                            'sPrevious' => trans('admin.datatable_previous'),
                        ],
                    ],
                ];
            @endphp

            <x-adminlte-datatable id="examTable" :heads="$heads" hoverable :config="$config" head-theme="dark" striped
                bordered beautify>
                @foreach ($schedule as $row)
                    @if ($row->date)
                        <tr>
                            <td>{{ $row->group->name }}</td>
                            <td>{{ $row->teacher->full_name }}</td>
                            <td>{{ $row->subject->abbreviated_name }}</td>
                            <td>{{ $row->subjectType->full_name }}</td>
                            <td>{{ $row->building }}</td>
                            <td>{{ $row->auditory }}</td>
                            <td>{{ date('d.m.Y H:i', strtotime($row->date)) }}</td>
                            <td>
                                <nobr>
                                    <a href="{{ route('schedule.show', $row['id']) }}">
                                        <x-adminlte-button icon="fa fa-lg fa-fw fa-eye" class="bg-primary" />
                                    </a>
                                </nobr>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

    {{-- IMPORT FORM --}}
    <form method="POST" action="{{ route('schedule.import') }}" enctype="multipart/form-data">
        <x-adminlte-modal id="modalImport" title="{{ trans('admin.subject_modal_edit_title') }}" theme="primary"
            icon="fas fa-upload" size='lg'>
            @csrf

            <label>{{ trans('admin.schedule_import_label') }}</label>
            <x-adminlte-input type="file" name="file" />

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button id="importSubmit" class="btn btn-primary" type="submit" data-toggle="modal"
                    data-target="#modalLoader">
                    {{ trans('admin.schedule_import_submit') }}
                </button>
                <x-adminlte-button id="importHide" theme="secondary" label="{{ trans('admin.cancel') }}"
                    data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- Loader --}}
    <x-adminlte-modal id="modalLoader">
        <div class="d-flex align-items-center">
            <div class="spinner-border text-primary mr-3" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            {{ trans('admin.schedule_import_loader') }}
        </div>
    </x-adminlte-modal>

@stop

@section('css')
    <style>
        a {
            color: inherit;
        }

        .nav.nav-tabs a:not(.active):hover {
            color: inherit;
            filter: brightness(80%);
        }

        #modalLoader .modal-header {
            display: none;
        }

        #modalLoader .modal-footer {
            display: none;
        }

        .custom-head {
            position: sticky;
            top: 0;
        }

        .group {
            position: sticky;
            top: 50px;
            width: 100%;
            background-color: #212529 !important;
        }
    </style>
@stop

@section('js')
    <script>
        document.querySelector('#importSubmit')
            .addEventListener('click', () => document.querySelector('#importHide').click());

        $(document).ready(function() {
            var groupColumn = 0;

            var table = $('#subjectTable').DataTable({
                columnDefs: [{
                    visible: false,
                    targets: groupColumn
                }],
                order: [
                    [0, 'asc'],
                    [5, 'asc'],
                    [9, 'asc']
                ],
                bInfo: false,
                pageLength: 25,
                language: {
                    sProcessing: '{{ trans('admin.datatable_processing') }}',
                    sZeroRecords: '{{ trans('admin.datatable_zero_records') }}',
                    sEmptyTable: '{{ trans('admin.datatable_empty') }}',
                    sSearch: '{{ trans('admin.datatable_search') }}',
                    sLoadingRecords: '{{ trans('admin.datatable_loading') }}',
                    sLengthMenu: '{{ trans('admin.datatable_length') }}',
                    oPaginate: {
                        sFirst: '{{ trans('admin.datatable_first') }}',
                        sLast: '{{ trans('admin.datatable_last') }}',
                        sNext: '{{ trans('admin.datatable_next') }}',
                        sPrevious: '{{ trans('admin.datatable_previous') }}',
                    },
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var lastGroup = null;
                    var lastSubject = null;

                    api
                        .column(groupColumn, {
                            page: 'current'
                        })
                        .data()
                        .each(function(group, i) {
                            if (lastGroup !== group) {
                                $(rows)
                                    .eq(i)
                                    .before('<tr class="group"><td colspan="10">' + group +
                                        '</td></tr>');

                                lastGroup = group;
                            }
                        });

                },
            });

            table.on('page.dt', function() {
                $('html, body').animate({
                    scrollTop: $('#subjectTable').offset().top
                }, 'fast');
            });
        });
    </script>
@stop
