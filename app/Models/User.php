<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the country that owns the user.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the state that owns the user.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the city that owns the user.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the calendars and departaments that owns the user.
     */
    public function calendars(){
        return $this->belongsToMany(Calendar::class, 'table_user_calendar', 'user_id', 'calendar_id');
    }

    /**
     * Get the departaments that owns the user.
     */
    public function departaments(){
        return $this->belongsToMany(Departament::class, 'table_user_departament', 'user_id', 'departament_id');
    }

    /**
     * Get the holidays that owns the user.
     */
    public function holidays(){
        return $this->hasMany(Holiday::class);
    }

    /**
     * Get the timesheets that owns the user.
     */
    public function timesheets(){
        return $this->hasMany(Timesheet::class);
    }

}
