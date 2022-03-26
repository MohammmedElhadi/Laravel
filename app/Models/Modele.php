<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
    /**
     * Get the marque that owns the Modele
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
    public function interesters()
    {
        return $this->morphToMany(User::class , 'interrestable')->withTimestamps();
    }

    public function demandes()
    {
        return $this->morphToMany(Demande::class , 'demandable')->withTimestamps();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
