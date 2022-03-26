<?php

namespace App\Http\Controllers\api;

use App\Events\NewDemandeAdded;
use App\Events\NewReponseAdded;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Image;
use App\Models\Reponse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
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

        $data = [];
        foreach (Demande::orderBy('created_at', "desc")->get() as $demande) {
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'categories' => $demande->categories ? $demande->categories : '',
                'subcategories' => $demande->subcategories ? $demande->subcategories: '',
                'subcategory2s' => $demande->subcategory2s ? $demande->subcategory2s : '',
                'marques' => $demande->marques ? $demande->marques : '',
                'modeles' => $demande->modeles ? $demande->modeles : '',
                'image' => $demande->image?  asset('storage/'.$demande->image->url) : 'https://www.swag.de/fileadmin/revolution/slide-content-3.png',
                "is_saved" => (Auth::check() and $demande->viewers()->wherePivot('user_id' ,Auth::id())->count() > 0) ?
                                $demande->viewers()->where('user_id', Auth::id())->first()->pivot->is_saved
                                :
                                false,
                'likes'   => $demande->viewers()->wherePivot('is_saved' , 1)->count(),
            ]);
        }
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
            //dd($request->demand);
            $demande = Demande::create([
                'user_id'=> Auth::id(),
                'wilaya_id' => $request->wilaya,
                // 'wilaya_id'=> Auth::user()->wilaya->id,
                'etat_id' => $request->etat,
                'note' => $request->note
            ]);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $url = $file->store('demandes');
                $image = Image::create([
                    'url' => $url,
                    'imageable_id' => $demande->id,
                    'imageable_type' => 'App\Models\Demande'
                ]);
            }


            $demande->categories()->attach($request['categories']);
            $demande->subcategories()->attach($request['subcategories']);
            $demande->subcategory2s()->attach($request['subsubcategories']);
            $demande->marques()->attach(($request['marques']));
            $demande->modeles()->attach(($request['modeles']));
            $demande->types()->attach($request['type']);

            $demande->notify_interresters();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
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
        $demande = Demande::find($id);
        $data = [];
        array_push($data, [
            'demande' => $demande,
            'type' => $demande->types ? $demande->types[0] : '',
            'categories' => $demande->categories ? $demande->categories : '',
            'subcategories' => $demande->subcategories ? $demande->subcategories: '',
            'subcategory2s' => $demande->subcategory2s ? $demande->subcategory2s : '',
            'marques' => $demande->marques ? $demande->marques : '',
            'modeles' => $demande->modeles ? $demande->modeles : '',
            'image' => $demande->image?  asset('storage/'.$demande->image->url) : 'https://www.swag.de/fileadmin/revolution/slide-content-3.png',
            "is_saved" => (     Auth::check() and  $demande->viewers()->where('user_id' ,Auth::id())->count() > 0)
                                              ?
                                              $demande->viewers()->where('user_id', Auth::id())->first()->pivot->is_saved
                                              :
                                              false,
                'likes'   => $demande->viewers()->wherePivot('is_saved' , 1)->count(),
        ]);
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
        //
    }

    /**
     * show only my demandes
     */
    public function myDemandes()
    {
        $demandes = Auth::user()->demandes;

        $data = [];
        foreach ($demandes as $demande) {
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'category' => $demande->categories ? $demande->categories->first() : '',
                'subcategory' => $demande->subcategories ? $demande->subcategories->first() : '',
                'subcategory2' => $demande->subcategory2s ? $demande->subcategory2s->first() : '',
                'marque' => $demande->marques ? $demande->marques->first() : '',
                'modele' => $demande->modeles ? $demande->modeles->first() : '',
            ]);
        }
        return $data;

    }
    /**
    show the demandes that I have seen*/
    public function DemandesVues()
    {
        // $demandes =  Auth::user()->demandes;
        $demandes = Auth::user()->viewedDemandes;
        $data = [];
        foreach ($demandes as $demande) {
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'categories' => $demande->categories ? $demande->categories : '',
                'subcategories' => $demande->subcategories ? $demande->subcategories: '',
                'subcategory2s' => $demande->subcategory2s ? $demande->subcategory2s : '',
                'marques' => $demande->marques ? $demande->marques : '',
                'modeles' => $demande->modeles ? $demande->modeles : '',
                'image' => $demande->image?  asset('storage/'.$demande->image->url) : 'https://www.swag.de/fileadmin/revolution/slide-content-3.png',
                "is_saved" => (Auth::check() and $demande->viewers()->wherePivot('user_id' ,Auth::id())->count() > 0) ?
                    $demande->viewers()->where('user_id', Auth::id())->first()->pivot->is_saved
                    :
                    false,
                'likes'   => $demande->viewers()->wherePivot('is_saved' , 1)->count(),
            ]);
        }
        return $data;

    }
/**
    show the demandes that I have liked*/
    public function DemandesAime()
    {
        $demandes = Auth::user()->viewedDemandes()->wherePivot('is_saved' , 1)->get();

        $data = [];
        foreach ($demandes as $demande) {
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'categories' => $demande->categories ? $demande->categories : '',
                'subcategories' => $demande->subcategories ? $demande->subcategories: '',
                'subcategory2s' => $demande->subcategory2s ? $demande->subcategory2s : '',
                'marques' => $demande->marques ? $demande->marques : '',
                'modeles' => $demande->modeles ? $demande->modeles : '',
                'image' => $demande->image?  asset('storage/'.$demande->image->url) : 'https://www.swag.de/fileadmin/revolution/slide-content-3.png',
                "is_saved" => (Auth::check() and $demande->viewers()->where('user_id' ,Auth::id())->first() ) ?
                    $demande->viewers()->where('user_id', Auth::id())->first()->pivot->is_saved
                    :
                    false,
                'likes'   => $demande->viewers()->wherePivot('is_saved' , 1)->count(),
            ]);
        }
        return $data;

    }

    public function SubmitOffer(Request $request)
    {
        DB::beginTransaction();
        try {
            $offer = Reponse::create([
                'user_id' => Auth::check() ? Auth::id() : 1,
                'demande_id' => $request->demande_id,
                'wilaya_id' => $request->wilaya_id,
                'etat_id' => $request->etat_id,
                'prix_offert' => $request->prix_offert,
                'note' => $request->note,
            ]);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $url = $file->store('reponses');
                $image = Image::create([
                    'url' => $url,
                    'imageable_id' => $offer->id,
                    'imageable_type' => 'App\Models\Reponse'
                ]);
            }

            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json('error');
        }
        $offer->notify_demander();
        event(new NewReponseAdded($offer));
        return response()->json($offer);
    }

    public function MarkAsSeen( $id){
        $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();

        if( ! $viewedDemande){
            Auth::user()->viewedDemandes()->attach( [$id =>['is_saved' => false] ]);
            $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();
        }
        return response()->json(['is_saved' => $viewedDemande->pivot->is_saved,
                                 'likes'    => Demande::find($id)->viewers()->wherePivot('is_saved' , 1)->count() ]);


        $demande = Demande::findOrFail($id);
        $demande->viewers()->attach( [Auth::id() => ['is_saved' => false]]);
        return ($demande->viewers[0]->pivot->is_saved);
    }

    public function ToggleSaved($id)
    {
        $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();

        if($viewedDemande != null) {
            $viewedDemande->pivot->is_saved = !$viewedDemande->pivot->is_saved;
            $viewedDemande->pivot->save();
            return response()->json(['is_saved' => $viewedDemande->pivot->is_saved,
                                     'likes'    => Demande::find($id)->viewers()->wherePivot('is_saved' , 1)->count() ]);
        }
        else{
            Auth::user()->viewedDemandes()->attach( [$id =>['is_saved' => true] ]);
            $viewedDemande = Auth::user()->viewedDemandes()->where('demande_id', $id)->first();
            return response()->json(['is_saved' => $viewedDemande->pivot->is_saved,
                                     'likes'    => Demande::find($id)->viewers()->wherePivot('is_saved' , 1)->count() ]);
        }

    }


}
