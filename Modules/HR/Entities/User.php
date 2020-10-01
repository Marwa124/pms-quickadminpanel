<?php

namespace Modules\HR\Entities;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, Notifiable, HasApiTokens, HasMediaTrait;

    public $table = 'users';

    public static $searchable = [
        'name',
    ];

    const BANNED_RADIO = [
        '1' => 'Banned',
        '0' => 'Not Banned',
    ];

    const ONLINE_TIME_RADIO = [
        '1' => 'online',
        '0' => 'offline',
    ];

    const ACTIVATED_RADIO = [
        '1' => 'Activated',
        '0' => 'Not Activated',
    ];

    protected $hidden = [
        'remember_token',
        'password',
        'smtp_password',
        'marketing_password',
        'sp_password',
    ];

    protected $dates = [
        'email_verified_at',
        'last_login',
        'date_of_join',
        'date_of_insurance',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'username',
        'activated',
        'banned',
        'ban_reason',
        'last_ip',
        'last_login',
        'online_time',
        'smtp_email_type',
        'smtp_encription',
        'smtp_action',
        'smtp_host_name',
        'smtp_user_name',
        'smtp_password',
        'smtp_port',
        'smtp_additional_flag',
        'last_postmaster_run',
        'media_path_slug',
        'marketting_username',
        'marketing_password',
        'marketing_type',
        'sp_username',
        'sp_password',
        'vacation_balance',
        'vacation_counterdown',
        'date_of_join',
        'date_of_insurance',
        'vacation_verified',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function departmentHeadDepartments()
    {
        return $this->hasMany(Department::class, 'department_head_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function userAccountDetails()
    {
        return $this->hasMany(AccountDetail::class, 'user_id', 'id');
    }

    public function userTrainings()
    {
        return $this->hasMany(Training::class, 'user_id', 'id');
    }

    public function userEmployeeAwards()
    {
        return $this->hasMany(EmployeeAward::class, 'user_id', 'id');
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getLastLoginAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setLastLoginAttribute($value)
    {
        // $this->attributes['last_login'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function premissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getDateOfJoinAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfJoinAttribute($value)
    {
        // $this->attributes['date_of_join'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateOfInsuranceAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfInsuranceAttribute($value)
    {
        // $this->attributes['date_of_insurance'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
