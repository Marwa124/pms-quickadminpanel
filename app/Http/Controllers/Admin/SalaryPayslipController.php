<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySalaryPayslipRequest;
use App\Http\Requests\StoreSalaryPayslipRequest;
use App\Http\Requests\UpdateSalaryPayslipRequest;
use App\Models\SalaryPayment;
use App\Models\SalaryPayslip;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalaryPayslipController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('salary_payslip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPayslips = SalaryPayslip::all();

        return view('admin.salaryPayslips.index', compact('salaryPayslips'));
    }

    public function create()
    {
        abort_if(Gate::denies('salary_payslip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salary_payments = SalaryPayment::all()->pluck('payment_amount', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.salaryPayslips.create', compact('salary_payments'));
    }

    public function store(StoreSalaryPayslipRequest $request)
    {
        $salaryPayslip = SalaryPayslip::create($request->all());

        return redirect()->route('admin.salary-payslips.index');
    }

    public function edit(SalaryPayslip $salaryPayslip)
    {
        abort_if(Gate::denies('salary_payslip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salary_payments = SalaryPayment::all()->pluck('payment_amount', 'id')->prepend(trans('global.pleaseSelect'), '');

        $salaryPayslip->load('salary_payment');

        return view('admin.salaryPayslips.edit', compact('salary_payments', 'salaryPayslip'));
    }

    public function update(UpdateSalaryPayslipRequest $request, SalaryPayslip $salaryPayslip)
    {
        $salaryPayslip->update($request->all());

        return redirect()->route('admin.salary-payslips.index');
    }

    public function show(SalaryPayslip $salaryPayslip)
    {
        abort_if(Gate::denies('salary_payslip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPayslip->load('salary_payment');

        return view('admin.salaryPayslips.show', compact('salaryPayslip'));
    }

    public function destroy(SalaryPayslip $salaryPayslip)
    {
        abort_if(Gate::denies('salary_payslip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPayslip->delete();

        return back();
    }

    public function massDestroy(MassDestroySalaryPayslipRequest $request)
    {
        SalaryPayslip::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
