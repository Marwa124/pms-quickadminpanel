<?php

namespace Modules\HR\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\HR\Http\Requests\Destroy\MassDestroyClientMeetingRequest;
use Modules\HR\Http\Requests\Store\StoreClientMeetingRequest;
use Modules\HR\Http\Requests\Update\UpdateClientMeetingRequest;
use Modules\HR\Entities\ClientMeeting;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClientMeetingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ClientMeeting::with(['user'])->select(sprintf('%s.*', (new ClientMeeting)->table));
            $table = DataTables::of($query);

            $table->addColumn('status_color', ' ');

            // dd(LeaveApplication::with(['user', 'leave_category']));
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('status_color', '&nbsp;');

            // $table->editColumn('status_color', function ($row) {
            //     return $row->status && ClientMeeting::STATUS_COLOR[$row->status] ? ClientMeeting::STATUS_COLOR[$row->status] : 'none';
            // });

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_request_show';
                $editGate      = 'employee_request_edit';
                $deleteGate    = 'employee_request_delete';
                $modalId       = 'hr.';
                $crudRoutePart = 'client_meetings';

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
            $table->editColumn('day', function ($row) {
                return $row->day ? $row->day : '';
            });
            $table->editColumn('status_color', function ($row) {
                return $row->status && ClientMeeting::STATUS_COLOR[$row->status] ? ClientMeeting::STATUS_COLOR[$row->status] : 'none';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? ClientMeeting::STATUS_SELECT[$row->status] : '';
            });
            // return $table->make(true);
            $table->editColumn('day_hour', function ($row) {
                return $row->day_hour ? ClientMeeting::MEETING_STATUS_SELECT[$row->day_hour] : '';
            });
            $table->editColumn('from_time', function ($row) {
                return $row->from_time ? $row->from_time : "";
            });
            $table->editColumn('to_time', function ($row) {
                return $row->to_time ? $row->to_time : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('hr::admin.clientMeetings.index');




        // $clientMeetings = ClientMeeting::all();

        // return view('hr::admin.clientMeetings.index', compact('clientMeetings'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('hr::admin.clientMeetings.create', compact('users'));
    }

    public function store(StoreClientMeetingRequest $request)
    {
        // dd($request->all());
        $clientMeetings = ClientMeeting::create($request->all());

        return redirect()->route('hr.admin.client-meetings.index');
    }

    public function edit(ClientMeeting $clientMeeting)
    {
        abort_if(Gate::denies('employee_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clientMeeting->load('user');

        return view('hr::admin.clientMeetings.edit', compact('users', 'clientMeeting'));
    }

    public function update(UpdateClientMeetingRequest $request, ClientMeeting $clientMeeting)
    {
        $request['approved_by'] = $request->user()->id;
        $clientMeeting->update($request->all());

        return redirect()->route('hr.admin.client-meetings.index');
    }

    public function show(ClientMeeting $clientMeeting)
    {
        abort_if(Gate::denies('employee_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clientMeeting->load('user');

        return view('hr::admin.clientMeetings.show', compact('clientMeeting'));
    }

    public function destroy(ClientMeeting $clientMeeting)
    {
        abort_if(Gate::denies('employee_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clientMeeting->delete();

        return back();
    }

    public function massDestroy(MassDestroyClientMeetingRequest $request)
    {
        ClientMeeting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
