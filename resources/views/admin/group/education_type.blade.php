@extends('adminlte::page')

@section('content')

    @php
        $heads = ['#', trans('admin.abbreviated'), trans('admin.group_education_full'), trans('admin.group_education_time_type'), ['label' => trans('admin.actions'), 'no-export' => true, 'width' => 5]];
        
        $config = [
            'order' => [[0, 'asc']],
            'paging' => false,
            'searching' => false,
            'bInfo' => false,
        ];
        
    @endphp
    <div class="d-flex justify-content-end pt-4">
        <x-adminlte-button id="createButton" icon="fa fa-lg fa-fw fa-plus" data-toggle="modal" data-target="#modalCreate"
            class="bg-success" label="{{ trans('admin.create') }}" />
    </div>
    <x-adminlte-datatable id="table" :heads="$heads" hoverable :config="$config" head-theme="dark" striped bordered
        beautify>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row['id'] }}</td>
                <td>{{ $row['abbreviated_name'] }}</td>
                <td>{{ $row['full_name'] }}</td>
                <td>{{ $row['time_type'] }}</td>
                <td>
                    <nobr>
                        <x-adminlte-button data-type="{{ $row['time_type'] }}" data-id="{{ $row['id'] }}"
                            data-full="{{ $row['full_name'] }}" data-abbreviated="{{ $row['abbreviated_name'] }}"
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
    <form method="POST" id="updateForm" action="{{ route('group.education.update', 1) }}"> {{-- ID changes on submit --}}
        <x-adminlte-modal id="modalEdit" title="{{ trans('admin.group_education_modal_edit_title') }}" theme="warning"
            icon="fas fa-exclamation" size='lg'>
            @csrf
            @method('PATCH')

            <label>{{ trans('admin.abbreviated') }}</label>
            <x-adminlte-input name="abbreviated_name" id="abbreviatedInput" />
            <label>{{ trans('admin.group_education_full') }}</label>
            <x-adminlte-input name="full_name" id="fullInput" />
            <x-adminlte-select2 id="select" name="time_type"
                data-placeholder="{{ trans('admin.group_education_select_default') }}">
                <option value="Дневное">{{ trans('admin.group_education_select_day') }}</option>
                <option value="Вечернее">{{ trans('admin.group_education_select_evening') }}
                </option>
                <option value="Заочное">{{ trans('admin.group_education_select_extramural') }}
                </option>
            </x-adminlte-select2>

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-warning" type="submit">{{ trans('admin.edit') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- DELETE FORM --}}
    <form method="POST" id="destroyForm" action="{{ route('group.education.destroy', 1) }}"> {{-- ID changes on submit --}}
        <x-adminlte-modal id="modalDelete" title="{{ trans('admin.group_education_modal_delete_title') }}" theme="danger"
            icon="fas fa-trash" size='lg'>
            @csrf
            @method('DELETE')
            {{ trans('admin.group_education_modal_delete_message') }}
            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>

    {{-- CREATE FORM --}}
    <form method="POST" id="createForm" action="{{ route('group.education.store') }}">
        <x-adminlte-modal id="modalCreate" title="{{ trans('admin.group_education_modal_create_title') }}" theme="success"
            icon="fas fa-plus" size='lg'>
            @csrf
            <label>{{ trans('admin.abbreviated') }}</label>
            <x-adminlte-input name="abbreviated_name" id="abbreviatedInput" />
            <label>{{ trans('admin.group_education_full') }}</label>
            <x-adminlte-input name="full_name" id="fullInput" />
            <x-adminlte-select2 name="time_type" data-placeholder="{{ trans('admin.group_education_select_default') }}">
                <option selected disabled></option>
                <option value="Дневное">{{ trans('admin.group_education_select_day') }}</option>
                <option value="Вечернее">{{ trans('admin.group_education_select_evening') }}</option>
                <option value="Заочное">{{ trans('admin.group_education_select_extramural') }}</option>
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
                document.querySelector('#abbreviatedInput').value = e.target.closest('#editButton').dataset
                    .abbreviated;
                document.querySelector('#fullInput').value = e.target.closest('#editButton').dataset.full;
                document.querySelector('#select').value = e.target.closest('#editButton').dataset.type;
                document.querySelector('#select2-select-container').innerText = e.target.closest('#editButton')
                    .dataset.type;
            }

            e.target.closest('#destroyButton') && (deleteId = e.target.closest('#destroyButton').dataset.id);
        });
    </script>
@stop
