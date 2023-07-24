@extends('adminlte::page')

@section('content')

    @php
        $heads = ['#', trans('admin.teacher_full'), trans('admin.teacher_position_full'), trans('admin.teacher_department_full'), ['label' => trans('admin.actions'), 'no-export' => true, 'width' => 5]];
        
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
        @foreach ($teachers as $row)
            <tr>
                <td>{{ $row['id'] }}</td>
                <td>{{ $row['full_name'] }}</td>
                <td>
                    {{ !is_null($row['position_id']) && $positions[$row['position_id'] - 1]->full_name ? $positions[$row['position_id'] - 1]->full_name : '-' }}
                </td>
                <td>
                    {{ !is_null($row['department_id']) && $departments[$row['department_id'] - 1]->full_name
                        ? $departments[$row['department_id'] - 1]->abbreviated_name
                        : '-' }}
                </td>
                <td>
                    <nobr>
                        <x-adminlte-button data-id="{{ $row['id'] }}" data-full="{{ $row['full_name'] }}"
                            data-department_id="{{ $row['department_id'] }}" data-position_id="{{ $row['position_id'] }}"
                            data-department="{{ !is_null($row['department_id']) && $departments[$row['department_id'] - 1]->full_name }}"
                            data-position="{{ !is_null($row['position_id']) && $positions[$row['position_id'] - 1]->full_name }}"
                            id="editButton" icon="fa fa-lg fa-fw fa-pen" data-toggle="modal" data-target="#modalEdit"
                            class="bg-warning" />
                        <x-adminlte-button data-id="{{ $row['id'] }}" id="destroyButton" icon="fa fa-lg fa-fw fa-trash"
                            data-toggle="modal" data-target="#modalDelete" class="bg-danger" />
                    </nobr>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    {{-- EDIT FORM --}}
    <form method="POST" id="updateForm" action="{{ route('teacher.update', 1) }}"> {{-- ID changes on submit --}}
        <x-adminlte-modal id="modalEdit" title="{{ trans('admin.teacher_modal_edit_title') }}" theme="warning"
            icon="fas fa-exclamation" size='lg'>
            @csrf
            @method('PATCH')

            <label>{{ trans('admin.teacher_full') }}</label>
            <x-adminlte-input name="full_name" id="nameInput" />
            <x-adminlte-select2 id="departmentSelect" name="department_id"
                data-placeholder="{{ trans('admin.teacher_select_department_default') }}">
                <option selected disabled></option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <x-adminlte-select2 id="positionSelect" name="position_id"
                data-placeholder="{{ trans('admin.teacher_select_position_default') }}">
                <option selected disabled></option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-warning" type="submit">{{ trans('admin.edit') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- DELETE FORM --}}
    <form method="POST" id="destroyForm" action="{{ route('teacher.destroy', 1) }}"> {{-- ID changes on submit --}}
        <x-adminlte-modal id="modalDelete" title="{{ trans('admin.teacher_modal_delete_title') }}" theme="danger"
            icon="fas fa-trash" size='lg'>
            @csrf
            @method('DELETE')
            {{ trans('admin.teacher_modal_delete_message') }}
            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- CREATE FORM --}}
    <form method="POST" id="createForm" action="{{ route('teacher.store') }}">
        <x-adminlte-modal id="modalCreate" title="{{ trans('admin.teacher_modal_create_title') }}" theme="success"
            icon="fas fa-plus" size='lg'>
            @csrf
            <label>{{ trans('admin.teacher_full') }}</label>
            <x-adminlte-input name="full_name" />
            <x-adminlte-select2 name="department_id"
                data-placeholder="{{ trans('admin.teacher_select_department_default') }}">
                <option selected disabled></option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <x-adminlte-select2 name="position_id" data-placeholder="{{ trans('admin.teacher_select_position_default') }}">
                <option selected disabled></option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-success" type="submit">{{ trans('admin.create') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>
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
                document.querySelector('#nameInput').value = e.target.closest('#editButton').dataset.full;
                document.querySelector('#departmentSelect').value = e.target.closest('#editButton').dataset
                    .department_id;
                document.querySelector('#select2-departmentSelect-container').innerText = e.target.closest(
                        '#editButton')
                    .dataset.department;
                document.querySelector('#positionSelect').value = e.target.closest('#editButton').dataset
                    .position_id;
                document.querySelector('#select2-positionSelect-container').innerText = e.target.closest(
                        '#editButton')
                    .dataset.position;
            }

            e.target.closest('#destroyButton') && (deleteId = e.target.closest('#destroyButton').dataset.id);
        });
    </script>
@stop
