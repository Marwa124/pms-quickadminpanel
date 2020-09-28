<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeparrtmentRequest;
use App\Http\Requests\UpdateDeparrtmentRequest;
use App\Http\Resources\Admin\DeparrtmentResource;
use App\Models\Deparrtment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeparrtmentsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deparrtment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeparrtmentResource(Deparrtment::with(['department_head'])->get());
    }

    public function store(StoreDeparrtmentRequest $request)
    {
        $deparrtment = Deparrtment::create($request->all());

        return (new DeparrtmentResource($deparrtment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Deparrtment $deparrtment)
    {
        abort_if(Gate::denies('deparrtment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeparrtmentResource($deparrtment->load(['department_head']));
    }

    public function update(UpdateDeparrtmentRequest $request, Deparrtment $deparrtment)
    {
        $deparrtment->update($request->all());

        return (new DeparrtmentResource($deparrtment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Deparrtment $deparrtment)
    {
        abort_if(Gate::denies('deparrtment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deparrtment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
