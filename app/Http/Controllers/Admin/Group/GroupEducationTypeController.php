<?php

namespace App\Http\Controllers\Admin\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Group\GroupEducationTypeStoreRequest;
use App\Http\Requests\Admin\Group\GroupEducationTypeUpdateRequest;
use App\Models\GroupEducationType;

class GroupEducationTypeController extends Controller
{
    public function index()
    {
        $data = GroupEducationType::all();

        return view('admin.group.education_type', compact('data'));
    }

    public function store(GroupEducationTypeStoreRequest $request)
    {
        $data = $request->validated();
        GroupEducationType::create($data);

        return redirect()->route('group.education.index');
    }

    public function update(GroupEducationTypeUpdateRequest $request, $id)
    {
        $data = $request->validated();
        GroupEducationType::findOrFail($id)->update($data);

        return redirect()->route('group.education.index');
    }

    public function destroy($id)
    {
        GroupEducationType::destroy($id);

        return redirect()->route('group.education.index');
    }
}
