<div class="tab-pane fade" id="exam" role="tabpanel" aria-labelledby="exam-tab">
    @php
        $config = [
            'showDropdowns' => true,
            'autoApply' => true,
            'singleDatePicker' => true,
            'timePicker' => true,
            'timePicker24Hour' => true,
            'autoUpdateInput' => false,
            'locale' => [
                'format' => 'DD.MM.YYYY hh:mm',
                'daysOfWeek' => [trans('admin.day_monday'), trans('admin.day_tuesday'), trans('admin.day_wednesday'), trans('admin.day_thursday'), trans('admin.day_friday'), trans('admin.day_saturday'), trans('admin.day_sunday')],
                'monthNames' => [trans('admin.month_january'), trans('admin.month_febuary'), trans('admin.month_march'), trans('admin.month_april'), trans('admin.month_may'), trans('admin.month_june'), trans('admin.month_july'), trans('admin.month_august'), trans('admin.month_september'), trans('admin.month_october'), trans('admin.month_november'), trans('admin.month_december')],
            ],
            'opens' => 'right',
            'drops' => 'up',
        ];
    @endphp

    <x-adminlte-date-range name="date" label=" {{ trans('admin.schedule_create_exam_date_input') }}" igroup-size="lg"
        :config="$config">
        <x-slot name="prependSlot">
            <div class="input-group-text text-success">
                <i class="fas fa-lg fa-calendar-alt"></i>
            </div>
        </x-slot>
    </x-adminlte-date-range>
</div>
