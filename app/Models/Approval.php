<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'leave_request_id',
        'approver_id',
        'approval_date',
        'approval_status',
        'remarks',
        'approval_level',
    ];

    protected $casts = [
        'approval_date' => 'date',
    ];

    /**
     * Get the leave request associated with this approval.
     */
    public function leaveRequest()
    {
        return $this->belongsTo(
            LeaveRequest::class,
            'leave_request_id',
            'leave_request_id'
        );
    }

    /**
     * Get the employee who approved or rejected the request.
     */
    public function approver()
    {
        return $this->belongsTo(
            Employee::class,
            'approver_id',
            'employee_id'
        );
    }
}