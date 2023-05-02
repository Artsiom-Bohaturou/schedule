<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Teacher\TeacherStoreRequest;
use App\Http\Requests\Admin\Teacher\TeacherUpdateRequest;
use App\Models\Teacher;
use App\Models\TeacherDepartment;
use App\Models\TeacherPosition;

class TeacherController extends BaseController
{
    public function index()
    {
        $teachers = Teacher::all();
        $departments = TeacherDepartment::all();
        $positions = TeacherPosition::all();

        return view('admin.teacher.index', compact('teachers', 'departments', 'positions'));
    }

    public function store(TeacherStoreRequest $request)
    {
        $data = $request->validated();
        Teacher::create($data);

        return redirect()->route('teacher.index');
    }

    public function update(TeacherUpdateRequest $request, $id)
    {
        $data = $request->validated();
        Teacher::findOrFail($id)->update($data);

        return redirect()->route('teacher.index');
    }

    public function show($id)
    {
        dd('show');
    }

    public function destroy($id)
    {
        Teacher::destroy($id);

        return redirect()->route('teacher.index');
    }
}
