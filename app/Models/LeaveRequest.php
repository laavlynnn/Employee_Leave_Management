<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'leave_request_id';

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'leave_type_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'leave_request_id', 'leave_request_id');
    }

    public function getTotalDaysAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        return Carbon::parse($this->start_date)
            ->diffInDays(Carbon::parse($this->end_date)) + 1;
    }
}
