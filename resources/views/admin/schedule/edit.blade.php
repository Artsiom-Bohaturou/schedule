@extends('adminlte::page')

@section('content')

    <div class="mt-3 ml-2 mb-4">
        <h2>{{ trans('admin.schedule_create_page_title') }}</h2>
        <form method="POST" action="{{ route('schedule.update') }}">
            @csrf
            @method('PATCH')

            <label>{{ trans('admin.schedule_create_group_input') }}</label>
            <x-adminlte-select2 name="group_id">
                @foreach ($groups as $group)
                    <option @if ($default[0]->group_id == $group->id) selected @endif value="{{ $group->id }}">
                        {{ $group->name }}
                    </option>
                @endforeach
            </x-adminlte-select2>

            <label>{{ trans('admin.schedule_create_subject_input') }}</label>
            <x-adminlte-select2 name="subject_id">
                @foreach ($subjects as $subject)
                    <option @if ($default[0]->subject_id == $subject->id) selected @endif value="{{ $subject->id }}">
                        {{ $subject->full_name }}
                    </option>
                @endforeach
            </x-adminlte-select2>

            <label>{{ trans('admin.schedule_create_teacher_input') }}</label>
            <x-adminlte-select2 name="teacher_id">
                @foreach ($teachers as $teacher)
                    <option @if ($default[0]->teacher_id == $teacher->id) selected @endif value="{{ $teacher->id }}">
                        {{ $teacher->full_name }}
                    </option>
                @endforeach
            </x-adminlte-select2>

            <label>{{ trans('admin.schedule_create_building_input') }}</label>
            <x-adminlte-input type="number" name="building" value="{{ $default[0]->building }}" />

            <label>{{ trans('admin.schedule_create_auditory_input') }}</label>
            <x-adminlte-input type="number" name="auditory" value="{{ $default[0]->auditory }}" />

            <label>{{ trans('admin.schedule_create_subject_type_input') }}</label>
            <x-adminlte-select2 name="subject_type_id">
                @foreach ($types as $type)
                    @if ($type->exam == $default[0]->subjectType->exam)
                        <option @if ($default[0]->subject_type_id == $type->id) selected @endif value="{{ $type->id }}">
                            {{ $type->full_name }}
                        </option>
                    @endif
                @endforeach
            </x-adminlte-select2>

            @if (is_null($default[0]->date))
                <label>{{ trans('admin.schedule_create_week_number_input') }}</label>
                <div>
                    @for ($i = 1; $i <= 4; $i++)
                        <span class="mr-2 d-inline-flex align-items-center">
                            <input style="width: 16px;height: 16px;" id="weekNumberCheckbox{{ $i }}"
                                value="{{ $i }}" name="week_numbers[]" type="checkbox">
                            <label class="mt-2 ml-1"
                                for="weekNumberCheckbox{{ $i }}">{{ $i }}</label>
                        </span>
                    @endfor
                </div>

                <label>{{ trans('admin.schedule_create_week_number_input') }}</label>
                <div>
                    @foreach ($weekdays as $weekday)
                        <span class="mr-2 d-inline-flex align-items-center">
                            <input style="width: 16px;height: 16px;" id="weekdayCheckbox{{ $weekday->id }}"
                                value="{{ $weekday->id }}" name="weekdays[]" type="checkbox">
                            <label class="mt-2 ml-1" for="weekdayCheckbox{{ $weekday->id }}">{{ $weekday->name }}</label>
                        </span>
                    @endforeach
                </div>

                <div id="subgroupSection">
                    <label>{{ trans('admin.schedule_create_subgroup_input') }}</label>
                    <x-adminlte-select2 name="subgroup">
                        <option @if ($default[0]->subgroup == 0) selected @endif value="0">-</option>
                        <option @if ($default[0]->subgroup == 0) selected @endif value="1">1</option>
                        <option @if ($default[0]->subgroup == 0) selected @endif value="2">2</option>
                    </x-adminlte-select2>
                </div>

                <div class="d-flex w-100 justify-content-center align-items-center">
                    <div class="w-25">
                        <label>{{ trans('admin.schedule_create_time_start_input') }}</label>
                        <x-adminlte-select2 name="subject_time_id" id="timeStartSelect">
                            <option selected disabled></option>
                            @foreach ($times as $time)
                                <option value="{{ $time->id }}">{{ $time->time_start }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="mx-4 custom-line"></div>
                    <div class="w-25">
                        <label>{{ trans('admin.schedule_create_time_end_input') }}</label>
                        <x-adminlte-select2 disabled id="timeEndSelect" name="time_end">
                            <option selected disabled></option>
                            @foreach ($times as $time)
                                <option value="{{ $time->id }}">{{ $time->time_end }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>

                </div>

                <div class="d-flex w-100 justify-content-center align-items-center">
                    @php
                        $config = [
                            'showDropdowns' => true,
                            'autoApply' => true,
                            'singleDatePicker' => true,
                            'autoUpdateInput' => false,
                            'locale' => [
                                'format' => 'DD.MM.YYYY',
                                'daysOfWeek' => [trans('admin.day_monday'), trans('admin.day_tuesday'), trans('admin.day_wednesday'), trans('admin.day_thursday'), trans('admin.day_friday'), trans('admin.day_saturday'), trans('admin.day_sunday')],
                                'monthNames' => [trans('admin.month_january'), trans('admin.month_febuary'), trans('admin.month_march'), trans('admin.month_april'), trans('admin.month_may'), trans('admin.month_june'), trans('admin.month_july'), trans('admin.month_august'), trans('admin.month_september'), trans('admin.month_october'), trans('admin.month_november'), trans('admin.month_december')],
                            ],
                            'opens' => 'center',
                            'drops' => 'up',
                        ];
                    @endphp

                    <x-adminlte-date-range name="date_start" label="{{ trans('admin.schedule_create_date_start_input') }}"
                        igroup-size="lg" :config="$config" class="w-25">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>
                    <div class="mx-4 custom-line"></div>

                    <x-adminlte-date-range name="date_end" label="{{ trans('admin.schedule_create_date_end_input') }}"
                        igroup-size="lg" :config="$config" class="w-25">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>
                </div>
            @else
                @include('admin.schedule.tabs.exam')
            @endif

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

        $('#longCheckbox').change(function() {
            if (this.checked) {
                long = 1;
            }

            if (!this.checked) {
                long = 0;
            }
        });

        $('#timeStartSelect').on('change', function() {
            let value = (+$(this).find('option:selected').val() + long).toString();
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

        .long-checkbox {
            width: 20px;
            height: 20px;
            position: relative;
            top: 6px;
            left: 5px;
        }
    </style>
@stop
