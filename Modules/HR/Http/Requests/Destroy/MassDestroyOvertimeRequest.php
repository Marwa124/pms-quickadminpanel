<?php

namespace App\Http\Requests\Destroy;

use App\Models\Overtime;
namespace Modules\HR\Http\Requests;

use Modules\HR\Entities\MeetingMinute;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOvertimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('overtime_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:overtimes,id',
        ];
    }
}
