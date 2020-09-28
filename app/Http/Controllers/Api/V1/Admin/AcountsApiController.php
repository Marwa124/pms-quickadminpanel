<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcountRequest;
use App\Http\Requests\UpdateAcountRequest;
use App\Http\Resources\Admin\AcountResource;
use App\Models\Acount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcountsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('acount_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AcountResource(Acount::with(['premissions'])->get());
    }

    public function store(StoreAcountRequest $request)
    {
        $acount = Acount::create($request->all());
        $acount->premissions()->sync($request->input('premissions', []));

        return (new AcountResource($acount))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Acount $acount)
    {
        abort_if(Gate::denies('acount_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AcountResource($acount->load(['premissions']));
    }

    public function update(UpdateAcountRequest $request, Acount $acount)
    {
        $acount->update($request->all());
        $acount->premissions()->sync($request->input('premissions', []));

        return (new AcountResource($acount))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Acount $acount)
    {
        abort_if(Gate::denies('acount_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acount->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
