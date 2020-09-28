<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDalaryAllowanceRequest;
use App\Http\Resources\Admin\DalaryAllowanceResource;
use App\Models\DalaryAllowance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DalaryAllowanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dalary_allowance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DalaryAllowanceResource(DalaryAllowance::with(['salary_template'])->get());
    }

    public function store(StoreDalaryAllowanceRequest $request)
    {
        $dalaryAllowance = DalaryAllowance::create($request->all());

        return (new DalaryAllowanceResource($dalaryAllowance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(DalaryAllowance $dalaryAllowance)
    {
        abort_if(Gate::denies('dalary_allowance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dalaryAllowance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
