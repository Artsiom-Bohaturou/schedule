<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Teacher\TeacherPositionStoreRequest;
use App\Http\Requests\Admin\Teacher\TeacherPositionUpdateRequest;
use App\Models\TeacherPosition;

class TeacherPositionController extends BaseController
{
    public function index()
    {
        $data = TeacherPosition::all();

        return view('admin.teacher.position', compact('data'));
    }

    public function store(TeacherPositionStoreRequest $request)
    {
        $data = $request->validated();
        TeacherPosition::create($data);

        return redirect()->route('teacher.position.index');
    }

    public function update(TeacherPositionUpdateRequest $request, $id)
    {
        $data = $request->validated();
        TeacherPosition::findOrFail($id)->update($data);

        return redirect()->route('teacher.position.index');
    }

    public function destroy($id)
    {
        TeacherPosition::destroy($id);

        return redirect()->route('teacher.position.index');
    }
}
