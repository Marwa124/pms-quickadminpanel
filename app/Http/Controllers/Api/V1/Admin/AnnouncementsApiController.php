<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Http\Resources\Admin\AnnouncementResource;
use App\Models\Announcement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('announcement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnnouncementResource(Announcement::with(['user'])->get());
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $announcement = Announcement::create($request->all());

        if ($request->input('attachements', false)) {
            $announcement->addMedia(storage_path('tmp/uploads/' . $request->input('attachements')))->toMediaCollection('attachements');
        }

        return (new AnnouncementResource($announcement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Announcement $announcement)
    {
        abort_if(Gate::denies('announcement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnnouncementResource($announcement->load(['user']));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update($request->all());

        if ($request->input('attachements', false)) {
            if (!$announcement->attachements || $request->input('attachements') !== $announcement->attachements->file_name) {
                if ($announcement->attachements) {
                    $announcement->attachements->delete();
                }

                $announcement->addMedia(storage_path('tmp/uploads/' . $request->input('attachements')))->toMediaCollection('attachements');
            }
        } elseif ($announcement->attachements) {
            $announcement->attachements->delete();
        }

        return (new AnnouncementResource($announcement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Announcement $announcement)
    {
        abort_if(Gate::denies('announcement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $announcement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
