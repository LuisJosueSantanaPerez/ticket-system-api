<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class TimeEntryTicket extends Model
{
    //

    protected $table = "time_entry_ticket";

    protected $fillable = [
        'time_entry_id',
        'ticket_id',
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function timeEntry()
    {
        return $this->belongsToMany(TimeEntry::class);
    }
}
