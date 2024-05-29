<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visite extends Model
{
    use HasFactory;
    protected $table = 'visites';

    protected $fillable = ['dates', 'heure', 'nom', 'email', 'user_id', 'imm_id' ];
    protected $primaryKey = 'Num_visite';
    public $timestamps = false;
    public function immobilier(): BelongsTo
    {
        return $this->belongsTo(Immobilier::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
