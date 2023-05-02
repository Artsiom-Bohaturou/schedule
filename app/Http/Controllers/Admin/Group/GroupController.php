<?php

namespace App\Http\Controllers\Admin\Group;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Group\GroupStoreRequest;
use App\Http\Requests\Admin\Group\GroupUpdateRequest;
use App\Models\Group;
use App\Models\GroupEducationType;

class GroupController extends BaseController
{

    public function index(\Illuminate\Http\Request $request)
    {
        $groups = Group::getGroups();
        $educationTypes = GroupEducationType::all();

        return view('admin.group.index', compact('groups', 'educationTypes'));
    }

    public function store(GroupStoreRequest $request)
    {
        $data = $request->validated();
        Group::create($data);

        return redirect()->route('group.index');
    }

    public function update(GroupUpdateRequest $request, $id)
    {
        $data = $request->validated();
        Group::findOrFail($id)->update($data);

        return redirect()->route('group.index');
    }

    public function show($id)
    {
        dd('show');
    }

    public function destroy($id)
    {
        Group::destroy($id);

        return redirect()->route('group.index');
    }
}
