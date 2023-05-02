<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Teacher\TeacherDepartmentStoreRequest;
use App\Http\Requests\Admin\Teacher\TeacherDepartmentUpdateRequest;
use App\Models\TeacherDepartment;

class TeacherDepartmentController extends BaseController
{
    public function index()
    {
        $data = TeacherDepartment::all();

        return view('admin.teacher.department', compact('data'));
    }

    public function store(TeacherDepartmentStoreRequest $request)
    {
        $data = $request->validated();
        TeacherDepartment::create($data);

        return redirect()->route('teacher.department.index');
    }

    public function update(TeacherDepartmentUpdateRequest $request, $id)
    {
        $data = $request->validated();
        TeacherDepartment::findOrFail($id)->update($data);

        return redirect()->route('teacher.department.index');
    }

    public function destroy($id)
    {
        TeacherDepartment::destroy($id);

        return redirect()->route('teacher.department.index');
    }
}
