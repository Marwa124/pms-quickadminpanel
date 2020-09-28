<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySalaryPaymentRequest;
use App\Http\Requests\StoreSalaryPaymentRequest;
use App\Http\Requests\UpdateSalaryPaymentRequest;
use App\Models\SalaryPayment;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SalaryPaymentsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('salary_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPayments = SalaryPayment::all();

        return view('admin.salaryPayments.index', compact('salaryPayments'));
    }

    public function create()
    {
        abort_if(Gate::denies('salary_payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.salaryPayments.create', compact('users'));
    }

    public function store(StoreSalaryPaymentRequest $request)
    {
        $salaryPayment = SalaryPayment::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $salaryPayment->id]);
        }

        return redirect()->route('admin.salary-payments.index');
    }

    public function edit(SalaryPayment $salaryPayment)
    {
        abort_if(Gate::denies('salary_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $salaryPayment->load('user');

        return view('admin.salaryPayments.edit', compact('users', 'salaryPayment'));
    }

    public function update(UpdateSalaryPaymentRequest $request, SalaryPayment $salaryPayment)
    {
        $salaryPayment->update($request->all());

        return redirect()->route('admin.salary-payments.index');
    }

    public function show(SalaryPayment $salaryPayment)
    {
        abort_if(Gate::denies('salary_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPayment->load('user');

        return view('admin.salaryPayments.show', compact('salaryPayment'));
    }

    public function destroy(SalaryPayment $salaryPayment)
    {
        abort_if(Gate::denies('salary_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryPayment->delete();

        return back();
    }

    public function massDestroy(MassDestroySalaryPaymentRequest $request)
    {
        SalaryPayment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('salary_payment_create') && Gate::denies('salary_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SalaryPayment();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
