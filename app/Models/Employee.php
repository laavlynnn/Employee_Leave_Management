<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_initial',
        'street',
        'barangay',
        'city',
        'province',
        'zip_code',
        'birthdate',
        'email',
        'password',
        'contact_number',
        'department_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'password' => 'hashed',
    ];

    public function department()
    {
        return $this->belongsTo(
            Department::class,
            'department_id',
            'department_id'
        );
    }

    public function leaveRequests()
    {
        return $this->hasMany(
            LeaveRequest::class,
            'employee_id',
            'employee_id'
        );
    }

    public function approvals()
    {
        return $this->hasMany(
            Approval::class,
            'approver_id',
            'employee_id'
        );
    }

    public function getAgeAttribute()
    {
        return $this->birthdate
            ? Carbon::parse($this->birthdate)->age
            : null;
    }
}
