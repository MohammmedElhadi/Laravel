<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }
}
