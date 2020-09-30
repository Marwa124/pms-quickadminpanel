<?php

namespace Modules\HR\Http\Requests\Update;

use Modules\HR\Entities\MeetingMinute;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMeetingMinuteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('meeting_minute_edit');
    }

    public function rules()
    {
        return [
            'user_id'  => [
                'required',
                'integer',
            ],
            'name'     => [
                'string',
                'required',
            ],
            'location' => [
                'string',
                'nullable',
            ],
        ];
    }
}
