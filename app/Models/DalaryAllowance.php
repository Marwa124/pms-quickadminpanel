<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class DalaryAllowance extends Model
{
    use SoftDeletes;

    public $table = 'dalary_allowances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'value',
        'salary_template_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function salary_template()
    {
        return $this->belongsTo(SalaryTemplate::class, 'salary_template_id');
    }
}
