<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDesignationRequest;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Deparrtment;
use App\Models\Designation;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::all();

        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        abort_if(Gate::denies('designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Deparrtment::all()->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.designations.create', compact('departments', 'permissions'));
    }

    public function store(StoreDesignationRequest $request)
    {
        $designation = Designation::create($request->all());
        $designation->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.designations.index');
    }

    public function edit(Designation $designation)
    {
        abort_if(Gate::denies('designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Deparrtment::all()->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $permissions = Permission::all()->pluck('title', 'id');

        $designation->load('department', 'permissions');

        return view('admin.designations.edit', compact('departments', 'permissions', 'designation'));
    }

    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $designation->update($request->all());
        $designation->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.designations.index');
    }

    public function show(Designation $designation)
    {
        abort_if(Gate::denies('designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->load('department', 'permissions');

        return view('admin.designations.show', compact('designation'));
    }

    public function destroy(Designation $designation)
    {
        abort_if(Gate::denies('designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationRequest $request)
    {
        Designation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
