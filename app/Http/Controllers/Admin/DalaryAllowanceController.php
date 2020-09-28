<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDalaryAllowanceRequest;
use App\Http\Requests\StoreDalaryAllowanceRequest;
use App\Models\DalaryAllowance;
use App\Models\SalaryTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DalaryAllowanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dalary_allowance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dalaryAllowances = DalaryAllowance::all();

        return view('admin.dalaryAllowances.index', compact('dalaryAllowances'));
    }

    public function create()
    {
        abort_if(Gate::denies('dalary_allowance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salary_templates = SalaryTemplate::all()->pluck('salary_grade', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dalaryAllowances.create', compact('salary_templates'));
    }

    public function store(StoreDalaryAllowanceRequest $request)
    {
        $dalaryAllowance = DalaryAllowance::create($request->all());

        return redirect()->route('admin.dalary-allowances.index');
    }

    public function destroy(DalaryAllowance $dalaryAllowance)
    {
        abort_if(Gate::denies('dalary_allowance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dalaryAllowance->delete();

        return back();
    }

    public function massDestroy(MassDestroyDalaryAllowanceRequest $request)
    {
        DalaryAllowance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
