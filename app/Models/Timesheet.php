<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Calendar;

class Timesheet extends Model 
{
    //
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function departament(){
        return $this->belongsTo(Departament::class);
    }

    public function calendar(){
        return $this->belongsTo(Calendar::class);
    }
}
