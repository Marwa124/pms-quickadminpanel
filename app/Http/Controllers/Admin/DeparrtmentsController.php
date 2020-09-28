<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeparrtmentRequest;
use App\Http\Requests\StoreDeparrtmentRequest;
use App\Http\Requests\UpdateDeparrtmentRequest;
use App\Models\Deparrtment;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeparrtmentsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deparrtment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deparrtments = Deparrtment::all();

        $users = User::get();

        return view('admin.deparrtments.index', compact('deparrtments', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('deparrtment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department_heads = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.deparrtments.create', compact('department_heads'));
    }

    public function store(StoreDeparrtmentRequest $request)
    {
        $deparrtment = Deparrtment::create($request->all());

        return redirect()->route('admin.deparrtments.index');
    }

    public function edit(Deparrtment $deparrtment)
    {
        abort_if(Gate::denies('deparrtment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department_heads = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deparrtment->load('department_head');

        return view('admin.deparrtments.edit', compact('department_heads', 'deparrtment'));
    }

    public function update(UpdateDeparrtmentRequest $request, Deparrtment $deparrtment)
    {
        $deparrtment->update($request->all());

        return redirect()->route('admin.deparrtments.index');
    }

    public function show(Deparrtment $deparrtment)
    {
        abort_if(Gate::denies('deparrtment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deparrtment->load('department_head', 'departmentDesignations');

        return view('admin.deparrtments.show', compact('deparrtment'));
    }

    public function destroy(Deparrtment $deparrtment)
    {
        abort_if(Gate::denies('deparrtment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deparrtment->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeparrtmentRequest $request)
    {
        Deparrtment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
