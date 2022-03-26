<?php

namespace App\Models;

use App\Events\NewDemandeAdded ;
use App\Notifications\CategoryNotification;
use App\Notifications\MarqueNotification;
use App\Notifications\ModeleNotification;
use App\Notifications\ReponseChoosenNotification;
use App\Notifications\SubcategoryNotification;
use App\Notifications\TypeNotification;
// use App\Notifications\PieceNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Demande extends Model
{
    use HasFactory;
    protected $guarded = [] ;


    public function categories()
    {
        return $this->morphedByMany(Category::class , 'demandable')->withTimestamps();
    }


    public function subcategories()
    {
        return $this->morphedByMany(Subcategory::class , 'demandable')->withTimestamps();
    }
    public function subcategory2s()
    {
        return $this->morphedByMany(Subcategory2::class , 'demandable')->withTimestamps();
    }
    public function modeles()
    {
        return $this->morphedByMany(Modele::class , 'demandable')->withTimestamps();
    }
    public function marques()
    {
        return $this->morphedByMany(Marque::class , 'demandable')->withTimestamps();
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function types()
    {
        return $this->morphedByMany(Type::class, 'demandable')->withTimestamps();
    }






    /**
     * The Demander that belong to the Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function demander()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    /**
     * The viewers that belong to the Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viewers()
    {
        return $this->belongsToMany(User::class, 'viewed_demandes', 'demande_id', 'user_id')
                                    ->withTimestamps()->withPivot(['is_saved']);
    }
    public function etat()
    {
        return $this->belongsTo(Etat::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    /**
     * Get the wilaya that owns the Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }
    /**
     * The pieces that belong to the Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    /**
     * Get all of the reponses for the Demande
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }





    public function notify_interresters()
    {
        $demander = $this->demander;
        $ids = [];
        $modeles = $this->modeles;
        $marques = $this->marques;
        $type  = $this->types[0];

        /**
         * les vendeur des pieces des voitures sont généralement specialisés dans quelque
         * categorie
         * alors que ceux des autres types englobe toutes les cat des piece
         * donc si le type  de la piece demandé s'agit d'une voitue on notifie selon la categorie
         * sinon on notifie tous les vendeur qui sont interessés par le type
         */

        if ($type->id == 2)  //  leger
        {/*
            if(count($this->subcategories))
            {
                $subcategory = $this->subcategories[0];
                foreach ($subcategory->interesters as $user)
                    {
                        if (!in_array($user->id , $ids) and $user->id != $demander->id
                            and ($user->modeles->intersect($modeles)->isNotEmpty()))
                        {

                            array_push($ids ,$user->id);
                            $user->notify(new ModeleNotification($this));
                        }
                        if (!in_array($user->id , $ids) and $user->id != $demander->id
                            and ($user->marques->intersect($marques)->isNotEmpty()))
                        {
                            array_push($ids ,$user->id);
                            $user->notify(new MarqueNotification($this));
                        }
                    }
            }
            if( count($this->categories))
            {

                $category = $this->categories[0];
                foreach ($category->interesters as $user)
                {
                    if (!in_array($user->id , $ids) and $user->id != $demander->id
                        and ($user->modeles->intersect($modeles)->isNotEmpty()))
                    {

                        array_push($ids ,$user->id);
                        $user->notify(new ModeleNotification($this));
                    }
                    if (!in_array($user->id , $ids) and $user->id != $demander->id
                    and ($user->marques->intersect($marques)->isNotEmpty()))
                    {
                        array_push($ids ,$user->id);
                        $user->notify(new MarqueNotification($this));
                    }
                }
            }
        */}

        else
            {
            foreach ($type->interesters as $user)
            {
                if (!in_array($user->id , $ids) and $user->id != $demander->id)
                {
                    array_push($ids ,$user->id);
                    $user->notify(new TypeNotification($this));
                    event(new NewDemandeAdded($this , $user->id));
                }
            }
            }
    }
// }
}
