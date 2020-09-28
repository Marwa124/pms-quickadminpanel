<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendancessRequest;
use App\Http\Requests\UpdateAttendancessRequest;
use App\Http\Resources\Admin\AttendancessResource;
use App\Models\Attendancess;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendancessApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendancess_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendancessResource(Attendancess::with(['user', 'leave_application'])->get());
    }

    public function store(StoreAttendancessRequest $request)
    {
        $attendancess = Attendancess::create($request->all());

        return (new AttendancessResource($attendancess))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Attendancess $attendancess)
    {
        abort_if(Gate::denies('attendancess_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendancessResource($attendancess->load(['user', 'leave_application']));
    }

    public function update(UpdateAttendancessRequest $request, Attendancess $attendancess)
    {
        $attendancess->update($request->all());

        return (new AttendancessResource($attendancess))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Attendancess $attendancess)
    {
        abort_if(Gate::denies('attendancess_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendancess->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
