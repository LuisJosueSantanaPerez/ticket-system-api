<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'date',
        'title',
        'description',
        'kind_id',
        'category_id',
        'priority_id',
        'status_id',
        'employee_id',
    ];

    protected $hidden = [
        'id',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'timestamp',
        'kind_id' => 'integer',
        'category_id' => 'integer',
        'priority_id' => 'integer',
        'status_id' => 'integer',
        'employee_id' => 'integer',
    ];

    public function timeEntry()
    {
        return $this->belongsToMany(TimeEntry::class);
    }

    public function trackingTicketEmployees()
    {
        return $this->hasMany(TrackingTicketEmployee::class);
    }

    public function kind()
    {
        return $this->belongsTo(Kind::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }


    public function employees() {
        return $this->belongsToMany(Employee::class, "tracking_ticket_employees");
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->number = IdGenerator::generate(
                ['table' => 'tickets', 'length' => 11, 'prefix' =>'#', 'field'=> 'number']
            );
        });
    }
}
