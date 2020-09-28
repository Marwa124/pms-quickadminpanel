<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyAttendancesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendances = MonthlyAttendance::all();

        return view('admin.monthlyAttendances.index', compact('monthlyAttendances'));
    }

    public function show(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendance->load('user');

        return view('admin.monthlyAttendances.show', compact('monthlyAttendance'));
    }
}
