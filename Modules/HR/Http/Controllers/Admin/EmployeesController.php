<?php

namespace Modules\HR\Http\Controllers\Admin;

use Modules\HR\Http\Controllers\Controller;
use Modules\HR\Http\Requests\Destroy\MassDestroyEmployeeRequest;
use Modules\HR\Http\Requests\Store\StoreEmployeeRequest;
use Modules\HR\Http\Requests\Update\UpdateEmployeeRequest;
use Modules\HR\Entities\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeesController extends Controller
{
    // public function index()
    // {
    //     abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $employees = User::all();

    //     $roles = Role::get();

    //     $permissions = Permission::get();

    //     return view('hr::admin.employees.index', compact('employees', 'roles', 'permissions'));
    // }

    // public function create()
    // {
    //     abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

    //     $permissions = Permission::all()->pluck('title', 'id');

    //     return view('hr::admin.employees.create', compact('roles', 'permissions'));
    // }

    // public function store(StoreEmployeeRequest $request)
    // {
    //     $employee = User::create($request->all());
    //     $employee->permissions()->sync($request->input('permissions', []));

    //     return redirect()->route('hr.admin.employees.index');
    // }

    public function edit(User $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $permissions = Permission::all()->pluck('title', 'id');

        $employee->load('role', 'permissions');

        return view('hr::admin.employees.edit', compact('roles', 'permissions', 'employee'));
    }

    public function update(User $employee)
    {
        // $employee->update($request->all());
        $employee->roles()->sync(request()->input('role_id'));
        $employee->permissions()->sync(request()->input('permissions', []));

        return redirect()->route('hr.admin.departments.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('role', 'permissions');

        return view('hr::admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
