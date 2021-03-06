<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Designation extends Model
{
    use SoftDeletes;

    public $table = 'designations';

    public static $searchable = [
        'designation_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'department_id',
        'designation_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function department()
    {
        return $this->belongsTo(Deparrtment::class, 'department_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
