<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function demandes()
    {
        return $this->morphToMany(Demande::class , 'demandable')->withTimestamps();
    }

    public function interesters()
    {
        return $this->morphToMany(User::class , 'interrestable')->withTimestamps();
    }
    /**
     * Get the category that owns the Subcategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcategory2s()
    {
        return $this->hasMany(Subcategory2::class);
    }
}
