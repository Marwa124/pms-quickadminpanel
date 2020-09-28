<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAttendancessRequest;
use App\Http\Requests\StoreAttendancessRequest;
use App\Http\Requests\UpdateAttendancessRequest;
use App\Models\Attendancess;
use App\Models\LeaveApplication;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendancessController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendancess_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendancesses = Attendancess::all();

        return view('admin.attendancesses.index', compact('attendancesses'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendancess_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_applications = LeaveApplication::all()->pluck('leave_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.attendancesses.create', compact('users', 'leave_applications'));
    }

    public function store(StoreAttendancessRequest $request)
    {
        $attendancess = Attendancess::create($request->all());

        return redirect()->route('admin.attendancesses.index');
    }

    public function edit(Attendancess $attendancess)
    {
        abort_if(Gate::denies('attendancess_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_applications = LeaveApplication::all()->pluck('leave_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendancess->load('user', 'leave_application');

        return view('admin.attendancesses.edit', compact('users', 'leave_applications', 'attendancess'));
    }

    public function update(UpdateAttendancessRequest $request, Attendancess $attendancess)
    {
        $attendancess->update($request->all());

        return redirect()->route('admin.attendancesses.index');
    }

    public function show(Attendancess $attendancess)
    {
        abort_if(Gate::denies('attendancess_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendancess->load('user', 'leave_application');

        return view('admin.attendancesses.show', compact('attendancess'));
    }

    public function destroy(Attendancess $attendancess)
    {
        abort_if(Gate::denies('attendancess_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendancess->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttendancessRequest $request)
    {
        Attendancess::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
