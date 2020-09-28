<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySalaryPaymentAllowanceRequest;
use App\Http\Requests\StoreSalaryPaymentAllowanceRequest;
use App\Models\SalaryPayment;
use App\Models\SalaryPaymentAllowance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalaryPaymentAllowanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('salary_payment_allowance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPaymentAllowances = SalaryPaymentAllowance::all();

        return view('admin.salaryPaymentAllowances.index', compact('salaryPaymentAllowances'));
    }

    public function create()
    {
        abort_if(Gate::denies('salary_payment_allowance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salary_payments = SalaryPayment::all()->pluck('payment_amount', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.salaryPaymentAllowances.create', compact('salary_payments'));
    }

    public function store(StoreSalaryPaymentAllowanceRequest $request)
    {
        $salaryPaymentAllowance = SalaryPaymentAllowance::create($request->all());

        return redirect()->route('admin.salary-payment-allowances.index');
    }

    public function destroy(SalaryPaymentAllowance $salaryPaymentAllowance)
    {
        abort_if(Gate::denies('salary_payment_allowance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPaymentAllowance->delete();

        return back();
    }

    public function massDestroy(MassDestroySalaryPaymentAllowanceRequest $request)
    {
        SalaryPaymentAllowance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
