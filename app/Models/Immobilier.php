<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Immobilier extends Model
{
    use HasFactory;
    protected $table='immobiliers';
    protected $fillable = ['images', 'datedebut', 'ville', 'status', 'typologie', 'droitvisite', 'description', 'user_id'];
    protected $primaryKey = 'Num_immobil';
    public $timestamps = false;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visites(): HasMany
    {
        return $this->hasMany(Visite::class,  'imm_id', 'Num_immobil');
    }
}
