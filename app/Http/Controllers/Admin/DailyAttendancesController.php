<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDailyAttendanceRequest;
use App\Http\Requests\StoreDailyAttendanceRequest;
use App\Http\Requests\UpdateDailyAttendanceRequest;
use App\Models\DailyAttendance;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DailyAttendancesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('daily_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dailyAttendances = DailyAttendance::all();

        return view('admin.dailyAttendances.index', compact('dailyAttendances'));
    }

    public function create()
    {
        abort_if(Gate::denies('daily_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dailyAttendances.create', compact('users'));
    }

    public function store(StoreDailyAttendanceRequest $request)
    {
        $dailyAttendance = DailyAttendance::create($request->all());

        return redirect()->route('admin.daily-attendances.index');
    }

    public function edit(DailyAttendance $dailyAttendance)
    {
        abort_if(Gate::denies('daily_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dailyAttendance->load('user');

        return view('admin.dailyAttendances.edit', compact('users', 'dailyAttendance'));
    }

    public function update(UpdateDailyAttendanceRequest $request, DailyAttendance $dailyAttendance)
    {
        $dailyAttendance->update($request->all());

        return redirect()->route('admin.daily-attendances.index');
    }

    public function show(DailyAttendance $dailyAttendance)
    {
        abort_if(Gate::denies('daily_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dailyAttendance->load('user');

        return view('admin.dailyAttendances.show', compact('dailyAttendance'));
    }

    public function destroy(DailyAttendance $dailyAttendance)
    {
        abort_if(Gate::denies('daily_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dailyAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyDailyAttendanceRequest $request)
    {
        DailyAttendance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
