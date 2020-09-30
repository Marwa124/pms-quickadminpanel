<?php

namespace Modules\HR\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class AccountDetail extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'account_details';

    protected $appends = [
        'avatar',
    ];

    public static $searchable = [
        'fullname',
    ];

    const DIRECTION_RADIO = [
        'ltr' => 'LTR',
        'rtl' => 'RTL',
    ];

    const GENDER_RADIO = [
        'male'   => 'Male',
        'female' => 'Female',
    ];

    protected $dates = [
        'joining_date',
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MARITAL_STATUS_SELECT = [
        'unmarried' => 'Unmarried',
        'married'   => 'Married',
        'divorced'  => 'Divorced',
        'widower'   => 'Widower',
        'widow'     => 'Widow',
    ];

    protected $fillable = [
        'user_id',
        'fullname',
        'company',
        'city',
        'country',
        'locale',
        'address',
        'phone',
        'mobile',
        'skype',
        'language',
        'designation_id',
        'joining_date',
        'present_address',
        'date_of_birth',
        'gender',
        'marital_status',
        'father_name',
        'mother_name',
        'passport',
        'direction',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function getAvatarAttribute()
    {
        $file = $this->getMedia('avatar')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getJoiningDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
