<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Reponse;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReponseController extends Controller
{
    /**
     * get all the offers on my  demande
     */
    public function getAllOffer($demand_id)
    {
        // return response()->json($demand_id, 500);
        $data = [];
        $reponses = Demande::find($demand_id)->reponses()->orderBy('created_at',"desc")->get();
        foreach ($reponses as $reponse) {
            $images = [];
            foreach ($reponse->getMedia('offer_images') as $key => $image) {
                array_push( $images , ['imageURL' => $image->getFullUrl()]);
            }
            array_push($data, [
                "reponse" => $reponse,
                "etat" => $reponse->etat->nom_fr,
                "images" =>$images,
                "phone" => $reponse->responder->phone
            ]);
        }
        return response()->json($data);
    }

    /**
     * Get my offer on this demande
     */
    public static function getMyOffer($demand_id)
    {

        $reponse = Demande::find($demand_id)->reponses()->where('user_id', Auth::id())->first();
        $images = [];
            foreach ($reponse->getMedia('offer_images') as $key => $image) {
                array_push( $images , ['imageURL' => $image->getFullUrl()]);
            }
        if ($reponse) {
            // $url = $reponse->demande->getMedia()[0]->getUrl();
            return response()->json([
                "reponse" => $reponse,
                "images" => $images
            ]);
        }
        return response()->json(['message' => 'Not Found!'], 404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $reponses = Demande::find($id)->reponses();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reponse = Reponse::find($id);
        if ($reponse) {
            if ($reponse->image) {
                $reponse->image->deleteImage();
                $reponse->image->delete();
            }
            $reponse->delete();
        }
        return response()->json(true);
    }
}
