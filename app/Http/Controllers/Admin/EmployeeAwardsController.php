<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeAwardRequest;
use App\Http\Requests\StoreEmployeeAwardRequest;
use App\Http\Requests\UpdateEmployeeAwardRequest;
use App\Models\EmployeeAward;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAwardsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_award_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAwards = EmployeeAward::all();

        return view('admin.employeeAwards.index', compact('employeeAwards'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_award_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeAwards.create', compact('users'));
    }

    public function store(StoreEmployeeAwardRequest $request)
    {
        $employeeAward = EmployeeAward::create($request->all());

        return redirect()->route('admin.employee-awards.index');
    }

    public function edit(EmployeeAward $employeeAward)
    {
        abort_if(Gate::denies('employee_award_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeAward->load('user');

        return view('admin.employeeAwards.edit', compact('users', 'employeeAward'));
    }

    public function update(UpdateEmployeeAwardRequest $request, EmployeeAward $employeeAward)
    {
        $employeeAward->update($request->all());

        return redirect()->route('admin.employee-awards.index');
    }

    public function show(EmployeeAward $employeeAward)
    {
        abort_if(Gate::denies('employee_award_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAward->load('user');

        return view('admin.employeeAwards.show', compact('employeeAward'));
    }

    public function destroy(EmployeeAward $employeeAward)
    {
        abort_if(Gate::denies('employee_award_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAward->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeAwardRequest $request)
    {
        EmployeeAward::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
