<?php

namespace Modules\HR\Http\Requests\Update;

use Modules\HR\Entities\ClientMeeting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateClientMeetingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_request_edit');
    }

    public function rules()
    {
        return [
            'status' => [
                'string',
                'required',
            ],
            'approved_by' => [
                'string',
                'nullable',
            ],
            'encryption'      => [
                'string',
                'nullable',
            ],
            'host'            => [
                'string',
                'nullable',
            ],
        ];
    }
}
