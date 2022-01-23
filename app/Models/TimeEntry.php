<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class TimeEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'time_entry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'id',
        'date_from',
        'date_to',
        'note',
        'ticket_id'
    ];

    protected $hidden = [
        'created_at'
    ];

    protected $dates = [
        'date_from',
        'date_to'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'date_from' => 'timestamp',
        'date_to' => 'timestamp',
    ];
    public function tickets()
    {
        return $this->belongsToMany(
            Ticket::class, 'time_entry_ticket',
            'time_entry_id', 'ticket_id')->withTimestamps();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
