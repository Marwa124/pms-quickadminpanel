<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Deparrtment extends Model
{
    use SoftDeletes;

    public $table = 'deparrtments';

    protected $hidden = [
        'password',
    ];

    public static $searchable = [
        'department_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'department_name',
        'department_head_id',
        'email',
        'encryption',
        'host',
        'username',
        'password',
        'mailbox',
        'unread_email',
        'delete_email_after_import',
        'last_postmaster_run',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function departmentDesignations()
    {
        return $this->hasMany(Designation::class, 'department_id', 'id');
    }

    public function department_head()
    {
        return $this->belongsTo(User::class, 'department_head_id');
    }
}
