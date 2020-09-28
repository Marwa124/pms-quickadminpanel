<?php

namespace App\Http\Requests;

use App\Models\JobApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreJobApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_application_create');
    }

    public function rules()
    {
        return [
            'job_circular_id' => [
                'required',
                'integer',
            ],
            'name'            => [
                'string',
                'required',
            ],
            'mobile'          => [
                'string',
                'nullable',
            ],
            'apply_date'      => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'send_email'      => [
                'string',
                'nullable',
            ],
            'interview_date'  => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
