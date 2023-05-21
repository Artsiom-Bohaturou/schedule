@extends('adminlte::page')

@section('content')

    <div class="mt-3 ml-2 mb-4">
        <h2>{{ trans('admin.schedule_create_page_title') }}</h2>
        <form method="POST" action="{{ route('schedule.store') }}">
            @csrf

            <label>{{ trans('admin.schedule_create_group_input') }}</label>
            <x-adminlte-select2 name="group_id">
                <option selected disabled></option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </x-adminlte-select2>

            <label>{{ trans('admin.schedule_create_subject_input') }}</label>
            <x-adminlte-select2 name="subject_id">
                <option selected disabled></option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <label>{{ trans('admin.schedule_create_teacher_input') }}</label>
            <x-adminlte-select2 name="teacher_id">
                <option selected disabled></option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <label>{{ trans('admin.schedule_create_building_input') }}</label>
            <x-adminlte-input type="number" name="building" />

            <label>{{ trans('admin.schedule_create_auditory_input') }}</label>
            <x-adminlte-input type="number" name="auditory" />

            <label>{{ trans('admin.schedule_create_subject_type_input') }}</label>
            <x-adminlte-select2 name="subject_type_id" id="typeSelect">
                <option selected disabled></option>
                @foreach ($types as $type)
                    <option @if ($type->exam) href="#exam" @else href="#subject" @endif
                        value="{{ $type->id }}" data-long="{{ $type->long }}">{{ $type->full_name }}</option>
                @endforeach
            </x-adminlte-select2>

            <div class="tab-content">
                @include('admin.schedule.tabs.subject')
                @include('admin.schedule.tabs.exam')
            </div>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success mr-2" type="submit">{{ trans('admin.create') }}</button>
                <a href="{{ route('schedule.index') }}">
                    <x-adminlte-button theme="secondary" label="{{ trans('admin.cancel') }}" />
                </a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        let long = 0;

        $('#typeSelect').on('change', function() {
            $('.tab-content .tab-pane').removeClass('show active');
            $($(this).find('option:selected').attr('href')).addClass('show active');
            long = +this.options[this.selectedIndex].dataset.long;

            if (long == 1) {
                $('#subgroupSection').attr('hidden', false);
            } else {
                $('#subgroupSection').attr('hidden', true);
            }
        });

        $('#timeStartSelect').on('change', function() {
            var value = (+$(this).find('option:selected').val() + long).toString();
            $('#timeEndSelect').select2('val', value);
        });

        $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY HH:mm'));
        });

        $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input[name="date_start"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY'));
        });

        $('input[name="date_start"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input[name="date_end"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY'));
        });

        $('input[name="date_end"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
@stop

@section('css')
    <style>
        .custom-line {
            position: relative;
            top: 5px;
            width: 10px;
            height: 2px;
            background-color: #fff;
        }
    </style>
@stop
