<?php

namespace App\Http\Controllers\api;

use App\Events\NewDemandeAdded;
use App\Events\NewReponseAdded;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Image;
use App\Models\Reponse;
use App\Models\User;
use App\Notifications\ReponseNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demandes = Demande::orderBy('created_at', "desc")->get();
        $data = $this->getDemandesResponse($demandes);
        return $data;

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
        DB::beginTransaction();
        try {
            $demande = Demande::create([
                'user_id' => Auth::id(),
                'wilaya_id' => $request->wilaya,
                'etat_id' => $request->etat,
                'note' => $request->note
            ]);

            // $demande->addMedia($request->images)->preservingOriginal()->toMediaCollection('demand_images');
            if($request->images){
                foreach (explode(',' ,$request->images) as $key => $image) {
                    $demande->addMedia($image)->toMediaCollection('demand_images');
                }
            }
            $demande->types()->attach($request['type']);
            $demande->categories()->attach(explode(',' ,$request['categories']));
            if($request['subcategories']){$demande->subcategories()->attach(explode(',' ,$request['subcategories']));}
            if($request['subsubcategories']){$demande->subcategory2s()->attach(explode(',' ,$request['subsubcategories']));}
            if($request['marques']){$demande->marques()->attach(explode(',' ,$request['marques']));}
            if($request['modeles']){$demande->modeles()->attach(explode(',' ,$request['modeles']));}
            DB::commit();
        } catch (Exception $e) {
            return response()->json($e, 500);
            DB::rollBack();
        }
        if ($demande)
            $demande->notify_interresters();

        return response()->json($demande->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $demande = Demande::find($id)->get();
        $data = $this->getDemandesResponse($demande);
        return response()->json($data);
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
        Demande::find($id)->delete();
        return response()->json([], 200);
    }

    /**
     * show only my demandes
     */
    public function myDemandes()
    {
        $demandes = Auth::user()->demandes;
        $data = $this->getDemandesResponse($demandes);
        return $data;
    }
    /**
    show the demandes that I have seen*/
    public function DemandesVues()
    {
        $demandes = Auth::user()->viewedDemandes;
        $data = $this->getDemandesResponse($demandes);
        return $data;
    }
    /**
    show the demandes that I have liked*/
    public function DemandesAime()
    {
        $demandes = Auth::user()->viewedDemandes()->wherePivot('is_saved', 1)->get();
        $data = $this->getDemandesResponse($demandes);
        return $data;
    }

    public function Demandesrepondue()
    {
        $reponses = Auth::user()->reponses;
        $demandes = [];
        foreach ($reponses as $key => $reponse) {
            array_push($demandes , $reponse->demande);
        }
        $data = $this->getDemandesResponse($demandes);
        return $data;
    }




    public function SubmitOffer(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $offer = Reponse::create([
                'user_id' => Auth::id(),
                'demande_id' => $request->demande_id,
                'wilaya_id' => $request->wilaya_id,
                'etat_id' => $request->etat_id,
                'prix_offert' => $request->prix_offert,
                'note' => $request->note,
            ]);
            if($request->images !=""){
                foreach (explode(',' ,$request->images) as $key => $image) {
                    $offer->addMedia($image)->toMediaCollection('offer_images');
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json('error');
        }
        if ($offer) {
            $offer->notify_demander();
        }
        return response()->json($offer);
    }

    public function MarkAsSeen($id)
    {
        $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();

        if (!$viewedDemande) {
            Auth::user()->viewedDemandes()->attach([$id => ['is_saved' => false]]);
            $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();
        }
        return response()->json([
            'is_saved' => $viewedDemande->pivot->is_saved,
            'likes'    => Demande::find($id)->viewers()->wherePivot('is_saved', 1)->count()
        ]);


        $demande = Demande::findOrFail($id);
        $demande->viewers()->attach([Auth::id() => ['is_saved' => false]]);
        return ($demande->viewers[0]->pivot->is_saved);
    }

    public function ToggleSaved($id)
    {
        $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();

        if ($viewedDemande != null) {
            $viewedDemande->pivot->is_saved = !$viewedDemande->pivot->is_saved;
            $viewedDemande->pivot->save();
            return response()->json([
                'is_saved' => $viewedDemande->pivot->is_saved,
                'likes'    => Demande::find($id)->viewers()->wherePivot('is_saved', 1)->count()
            ]);
        } else {
            Auth::user()->viewedDemandes()->attach([$id => ['is_saved' => true]]);
            $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();
            return response()->json([
                'is_saved' => $viewedDemande->pivot->is_saved,
                'likes'    => Demande::find($id)->viewers()->wherePivot('is_saved', 1)->count()
            ]);
        }
    }


    private function getDemandesResponse( $demandes){
        $data = [];
        foreach ( $demandes as $demande) {
            $images = [];
            foreach ($demande->getMedia('demand_images') as $key => $image) {
                array_push( $images , ['imageURL' => $image->getFullUrl()]);
            }
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'categories' => $demande->categories ? $demande->categories : '',
                'subcategories' => $demande->subcategories ? $demande->subcategories : '',
                'subcategory2s' => $demande->subcategory2s ? $demande->subcategory2s : '',
                'marques' => $demande->marques ? $demande->marques : '',
                'modeles' => $demande->modeles ? $demande->modeles : '',
                'images' => $images,
                'responded' => Auth::user()->reponses()->where('demande_id' , $demande->id)->count()>0 ,
                "is_saved" => (Auth::check() and  $demande->viewers()->where('user_id', Auth::id())->count() > 0)
                    ?
                    $demande->viewers()->where('user_id', Auth::id())->first()->pivot->is_saved
                    :
                    false,
                'likes'   => $demande->viewers()->wherePivot('is_saved', 1)->count(),

            ]);
        }
        return $data;
    }
}
