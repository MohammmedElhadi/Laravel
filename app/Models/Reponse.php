<?php

namespace App\Models;

use App\Notifications\ReponseNotification;
use App\Notifications\TypeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $guarded = [];
    /**
     * The Responder that belong to the Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function responder()
    {
        return $this->belongsTo(User::class ,'user_id');
    }
    /**
     * Get the demande that owns the Reponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function etat()
    {
        return $this->belongsTo(Etat::class);
    }
    public function notify_demander(){
        $demander = $this->demande->demander;
        $demander->notify(new ReponseNotification($this));
    }
}
