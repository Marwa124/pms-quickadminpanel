<?php

namespace App\Http\Requests;

use App\Models\TaskAttachment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTaskAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('task_attachment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:task_attachments,id',
        ];
    }
}
