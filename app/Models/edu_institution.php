<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class edu_institution extends Model
{
    use HasFactory;
    protected $table = 'edu_institution';
    protected $primaryKey = 'name';
    public $incrementing = false;
}
