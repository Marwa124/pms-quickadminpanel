<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJobCircularRequest;
use App\Http\Requests\StoreJobCircularRequest;
use App\Http\Requests\UpdateJobCircularRequest;
use App\Models\Designation;
use App\Models\JobCircular;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class JobCircularsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('job_circular_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobCirculars = JobCircular::all();

        return view('admin.jobCirculars.index', compact('jobCirculars'));
    }

    public function create()
    {
        abort_if(Gate::denies('job_circular_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::all()->pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.jobCirculars.create', compact('designations', 'permissions'));
    }

    public function store(StoreJobCircularRequest $request)
    {
        $jobCircular = JobCircular::create($request->all());
        $jobCircular->permissions()->sync($request->input('permissions', []));

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $jobCircular->id]);
        }

        return redirect()->route('admin.job-circulars.index');
    }

    public function edit(JobCircular $jobCircular)
    {
        abort_if(Gate::denies('job_circular_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::all()->pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $permissions = Permission::all()->pluck('title', 'id');

        $jobCircular->load('designation', 'permissions');

        return view('admin.jobCirculars.edit', compact('designations', 'permissions', 'jobCircular'));
    }

    public function update(UpdateJobCircularRequest $request, JobCircular $jobCircular)
    {
        $jobCircular->update($request->all());
        $jobCircular->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.job-circulars.index');
    }

    public function show(JobCircular $jobCircular)
    {
        abort_if(Gate::denies('job_circular_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobCircular->load('designation', 'permissions');

        return view('admin.jobCirculars.show', compact('jobCircular'));
    }

    public function destroy(JobCircular $jobCircular)
    {
        abort_if(Gate::denies('job_circular_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobCircular->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobCircularRequest $request)
    {
        JobCircular::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('job_circular_create') && Gate::denies('job_circular_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new JobCircular();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
