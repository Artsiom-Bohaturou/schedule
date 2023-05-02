<?php

namespace App\Http\Controllers\Admin\Subject;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Subject\SubjectStoreRequest;
use App\Http\Requests\Admin\Subject\SubjectUpdateRequest;
use App\Models\Subject;

class SubjectController extends BaseController
{
    public function index()
    {
        $data = Subject::all();

        return view('admin.subject.index', compact('data'));
    }

    public function store(SubjectStoreRequest $request)
    {
        $data = $request->validated();
        Subject::create($data);

        return redirect()->route('subject.index');
    }

    public function update(SubjectUpdateRequest $request, $id)
    {
        $data = $request->validated();
        Subject::findOrFail($id)->update($data);

        return redirect()->route('subject.index');
    }

    public function destroy($id)
    {
        Subject::destroy($id);

        return redirect()->route('subject.index');
    }
}
