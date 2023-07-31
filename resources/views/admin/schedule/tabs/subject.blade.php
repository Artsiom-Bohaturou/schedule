<div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
    <div>
        <label for="longCheckbox">{{ trans('admin.schedule_create_checkbox_long') }}</label>
        <input @if (old('long') == 1) checked @endif class="long-checkbox" id="longCheckbox" value="1"
            name="long" type="checkbox">
    </div>
    <label>{{ trans('admin.schedule_create_week_number_input') }}</label>
    <div>
        @for ($i = 1; $i <= 4; $i++)
            <span class="mr-2 d-inline-flex align-items-center">
                <input @if (in_array($i, old('week_numbers') ?? [])) checked @endif style="width: 16px;height: 16px;"
                    id="weekNumberCheckbox{{ $i }}" value="{{ $i }}" name="week_numbers[]"
                    type="checkbox">
                <label class="mt-2 ml-1" for="weekNumberCheckbox{{ $i }}">{{ $i }}</label>
            </span>
        @endfor

        @if ($errors->first('week_numbers') != null)
            <br>
            <span style="color:red;">{{ $errors->first('week_numbers') }}</span>
        @endif
    </div>

    <label>{{ trans('admin.schedule_create_week_number_input') }}</label>
    <div>
        @foreach ($weekdays as $weekday)
            <span class="mr-2 d-inline-flex align-items-center">
                <input @if (in_array($weekday->id, old('weekdays') ?? [])) checked @endif style="width: 16px;height: 16px;"
                    id="weekdayCheckbox{{ $weekday->id }}" value="{{ $weekday->id }}" name="weekdays[]"
                    type="checkbox">
                <label class="mt-2 ml-1" for="weekdayCheckbox{{ $weekday->id }}">{{ $weekday->name }}</label>
            </span>
        @endforeach

        @if ($errors->first('weekdays') != null)
            <br>
            <span style="color:red;">{{ $errors->first('weekdays') }}</span>
        @endif
    </div>

    <div id="subgroupSection">
        <label>{{ trans('admin.schedule_create_subgroup_input') }}</label>
        <x-adminlte-select2 name="subgroup">
            <option selected value="0">-</option>
            <option @if (old('subgroup') == 1) selected @endif value="1">1</option>
            <option @if (old('subgroup') == 2) selected @endif value="2">2</option>
        </x-adminlte-select2>
    </div>

    <div class="d-flex w-100 justify-content-center align-items-center">
        <div class="w-25">
            <label>{{ trans('admin.schedule_create_time_start_input') }}</label>
            <x-adminlte-select2 name="subject_time_id" id="timeStartSelect">
                @foreach ($times as $time)
                    <option value="{{ $time->id }}">{{ $time->time_start }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
        <div class="mx-4 custom-line"></div>
        <div class="w-25">
            <label>{{ trans('admin.schedule_create_time_end_input') }}</label>
            <x-adminlte-select2 disabled id="timeEndSelect" name="time_end">
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
            
            $configStart = $config;
            $configEnd = $config;
            
            if (old('date_start') != null) {
                $configStart['startDate'] = old('date_start');
            }
            
            if (old('date_end') != null) {
                $configEnd['startDate'] = old('date_end');
            }
        @endphp
        <x-adminlte-date-range name="date_start" label="{{ trans('admin.schedule_create_date_start_input') }}"
            igroup-size="lg" :config="$configStart" class="w-25">
            <x-slot name="prependSlot">
                <div class="input-group-text text-success">
                    <i class="fas fa-lg fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-date-range>
        <div class="mx-4 custom-line"></div>

        <x-adminlte-date-range name="date_end" label="{{ trans('admin.schedule_create_date_end_input') }}"
            igroup-size="lg" :config="$configEnd" class="w-25">
            <x-slot name="prependSlot">
                <div class="input-group-text text-success">
                    <i class="fas fa-lg fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-date-range>
    </div>
</div>
