<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInterestedInRequest;
use App\Http\Requests\StoreInterestedInRequest;
use App\Models\InterestedIn;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InterestedInController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('interested_in_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $interestedIns = InterestedIn::all();

        return view('admin.interestedIns.index', compact('interestedIns'));
    }

    public function create()
    {
        abort_if(Gate::denies('interested_in_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.interestedIns.create');
    }

    public function store(StoreInterestedInRequest $request)
    {
        $interestedIn = InterestedIn::create($request->all());

        return redirect()->route('admin.interested-ins.index');
    }

    public function destroy(InterestedIn $interestedIn)
    {
        abort_if(Gate::denies('interested_in_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $interestedIn->delete();

        return back();
    }

    public function massDestroy(MassDestroyInterestedInRequest $request)
    {
        InterestedIn::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
