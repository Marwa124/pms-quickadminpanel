<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAcountRequest;
use App\Http\Requests\StoreAcountRequest;
use App\Http\Requests\UpdateAcountRequest;
use App\Models\Acount;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcountsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('acount_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acounts = Acount::all();

        $permissions = Permission::get();

        return view('admin.acounts.index', compact('acounts', 'permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('acount_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $premissions = Permission::all()->pluck('title', 'id');

        return view('admin.acounts.create', compact('premissions'));
    }

    public function store(StoreAcountRequest $request)
    {
        $acount = Acount::create($request->all());
        $acount->premissions()->sync($request->input('premissions', []));

        return redirect()->route('admin.acounts.index');
    }

    public function edit(Acount $acount)
    {
        abort_if(Gate::denies('acount_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $premissions = Permission::all()->pluck('title', 'id');

        $acount->load('premissions');

        return view('admin.acounts.edit', compact('premissions', 'acount'));
    }

    public function update(UpdateAcountRequest $request, Acount $acount)
    {
        $acount->update($request->all());
        $acount->premissions()->sync($request->input('premissions', []));

        return redirect()->route('admin.acounts.index');
    }

    public function show(Acount $acount)
    {
        abort_if(Gate::denies('acount_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acount->load('premissions');

        return view('admin.acounts.show', compact('acount'));
    }

    public function destroy(Acount $acount)
    {
        abort_if(Gate::denies('acount_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acount->delete();

        return back();
    }

    public function massDestroy(MassDestroyAcountRequest $request)
    {
        Acount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
