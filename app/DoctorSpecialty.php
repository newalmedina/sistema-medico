<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorSpecialty extends Model
{

    protected $table = "doctor_specialties";
    protected $fillable = ["user_id", "specialty_id"];
}
