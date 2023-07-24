@extends('adminlte::page')

@section('content')
    {{-- Setup data for datatables --}}
    @php
        $heads = ['#', trans('admin.subject_time_range'), ['label' => trans('admin.actions'), 'no-export' => true, 'width' => 5]];
        
        $config = [
            'order' => [[1, 'asc']],
            'paging' => false,
            'searching' => false,
            'bInfo' => false,
        ];
        
    @endphp

    <x-adminlte-datatable id="table" :heads="$heads" hoverable :config="$config" head-theme="dark" striped bordered
        beautify>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row['id'] }}</td>
                <td>{{ $row['duration'] }}</td>
                <td>
                    <x-adminlte-button data-id="{{ $row['id'] }}" data-end="{{ $row['time_end'] }}"
                        data-start="{{ $row['time_start'] }}" id="editButton" icon="fa fa-lg fa-fw fa-pen"
                        data-toggle="modal" data-target="#modalEdit" class="bg-warning" />
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    <form method="POST" id="updateForm" action="{{ route('subject.time.update', 1) }}">
        <x-adminlte-modal id="modalEdit" title="{{ trans('admin.subject_time_modal_edit_title') }}" theme="warning"
            icon="fas fa-exclamation" size='lg'>
            @csrf
            @method('PATCH')
            @php
                $config = [
                    'format' => 'HH:mm',
                ];
            @endphp
            <div class="m-auto w-75 d-flex justify-content-between">
                <x-adminlte-input-date id="timeStart" name="time_start" :config="$config"
                    placeholder="{{ trans('admin.time_start') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
                <i class="fas fa-minus mt-3"></i>
                <x-adminlte-input-date id="timeEnd" name="time_end" :config="$config"
                    placeholder="{{ trans('admin.time_end') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>

            <x-slot name="footerSlot">
                <div class="mr-auto"></div>
                <button class="btn btn-warning" type="submit">{{ trans('admin.edit') }}</button>
                <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" data-dismiss="modal" />
            </x-slot>
        </x-adminlte-modal>
    </form>


@stop

@section('js')
    <script>
        let id = '1';

        document.querySelector('#updateForm').addEventListener('submit', (e) => {
            e.currentTarget.action = e.currentTarget.action.replace(/.$/, id);
        });

        document.querySelector('#table').addEventListener('click', (e) => {
            if (e.target.closest('#editButton')) {
                id = e.target.closest('#editButton').dataset.id;
                document.querySelector('#timeStart').value = e.target.closest('#editButton').dataset.start;
                document.querySelector('#timeEnd').value = e.target.closest('#editButton').dataset.end;
            }
        });
    </script>
@stop
