<?php

namespace App\Http\Controllers\Admin\Subject;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Subject\SubjectTimeUpdateRequest;
use App\Models\SubjectTime;

class SubjectTimeController extends BaseController
{
    public function index()
    {
        $data = SubjectTime::getTimeRange();

        return view('admin.subject.time', compact('data'));
    }

    public function update(SubjectTimeUpdateRequest $request, $id)
    {
        $data = $request->validated();
        SubjectTime::findOrFail($id)->update($data);

        return redirect()->route('subject.time.index');
    }
}
