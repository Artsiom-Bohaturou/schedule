<?php

namespace App\Http\Controllers\Admin\Subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subject\SubjectTypeStoreRequest;
use App\Http\Requests\Admin\Subject\SubjectTypeUpdateRequest;
use App\Models\SubjectType;

class SubjectTypeController extends Controller
{
    public function index()
    {
        $data = SubjectType::all();

        return view('admin.subject.type', compact('data'));
    }

    public function store(SubjectTypeStoreRequest $request)
    {
        $data = $request->validated();
        SubjectType::create($data);

        return redirect()->route('subject.type.index');
    }

    public function update(SubjectTypeUpdateRequest $request, $id)
    {
        $data = $request->validated();
        SubjectType::findOrFail($id)->update($data);

        return redirect()->route('subject.type.index');
    }

    public function destroy($id)
    {
        SubjectType::destroy($id);

        return redirect()->route('subject.type.index');
    }
}
