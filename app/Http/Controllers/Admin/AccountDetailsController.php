<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAccountDetailRequest;
use App\Http\Requests\StoreAccountDetailRequest;
use App\Http\Requests\UpdateAccountDetailRequest;
use App\Models\AccountDetail;
use Modules\HR\Entities\Designation;
use Modules\HR\Entities\SetTime;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Modules\HR\Entities\Department;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AccountDetailsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('account_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $accountDetails = AccountDetail::all();
        $accountDetails = [];
        // $users = User::where('banned', 0)->get();
        $users = User::all();

        // if (request()->selectFilter) {
        //     $users = User::where('banned', 1)->get();
        // }

        foreach ($users as $key => $value) {
            $accountDetails[] = $value->accountDetail()->first();
        }
        // dump($accountDetails);

        return view('admin.accountDetails.index', compact('accountDetails'));
    }

    public function filterSelect(Request $request)
    {
        $banned = $request->selectFilter == 'active' ? 0 : 1;
        $users = User::where('banned', $banned)->get();
        foreach ($users as $key => $value) {
            $accountDetails[] = $value->accountDetail()->first();
        }

        return view('admin.accountDetails.filter', compact('accountDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('account_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::all()->pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $set_times = SetTime::all()->pluck('name', 'id')->prepend(trans('global.timeTableSelect'), '');

        return view('admin.accountDetails.create', compact('users', 'designations', 'set_times'));
    }

    public function store(StoreAccountDetailRequest $request)
    {
        $departmentId = Designation::find($request->designation_id)->department()->first()->id;
        $incrementId = Designation::find($request->designation_id)->accountDetails()->get()->count()+1;

        $request['employment_id'] = $departmentId . sprintf('%02d', $incrementId+1);

        $accountDetail = AccountDetail::create($request->all());

        if ($request->input('avatar', false)) {
            $accountDetail->addMedia(storage_path('tmp/uploads/' . $request->input('avatar')))->toMediaCollection('avatar');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $accountDetail->id]);
        }

        return redirect()->route('admin.account-details.index');
    }

    public function edit(AccountDetail $accountDetail)
    {
        abort_if(Gate::denies('account_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::all()->pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $set_times = SetTime::all()->pluck('name', 'id')->prepend(trans('global.timeTableSelect'), '');

        $accountDetail->load('user', 'designation');

        return view('admin.accountDetails.edit', compact('users', 'designations', 'accountDetail', 'set_times'));
    }

    public function update(UpdateAccountDetailRequest $request, AccountDetail $accountDetail)
    {
        $accountDetail->update($request->all());

        if ($request->input('avatar', false)) {
            if (!$accountDetail->avatar || $request->input('avatar') !== $accountDetail->avatar->file_name) {
                if ($accountDetail->avatar) {
                    $accountDetail->avatar->delete();
                }

                $accountDetail->addMedia(storage_path('tmp/uploads/' . $request->input('avatar')))->toMediaCollection('avatar');
            }
        } elseif ($accountDetail->avatar) {
            $accountDetail->avatar->delete();
        }

        return redirect()->route('admin.account-details.index');
    }

    public function show(AccountDetail $accountDetail)
    {
        abort_if(Gate::denies('account_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $accountDetail->load('user', 'designation', 'userUserAlerts');
        $accountDetail->load('user', 'designation', 'setTime');

        return view('admin.accountDetails.show', compact('accountDetail'));
    }

    public function destroy(AccountDetail $accountDetail)
    {
        abort_if(Gate::denies('account_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $accountDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyAccountDetailRequest $request)
    {
        AccountDetail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('account_detail_create') && Gate::denies('account_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AccountDetail();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
