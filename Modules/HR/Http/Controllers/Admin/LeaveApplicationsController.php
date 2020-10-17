<?php

namespace Modules\HR\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\AccountDetail;
use Modules\HR\Http\Requests\Destroy\MassDestroyLeaveApplicationRequest;
use Modules\HR\Http\Requests\Store\StoreLeaveApplicationRequest;
use Modules\HR\Http\Requests\Update\UpdateLeaveApplicationRequest;
use Modules\HR\Entities\LeaveApplication;
use Modules\HR\Entities\LeaveCategory;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\HR\Emails\LeaveRequest;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LeaveApplicationsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('leave_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LeaveApplication::with(['user', 'leave_category'])->select(sprintf('%s.*', (new LeaveApplication)->table));
            $table = Datatables::of($query);
            // dd($table);

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
            $table->addColumn('leave_category_name', function ($row) {
                return $row->leave_category ? $row->leave_category->name : '';
            });
            $table->editColumn('hours', function ($row) {
                return $row->hours ? $row->hours : "";
            });
            $table->editColumn('leave_start_date', function ($row) {
                return $row->leave_start_date ? $row->leave_start_date : "";
            });
            $table->editColumn('leave_end_date', function ($row) {
                return $row->leave_end_date ? $row->leave_end_date : "";
            });
            $table->editColumn('application_status', function ($row) {
                // STATUS_COLOR
                // return $row->application_status ? LeaveApplication::APPLICATION_STATUS_SELECT[$row->application_status] : '';
                return $row->application_status ? LeaveApplication::STATUS_COLOR[$row->application_status] : '';
            });
            $table->editColumn('leave_type', function ($row) {
                return $row->leave_type ? LeaveApplication::LEAVE_TYPE_SELECT[$row->leave_type] : '';
            });
            $table->editColumn('hours', function ($row) {
                return $row->hours ? $row->hours : "";
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user->accountDetail->fullname ?? '';
            });

            $table->rawColumns(['actions', 'placeholder', 'leave_category', 'user']);

            return $table->make(true);
        }

        return view('hr::admin.leaveApplications.index');
    }

    public function create()
    {
        abort_if(Gate::denies('leave_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = AccountDetail::all()->pluck('fullname', 'user_id')->prepend(trans('global.pleaseSelect'), '');

        $leave_categories = LeaveCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('hr::admin.leaveApplications.create', compact('users', 'leave_categories'));
    }

    public function store(StoreLeaveApplicationRequest $request)
    {
        $leaveApplication = new LeaveApplication();
        if ($request->leave_type == 'single_day') {
            $leaveApplication->leave_end_date = $request->leave_start_date;
        }
        if ($request->leave_type == 'multi_days') {
            $this->validate($request, ['leave_end_date' => 'required'], ['leave_end_date.required' => trans('cruds.leaveApplication.fields.required_end_date')]);
        }
        if ($request->leave_type == 'hours') {
            $this->validate($request, ['hours' => 'required']);
        }
        $leaveApplication = LeaveApplication::create($request->all());

        if ($request->input('attachments', false)) {
            $leaveApplication->addMedia(storage_path('tmp/uploads/' . $request->input('attachments')))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $leaveApplication->id]);
        }

        $leave_category = LeaveCategory::where('id', $leaveApplication->leave_category_id)->first()->name;
        Mail::to('marwa120640@gmail.com')->cc("marwa120640@gmail.com")
                ->send(new LeaveRequest($leaveApplication, $leaveApplication->user_id, $leave_category));
        // dd(new LeaveRequest($leaveApplication));
        // foreach (['marwa120640@gmail.com'] as $recipient) {
        //     Mail::to($recipient)->cc("marwa120640@gmail.com")
        //         ->send(new LeaveRequest($leaveApplication));
        // }
        return redirect()->route('hr.admin.leave-applications.index');
    }

    public function edit(LeaveApplication $leaveApplication)
    {
        abort_if(Gate::denies('leave_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $users = User::where('banned', 0)->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = AccountDetail::where('employment_id', '!=', null)->get()->pluck('fullname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_categories = LeaveCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $leaveApplication->load('user', 'leave_category');

        return view('hr::admin.leaveApplications.edit', compact('users', 'leave_categories', 'leaveApplication'));
    }

    public function update(UpdateLeaveApplicationRequest $request, LeaveApplication $leaveApplication)
    {
        $leaveApplication->update($request->all());

        if ($request->input('attachments', false)) {
            if (!$leaveApplication->attachments || $request->input('attachments') !== $leaveApplication->attachments->file_name) {
                if ($leaveApplication->attachments) {
                    $leaveApplication->attachments->delete();
                }
                // $mediaItem = $leaveApplication->getMedia('leaveRequest')->first();
                // $mediaItem->copy($leaveApplication, 'attachments');
                $leaveApplication->addMedia(storage_path('tmp\uploads\\' . $request->input('attachments')))->toMediaCollection('attachments');
                // $leaveApplication->addMedia($request->input('attachments'))->toMediaCollection('attachments');

                // $leaveApplication->copy($leaveApplication, 'attachments');
                // dd($leaveApplication);
            }
        } elseif ($leaveApplication->attachments) {
            $leaveApplication->attachments->delete();
        }

        return redirect()->route('hr.admin.leave-applications.index');
    }

    public function show(LeaveApplication $leaveApplication)
    {
        abort_if(Gate::denies('leave_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $array = explode('.', $leaveApplication->attachments->getUrl());
        // $extension = strtolower(end($array));
        // dd($extension);
        $attachment = str_replace('storage', 'storage/app/public', $leaveApplication->attachments->getUrl());

        // $v = str_replace(env('APP_URL').'/storage', env('APP_URL').'/storage/app/public', $leaveApplication->attachments->getUrl());
        // dd($v);
        // dd($leaveApplication->attachments->getUrl());
        // dd(env('APP_URL'));

        $leaveApplication->load('user', 'leave_category');

        return view('hr::admin.leaveApplications.show', compact('leaveApplication', 'attachment'));
    }

    public function destroy(LeaveApplication $leaveApplication)
    {
        abort_if(Gate::denies('leave_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveApplication->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeaveApplicationRequest $request)
    {
        LeaveApplication::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('leave_application_create') && Gate::denies('leave_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LeaveApplication();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
