<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    public $timestamps = false; //deshabilito esos dos campos created_at and updated_at
    protected $primaryKey = 'idMarca';
}
