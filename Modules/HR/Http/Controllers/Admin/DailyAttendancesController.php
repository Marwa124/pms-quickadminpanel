<?php

namespace Modules\HR\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\HR\Http\Requests\Destroy\MassDestroyDailyAttendanceRequest;
use Modules\HR\Http\Requests\Store\StoreDailyAttendanceRequest;
use Modules\HR\Http\Requests\Update\UpdateDailyAttendanceRequest;
use Modules\HR\Entities\DailyAttendance;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use App\Models\AccountDetail;
use Modules\HR\Entities\FingerprintAttendance;
use Modules\HR\Entities\Holiday;
use Modules\HR\Entities\SetTime;
use Modules\HR\Entities\LeaveCategory;
use Modules\HR\Entities\WorkingDay;
use Symfony\Component\HttpFoundation\Response;

class DailyAttendancesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('daily_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // var_dump($request['day']);
        if ($request['day'] != '') {
            // $fingerprintAttendances = FingerprintAttendance::where('date', $request['day'])->get()->toArray();
            // return response()->json(['data' => $fingerprintAttendances]);

            if ($request->ajax()) {
                // $query = FingerprintAttendance::with(['user', 'leave_category'])->select(sprintf('%s.*', (new FingerprintAttendance)->table));
                $query = FingerprintAttendance::select(sprintf('%s.*', (new FingerprintAttendance)->table));
                $table = Datatables::of($query);
    
                // dd(LeaveApplication::with(['user', 'leave_category']));
                $table->addColumn('placeholder', '&nbsp;');
                $table->addColumn('actions', '&nbsp;');
    
                $table->editColumn('actions', function ($row) {
                    $viewGate      = 'leave_application_show';
                    $editGate      = 'leave_application_edit';
                    $deleteGate    = 'leave_application_delete';
                    $modalId       = 'hr.';
                    $crudRoutePart = 'leave-applications';
    
                    return view('partials.datatablesActions', compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'modalId',
                        'crudRoutePart',
                        'row'
                    ));
                });
    
                $table->editColumn('id', function ($row) {
                    return $row->id ? $row->id : "";
                });
                $table->editColumn('date', function ($row) {
                    return $row->date ? $row->date : "";
                });
                $table->editColumn('time', function ($row) {
                    return $row->time ? $row->time : "";
                });
    
                $table->rawColumns(['actions', 'placeholder', 'leave_category']);
    
                return $table->make(true);
            }
            //ajax end
        }
        $fingerprintAttendances = [];
        return view('hr::admin.dailyAttendances.index', compact('fingerprintAttendances'));
    }

    public function set_attendance(Request $request)
    {
		$attendance_day = date("D", strtotime($request->date));

		$weekly_holidays = WorkingDay::where('working_status', 0)
			->get(['day'])
			->toArray();

		$monthly_holidays = Holiday::whereDate('start_date', '<=', $request->date)
            ->whereDate('end_date', '>=', $request->date)
            ->first(['start_date', 'end_date']);

		if ($monthly_holidays['date'] == $request->date) {
			return redirect()->back()->with('exception', 'You select a holiday !');
		}

		foreach ($weekly_holidays as $weekly_holiday) {
			if ($attendance_day == $weekly_holiday['day']) {
				return redirect()->back()->with('exception', 'You select a holiday !');
			}
		}

		// $employees = AccountDetail::query()
		// 	->leftjoin('designations as designations', 'account_details.designation_id', '=', 'designations.id')
		// 	->orderBy('account_details.fullname', 'ASC')
		// 	// ->where('account_details.access_label', '>=', 2)
		// 	// ->where('account_details.access_label', '<=', 3)
		// 	->get(['designations.designation_name', 'account_details.fullname', 'account_details.id'])
        //     ->toArray();

            $employees = AccountDetail::with('designation')
            // ->get(['account_details.fullname', 'account_details.id'])
            // ->select('designation.designation_name', 'account_details.fullname', 'account_details.id')
            ->get()
            ->toArray();
            // dd($employees);

		$leave_categories = LeaveCategory::get()
			->where('deleted_at', null)
			->toArray();
		$date = $request->date;

		$attendances = FingerprintAttendance::where('date', $date)
			->get()
			->toArray();

		if (empty($attendances)) {
			return view('hr::admin.dailyAttendances.set_attendance', compact('employees', 'leave_categories', 'date'));
        }
        // var_dump("pppp");
        return view('hr::admin.dailyAttendances.set_attendance', compact('employees', 'leave_categories', 'date'));

		// return view('hr::admin.dailyAttendances.edit_attendance', compact('employees', 'leave_categories', 'date', 'attendances'));
    }

    public function timeSet(Request $request) {

        //return $request;

        $id=$request->id;

        $setimes= SetTime::all();

        if($setimes->count()>0){
         $setimes= SetTime::find($id);
        $setimes->in_time = $request->in_time;
        $setimes->out_time = $request->out_time;
        $setimes->save();

        return redirect()->back()->with('message', 'Set Update Successful!');

        }else{

         $setimes= new SetTime;
        $setimes->created_by = auth()->user()->id;
        $setimes->in_time = $request->in_time;
        $setimes->out_time = $request->out_time;
        $setimes->save();

        return redirect()->back()->with('message', 'Set Successful!');
        }

    }

    public function create()
    {
        abort_if(Gate::denies('daily_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('hr::admin.dailyAttendances.create', compact('users'));
    }

    public function store(StoreDailyAttendanceRequest $request)
    {
        $dailyAttendance = DailyAttendance::create($request->all());

        return redirect()->route('hr.admin.daily-attendances.index');
    }

    public function edit(DailyAttendance $dailyAttendance)
    {
        abort_if(Gate::denies('daily_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dailyAttendance->load('user');

        return view('hr::admin.dailyAttendances.edit', compact('users', 'dailyAttendance'));
    }

    public function update(UpdateDailyAttendanceRequest $request, DailyAttendance $dailyAttendance)
    {
        $dailyAttendance->update($request->all());

        return redirect()->route('hr.admin.daily-attendances.index');
    }

    public function show(DailyAttendance $dailyAttendance)
    {
        abort_if(Gate::denies('daily_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dailyAttendance->load('user');

        return view('hr::admin.dailyAttendances.show', compact('dailyAttendance'));
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
