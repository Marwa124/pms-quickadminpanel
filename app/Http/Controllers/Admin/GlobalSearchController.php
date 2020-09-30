<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    private $models = [
        'User'           => 'cruds.user.title',
        'Employee'       => 'cruds.employee.title',
        'TimeWorkType'   => 'cruds.timeWorkType.title',
        'Department'    => 'cruds.department.title',
        'Designation'    => 'cruds.designation.title',
        'AccountDetail'  => 'cruds.accountDetail.title',
        'Holiday'        => 'cruds.holiday.title',
        'Training'       => 'cruds.training.title',
        'LeaveCategory'  => 'cruds.leaveCategory.title',
        'MeetingMinute'  => 'cruds.meetingMinute.title',
        'EmployeeAward'  => 'cruds.employeeAward.title',
        'JobCircular'    => 'cruds.jobCircular.title',
        'JobApplication' => 'cruds.jobApplication.title',
        'Lead'           => 'cruds.lead.title',
        'Opportunity'    => 'cruds.opportunity.title',
        'Client'         => 'cruds.client.title',
        'ClientMenu'     => 'cruds.clientMenu.title',
        'Project'        => 'cruds.project.title',
        'Acount'         => 'cruds.acount.title',
        'Bug'            => 'cruds.bug.title',
        'Announcement'   => 'cruds.announcement.title',
        'EmployeeBank'   => 'cruds.employeeBank.title',
    ];

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search === null || !isset($search['term'])) {
            abort(400);
        }

        $term           = $search['term'];
        $searchableData = [];

        foreach ($this->models as $model => $translation) {
            $modelClass = 'App\\Models\\' . $model;
            $query      = $modelClass::query();

            $fields = $modelClass::$searchable;

            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', '%' . $term . '%');
            }

            $results = $query->take(10)
                ->get();

            foreach ($results as $result) {
                $parsedData           = $result->only($fields);
                $parsedData['model']  = trans($translation);
                $parsedData['fields'] = $fields;
                $formattedFields      = [];

                foreach ($fields as $field) {
                    $formattedFields[$field] = Str::title(str_replace('_', ' ', $field));
                }

                $parsedData['fields_formated'] = $formattedFields;

                $parsedData['url'] = url('/admin/' . Str::plural(Str::snake($model, '-')) . '/' . $result->id . '/edit');

                $searchableData[] = $parsedData;
            }
        }

        return response()->json(['results' => $searchableData]);
    }
}
