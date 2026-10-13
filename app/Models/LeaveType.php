<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $primaryKey = 'leave_type_id';

    protected $fillable = [
        'leave_name',
        'leave_code',
        'description',
        'number_of_days',
        'eligibility',
        'status',
    ];

    public function leaveRequests()
    {
        return $this->hasMany(
            LeaveRequest::class,
            'leave_type_id',
            'leave_type_id'
        );
    }
}