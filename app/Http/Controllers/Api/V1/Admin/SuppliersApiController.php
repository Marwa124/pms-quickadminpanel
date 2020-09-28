<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\Admin\SupplierResource;
use App\Models\Supplier;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuppliersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('supplier_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SupplierResource(Supplier::with(['customer_group', 'premissions'])->get());
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->all());
        $supplier->premissions()->sync($request->input('premissions', []));

        return (new SupplierResource($supplier))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SupplierResource($supplier->load(['customer_group', 'premissions']));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());
        $supplier->premissions()->sync($request->input('premissions', []));

        return (new SupplierResource($supplier))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $supplier->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
