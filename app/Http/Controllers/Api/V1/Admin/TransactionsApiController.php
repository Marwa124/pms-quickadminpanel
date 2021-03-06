<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\Admin\TransactionResource;
use App\Models\Transaction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TransactionResource(Transaction::with(['project', 'account', 'invoice', 'payment_method', 'premissions', 'expense_category'])->get());
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->all());
        $transaction->premissions()->sync($request->input('premissions', []));

        if ($request->input('attachement', false)) {
            $transaction->addMedia(storage_path('tmp/uploads/' . $request->input('attachement')))->toMediaCollection('attachement');
        }

        return (new TransactionResource($transaction))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TransactionResource($transaction->load(['project', 'account', 'invoice', 'payment_method', 'premissions', 'expense_category']));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());
        $transaction->premissions()->sync($request->input('premissions', []));

        if ($request->input('attachement', false)) {
            if (!$transaction->attachement || $request->input('attachement') !== $transaction->attachement->file_name) {
                if ($transaction->attachement) {
                    $transaction->attachement->delete();
                }

                $transaction->addMedia(storage_path('tmp/uploads/' . $request->input('attachement')))->toMediaCollection('attachement');
            }
        } elseif ($transaction->attachement) {
            $transaction->attachement->delete();
        }

        return (new TransactionResource($transaction))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
