@extends('adminlte::page')

@section('content')

    @php
        $heads = ['#', trans('admin.group_name'), trans('admin.group_course'), trans('admin.group_education_full'), trans('admin.group_start'), trans('admin.group_end'), ['label' => trans('admin.actions'), 'no-export' => true, 'width' => 5]];
        
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
    <div class="d-flex justify-content-end pt-4 pb-2">
        <x-adminlte-button id="createButton" icon="fa fa-lg fa-fw fa-plus" data-toggle="modal" data-target="#modalCreate"
            class="bg-success" label="{{ trans('admin.create') }}" />
    </div>
    <x-adminlte-datatable id="table" :heads="$heads" hoverable :config="$config" head-theme="dark" striped bordered
        beautify>
        @foreach ($groups as $row)
            <tr>
                <td>{{ $row['id'] }}</td>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['course'] }}</td>
                <td>
                    {{ $educationTypes[$row['education_type_id'] - 1]->abbreviated_name
                        ? $educationTypes[$row['education_type_id'] - 1]->abbreviated_name
                        : $educationTypes[$row['education_type_id'] - 1]->full_name }}
                </td>
                <td>{{ $row['date_start'] }}</td>
                <td>{{ $row['date_end'] }}</td>
                <td>
                    <nobr>
                        <a href="{{ route('group.show', $row['id']) }}">
                            <x-adminlte-button id="destroyButton" icon="fa fa-lg fa-fw fa-eye" class="bg-primary" />
                        </a>
                        <x-adminlte-button data-id="{{ $row['id'] }}" data-name="{{ $row['name'] }}"
                            data-start="{{ $row['date_start'] }}" data-end="{{ $row['date_end'] }}"
                            data-type_name="{{ $educationTypes[$row['education_type_id'] - 1]->full_name . ' (' . $educationTypes[$row['education_type_id'] - 1]->time_type . ')' }}"
                            data-type_value="{{ $row['education_type_id'] }}" id="editButton" icon="fa fa-lg fa-fw fa-pen"
                            data-toggle="modal" data-target="#modalEdit" class="bg-warning" />
                        <x-adminlte-button data-id="{{ $row['id'] }}" id="destroyButton" icon="fa fa-lg fa-fw fa-trash"
                            data-toggle="modal" data-target="#modalDelete" class="bg-danger" />
                    </nobr>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    {{-- EDIT FORM --}}
    <form method="POST" id="updateForm" action="{{ route('group.update', 1) }}"> {{-- ID changes on submit --}}
        <x-adminlte-modal id="modalEdit" title="{{ trans('admin.group_modal_edit_title') }}" theme="warning"
            icon="fas fa-exclamation" size='lg'>
            @csrf
            @method('PATCH')

            <label>{{ trans('admin.group_name') }}</label>
            <x-adminlte-input name="name" id="nameInput" />
            <x-adminlte-select2 id="select" name="education_type_id"
                data-placeholder="{{ trans('admin.group_select_default') }}">
                <option selected disabled></option>
                @foreach ($educationTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->full_name }} ({{ $type->time_type }})</option>
                @endforeach
            </x-adminlte-select2>

            @php
                $config = [
                    'showDropdowns' => true,
                    'autoApply' => true,
                    'singleDatePicker' => true,
                    'locale' => [
                        'format' => 'DD.MM.YYYY',
                        'daysOfWeek' => [trans('admin.day_monday'), trans('admin.day_tuesday'), trans('admin.day_wednesday'), trans('admin.day_thursday'), trans('admin.day_friday'), trans('admin.day_saturday'), trans('admin.day_sunday')],
                        'monthNames' => [trans('admin.month_january'), trans('admin.month_febuary'), trans('admin.month_march'), trans('admin.month_april'), trans('admin.month_may'), trans('admin.month_june'), trans('admin.month_july'), trans('admin.month_august'), trans('admin.month_september'), trans('admin.month_october'), trans('admin.month_november'), trans('admin.month_december')],
                    ],
                    'opens' => 'center',
                ];
            @endphp

            <div class="d-flex justify-content-between">
                <x-adminlte-date-range name="date_start" label="{{ trans('admin.group_start') }}" igroup-size="lg"
                    :config="$config" id="dateStart">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-warning">
                            <i class="fas fa-lg fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>
                <x-adminlte-date-range name="date_end" label="{{ trans('admin.group_end') }}" igroup-size="lg"
                    :config="$config" id="dateEnd">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-warning">
                            <i class="fas fa-lg fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>
            </div>

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-warning" type="submit">{{ trans('admin.edit') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- DELETE FORM --}}
    <form method="POST" id="destroyForm" action="{{ route('group.destroy', 1) }}"> {{-- ID changes on submit --}}
        <x-adminlte-modal id="modalDelete" title="{{ trans('admin.group_modal_delete_title') }}" theme="danger"
            icon="fas fa-trash" size='lg'>
            @csrf
            @method('DELETE')
            {{ trans('admin.group_modal_delete_message') }}
            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- CREATE FORM --}}
    <form method="POST" id="createForm" action="{{ route('group.store') }}">
        <x-adminlte-modal id="modalCreate" title="{{ trans('admin.group_modal_create_title') }}" theme="success"
            icon="fas fa-plus" size='lg'>
            @csrf
            <label>{{ trans('admin.group_name') }}</label>
            <x-adminlte-input name="name" />

            <x-adminlte-select2 name="education_type_id" data-placeholder="{{ trans('admin.group_select_default') }}">
                <option selected disabled></option>
                @foreach ($educationTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->full_name }} ({{ $type->time_type }})</option>
                @endforeach
            </x-adminlte-select2>

            @php
                $config = [
                    'showDropdowns' => true,
                    'autoApply' => true,
                    'singleDatePicker' => true,
                    'locale' => [
                        'format' => 'DD.MM.YYYY',
                        'daysOfWeek' => [trans('admin.day_monday'), trans('admin.day_tuesday'), trans('admin.day_wednesday'), trans('admin.day_thursday'), trans('admin.day_friday'), trans('admin.day_saturday'), trans('admin.day_sunday')],
                        'monthNames' => [trans('admin.month_january'), trans('admin.month_febuary'), trans('admin.month_march'), trans('admin.month_april'), trans('admin.month_may'), trans('admin.month_june'), trans('admin.month_july'), trans('admin.month_august'), trans('admin.month_september'), trans('admin.month_october'), trans('admin.month_november'), trans('admin.month_december')],
                    ],
                    'opens' => 'center',
                ];
            @endphp

            <div class="d-flex justify-content-between">
                <x-adminlte-date-range name="date_start" label="{{ trans('admin.group_start') }}" igroup-size="lg"
                    :config="$config">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-lg fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>
                <x-adminlte-date-range name="date_end" label="{{ trans('admin.group_end') }}" igroup-size="lg"
                    :config="$config">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-lg fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>
            </div>

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-success" type="submit">{{ trans('admin.create') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>
    {{ request()->cookie('adminlte_theme') }}

@stop

@section('js')
    <script>
        let editId = '1';
        let deleteId = '1';

        document.querySelector('#updateForm').addEventListener('submit', (e) => {
            e.currentTarget.action = e.currentTarget.action.replace(/.$/, editId);
        });

        document.querySelector('#destroyForm').addEventListener('submit', (e) => {
            e.currentTarget.action = e.currentTarget.action.replace(/.$/, deleteId);
        });

        document.querySelector('#table').addEventListener('click', (e) => {
            if (e.target.closest('#editButton')) {
                editId = e.target.closest('#editButton').dataset.id;
                document.querySelector('#nameInput').value = e.target.closest('#editButton').dataset.name;
                document.querySelector('#select').value = e.target.closest('#editButton').dataset.type_value;
                document.querySelector('#select2-select-container').innerText = e.target.closest('#editButton')
                    .dataset.type_name;
                document.querySelector('#dateStart').value = e.target.closest('#editButton').dataset.start;
                document.querySelector('#dateEnd').value = e.target.closest('#editButton').dataset.end;
            }

            e.target.closest('#destroyButton') && (deleteId = e.target.closest('#destroyButton').dataset.id);
        });
    </script>
@stop
