<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class publication extends Model
{
    use HasFactory;
    protected $table = 'publications';

    protected $fillable = ['disponibilite', 'contact'];
    public $timestamps = false;
}
