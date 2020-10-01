<?php

namespace Modules\HR\Http\Requests\Store;

use Modules\HR\Entities\ClientMeeting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClientMeetingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_request_create');
    }

    public function rules()
    {
        return [
            'user_id'     => [
                'required',
                'integer',
            ],
            'from_time'    => [
                'time',
                'nullable',
            ],
            'to_time'   => [
                'time',
                'nullable',
            ],
            'comments'     => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'day' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
