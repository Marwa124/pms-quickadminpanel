<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAccountDetailRequest;
use App\Http\Requests\StoreAccountDetailRequest;
use App\Http\Requests\UpdateAccountDetailRequest;
use App\Models\AccountDetail;
use App\Models\Designation;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AccountDetailsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('account_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $accountDetails = AccountDetail::all();

        return view('admin.accountDetails.index', compact('accountDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('account_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::all()->pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.accountDetails.create', compact('users', 'designations'));
    }

    public function store(StoreAccountDetailRequest $request)
    {
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

        $accountDetail->load('user', 'designation');

        return view('admin.accountDetails.edit', compact('users', 'designations', 'accountDetail'));
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

        $accountDetail->load('user', 'designation', 'userUserAlerts');

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
