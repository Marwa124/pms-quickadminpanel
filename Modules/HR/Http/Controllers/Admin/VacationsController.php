<?php

namespace Modules\HR\Http\Controllers\Admin;

use Modules\HR\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Modules\HR\Http\Requests\Destroy\MassDestroyVacationRequest;
use Modules\HR\Http\Requests\Store\StoreVacationRequest;
use Modules\HR\Http\Requests\Update\UpdateVacationRequest;
use App\Models\User;
use Modules\HR\Entities\Vacation;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class VacationsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('vacation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vacations = Vacation::all();

        return view('admin.vacations.index', compact('vacations'));
    }

    public function create()
    {
        abort_if(Gate::denies('vacation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vacations.create', compact('users'));
    }

    public function store(StoreVacationRequest $request)
    {
        $vacation = Vacation::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $vacation->id]);
        }

        return redirect()->route('admin.vacations.index');
    }

    public function edit(Vacation $vacation)
    {
        abort_if(Gate::denies('vacation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vacation->load('user');

        return view('admin.vacations.edit', compact('users', 'vacation'));
    }

    public function update(UpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->update($request->all());

        return redirect()->route('admin.vacations.index');
    }

    public function show(Vacation $vacation)
    {
        abort_if(Gate::denies('vacation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vacation->load('user');

        return view('admin.vacations.show', compact('vacation'));
    }

    public function destroy(Vacation $vacation)
    {
        abort_if(Gate::denies('vacation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vacation->delete();

        return back();
    }

    public function massDestroy(MassDestroyVacationRequest $request)
    {
        Vacation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('vacation_create') && Gate::denies('vacation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Vacation();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
