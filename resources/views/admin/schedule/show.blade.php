@extends('adminlte::page')

@section('content')
    <div class="mb-4">
        <x-adminlte-button icon="fa fa-lg fa-fw fa-trash" data-toggle="modal" data-target="#modalDelete" class="bg-danger mt-3"
            label="{{ trans('admin.schedule_show_delete_title') }}" />
        <a href="{{ route('schedule.edit', $subjects[0]->id) }}">
            <x-adminlte-button icon="fa fa-lg fa-fw fa-edit" class="bg-warning mt-3 ml-2"
                label="{{ trans('admin.schedule_show_edit_title') }}" />
        </a>
        <table class="table table-bordered table-striped mt-3 pl-2" style="width:100%;">
            <tbody class="table-body-js">
                <tr>

                    <td class="align-middle">{{ trans('admin.group_name') }}</td>

                    <td>
                        {{ $subjects[0]->group->name }}
                    </td>
                </tr>

                <tr>
                    <td class="align-middle">{{ trans('admin.schedule_teacher') }}</td>
                    <td class="align-middle">
                        {{ $subjects[0]->teacher->full_name }}
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">{{ trans('admin.subject_full') }}</td>
                    <td class="align-middle">{{ $subjects[0]->subject->full_name }}
                        ({{ $subjects[0]->subject->abbreviated_name }})
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">{{ trans('admin.schedule_type') }}</td>
                    <td class="align-middle">{{ $subjects[0]->subjectType->full_name }}</td>
                </tr>
                <tr>
                    <td class="align-middle">{{ trans('admin.schedule_building') }}</td>
                    <td class="align-middle">{{ $subjects[0]->building }}</td>
                </tr>
                <tr>
                    <td class="align-middle">{{ trans('admin.schedule_auditory') }}</td>
                    <td class="align-middle">{{ $subjects[0]->auditory }}</td>
                </tr>
                @if (is_null($subjects[0]->date))
                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_week_number') }}</td>
                        <td class="align-middle">
                            @php
                                $weeks = '';
                                
                                foreach ($subjects as $subject) {
                                    $weeks .= $subject->week_number . ', ';
                                }
                                
                                $weeks = substr($weeks, 0, -2);
                            @endphp

                            {{ $weeks }}
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_weekday') }}</td>
                        <td class="align-middle">{{ $subjects[0]->weekday ? $subjects[0]->weekday->name : '' }}</td>
                    </tr>
                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_subgroup') }}</td>
                        <td class="align-middle">{{ $subjects[0]->subgroup ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_time') }}</td>
                        <td class="align-middle">{{ $subjects[0]->subjectTime ? $subjects[0]->subjectTime->id : '' }}.
                            {{ $subjects[0]->subjectTime ? $subjects[0]->subjectTime->time_start : '' }} -
                            {{ $subjects[0]->subjectTime ? $subjects[0]->subjectTime->time_end : '' }}</td>
                    </tr>

                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_start') }}</td>
                        <td class="align-middle">{{ date('d.m.Y', strtotime($subjects[0]->date_start)) }}</td>
                    </tr>
                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_end') }}</td>
                        <td class="align-middle">{{ date('d.m.Y', strtotime($subjects[0]->date_end)) }}</td>
                    </tr>
                @endif
                @if (!is_null($subjects[0]->date))
                    <tr>
                        <td class="align-middle">{{ trans('admin.schedule_date') }}</td>
                        <td class="align-middle">{{ date('d.m.Y H:i', strtotime($subjects[0]->date)) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{-- DELETE MODAL --}}

    <form method="POST" id="destroyForm" action="{{ route('schedule.destroy') }}">
        <x-adminlte-modal id="modalDelete" title="{{ trans('admin.schedule_show_delete_title') }}" theme="danger"
            icon="fas fa-trash" size='lg'>
            @csrf
            @method('DELETE')
            {{ trans('admin.schedule_show_delete_message') }}

            @foreach ($subjects as $subject)
                <input hidden value="{{ $subject->id }}" name="id[]">
            @endforeach
            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>
@endsection
