<div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
    <div>
        <label for="longCheckbox">{{ trans('admin.schedule_create_checkbox_long') }}</label>
        <input class="long-checkbox" id="longCheckbox" value="1" name="long" type="checkbox">
    </div>
    <label>{{ trans('admin.schedule_create_week_number_input') }}</label>
    <div>
        @for ($i = 1; $i <= 4; $i++)
            <span class="mr-2 d-inline-flex align-items-center">
                <input style="width: 16px;height: 16px;" id="weekNumberCheckbox{{ $i }}"
                    value="{{ $i }}" name="week_numbers[]" type="checkbox">
                <label class="mt-2 ml-1" for="weekNumberCheckbox{{ $i }}">{{ $i }}</label>
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
            <option selected value="0">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
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
</div>
