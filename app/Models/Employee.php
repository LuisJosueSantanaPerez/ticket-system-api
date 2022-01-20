<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;

class Employee extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'number',
        'created_at',
        'first_name',
        'last_name',
        'password',
        'email',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
        'updated_at',
        'activated'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'timestamp',
        'activated' => 'boolean',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function timeEntry()
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function assigned() {
        return $this->belongsToMany(Ticket::class, "tracking_ticket_employees");
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->number = IdGenerator::generate(
                ['table' => 'employees', 'length' => 11, 'prefix' =>'EMPL-', 'field'=> 'number']
            );
        });
    }
}
