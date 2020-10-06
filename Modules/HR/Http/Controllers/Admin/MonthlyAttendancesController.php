<?php

namespace Modules\HR\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\HR\Entities\MonthlyAttendance;
use Gate;
use Illuminate\Http\Request;
use Modules\HR\Entities\FingerprintAttendance;
use Symfony\Component\HttpFoundation\Response;

class MonthlyAttendancesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('monthly_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = $request->date;
        if ($request['date'] == '') {
            $date = date('Y-m');
        }

            $monthlyAttendances = [];
            $data_value = FingerprintAttendance::where('date', 'like', '%' . $date . '%')->get();
            dd($data_value);

            $users = User::where('banned', 0)->select('id')->get();
            foreach ($users as $key => $user) {
                // $result = [];
                // $result['user_account_id'] = $user->accountDetail->id;
                // $result['id'] = $user->accountDetail->employment_id;
                // $result['name'] = $user->accountDetail->fullname;
                // $result['clock_out'] = $data_value->where('user_id', $user->id)->max('time') ?? '-';
                // $result['clock_in'] = $data_value->where('user_id', $user->id)->min('time') ?? '-';
                // $result['absent'] = getAbsentUsers($date, $user->id);
                // $result['vacation'] = getVacations($date, $user->id);
                // $result['holiday'] = getHolidays($date);
                // $fingerprintAttendances[] = $result;
            }

            return view('hr::admin.monthlyAttendances.index', compact('monthlyAttendances', 'date'));
    }

    public function show(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendance->load('user');

        return view('hr::admin.monthlyAttendances.show', compact('monthlyAttendance'));
    }
}
