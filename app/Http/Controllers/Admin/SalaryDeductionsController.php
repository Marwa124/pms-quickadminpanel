<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySalaryDeductionRequest;
use App\Http\Requests\StoreSalaryDeductionRequest;
use App\Models\SalaryDeduction;
use App\Models\SalaryTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalaryDeductionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('salary_deduction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryDeductions = SalaryDeduction::all();

        return view('admin.salaryDeductions.index', compact('salaryDeductions'));
    }

    public function create()
    {
        abort_if(Gate::denies('salary_deduction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salary_templates = SalaryTemplate::all()->pluck('salary_grade', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.salaryDeductions.create', compact('salary_templates'));
    }

    public function store(StoreSalaryDeductionRequest $request)
    {
        $salaryDeduction = SalaryDeduction::create($request->all());

        return redirect()->route('admin.salary-deductions.index');
    }

    public function destroy(SalaryDeduction $salaryDeduction)
    {
        abort_if(Gate::denies('salary_deduction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryDeduction->delete();

        return back();
    }

    public function massDestroy(MassDestroySalaryDeductionRequest $request)
    {
        SalaryDeduction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
