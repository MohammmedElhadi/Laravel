<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Continent;
use App\Models\Demande;
use App\Models\Etat;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Subcategory;
use App\Models\Subcategory2;
use App\Models\Type;
use App\Models\Wilaya;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {
        //get the ids
        $marques_ids = json_decode(request()->query('marques'));
        $types_ids = json_decode(request()->query('types')) == null? [] : json_decode(request()->query('types'));
        $continents_ids = json_decode(request()->query('continents'));
        // dd($types_ids);
        //get  : if there is no item select * the table
        $types =      empty($types_ids)      ? Type::all()      :  array(Type::find($types_ids));
        $marques =    empty($marques_ids)    ? Marque::all()    :  Marque::find($marques_ids);
        $continents = empty($continents_ids) ? Continent::all() :  Continent::find($continents_ids);
        // dd( $demande->continents->intersect($continents)->isNotEmpty());
        //filter the demandes
        $demandes = Demande::orderBy('created_at' , 'desc')->get()->filter(function ($demande)
        use ($types, $marques, $continents) {
            return (
                ($demande->types->intersect($types)->isNotEmpty()
                    or
                    $demande->types->isEmpty()
                )
                and ($demande->marques->intersect($marques)->isNotEmpty()
                    or
                    $demande->marques->isEmpty()
                )
                and ($demande->continents->intersect($continents)->isNotEmpty()
                    or
                    $demande->continents->isEmpty()
                )
            );
        });

        $data = DemandeController::getDemandesResponseOLD($demandes);
        return $data;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTypes($id)
    {
        $type  = Type::find($id);
        $demandes = $type->demandes()->paginate(1);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showContinents($id)
    {
        $continent  = Continent::find($id);
        $demandes = $continent->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showCategories($id)
    {
        $category  = Category::find($id);
        $demandes = $category->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showSubcategories($id)
    {
        $subcategory  = Subcategory::find($id);
        $demandes = $subcategory->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showSubcategories2($id)
    {
        $subcategory2  = Subcategory2::find($id);
        $demandes = $subcategory2->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }

    public function showMarques($id)
    {
        $marque  = Marque::find($id);
        $demandes = $marque->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showModeles($id)
    {

        $modele  = Modele::find($id);
        $demandes = $modele->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showWilayas($id)
    {
        $wilaya  = Wilaya::find($id);
        $demandes = $wilaya->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }
    public function showEtats($id)
    {
        $etat  = Etat::find($id);
        $demandes = $etat->demandes()->paginate(10);
        $data = DemandeController::getDemandesResponse($demandes);
        return $data;
    }


    public function search()
    {
        dd(request()->query());
    }
}
