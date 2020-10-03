<?php

namespace Modules\HR\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class SetTime extends Model
{
    use SoftDeletes;

    public $table = 'set_times';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $time = [
        'in_time',
        'out_time',
    ];

    protected $fillable = [
		'user_id', 'in_time', 'out_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
