<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        if(count(User::where('phone' , $data['phone'])->get())>0){
            return response()->json(['message' => 'already_registred'] , 422);
        }
        DB::beginTransaction();
        $user =  User::create([
            'name' => $data['name'],
            // 'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'wilaya_id' => $data['wilaya']
        ]);
        $user->types()->attach($data['types']);
        $user->professions()->attach($data['professions']);
        $user->continents()->attach($data['continents']);
        $user->marques()->attach($data['marques']);
        $user->modeles()->attach($data['modeles']);
        $user->categories()->attach($data['categories']);
        $user->subcategories()->attach($data['subcategories']);
        $user->subcategories2()->attach($data['subsubcategories']);

        DB::commit();
        // Auth::login($user);
        return response()->json('created' , 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       $user = Auth::user();
       $user->categories->pluck('categories.id');
       $user->subcategories->pluck('subcategories.id');
       $user->subcategories2->pluck('subcategory2s.id');
       $user->types->pluck('types.id');
       $user->continents->pluck('continents.id');
       $user->marques->pluck('marques.id');
       $user->modeles->pluck('modeles.id');

       return response()->json($user, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function language(Request $lang)
    {
        $user = Auth::user();
        $user->lang = $lang->abr;
        $user->save();
        return response()->json(Auth::user()->lang , 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $data , $id)
    {
        $user = User::find($id);
        DB::beginTransaction();
        $user->update([
            'name' => $data['name'],
            // 'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'wilaya_id' => $data['wilaya']
        ]);
        $user->types()->sync($data['types']);
        $user->continents()->sync($data['continents']);
        $user->marques()->sync($data['marques']);
        $user->modeles()->sync($data['modeles']);
        $user->categories()->sync($data['categories']);
        $user->subcategories()->sync($data['subcategories']);
        $user->subcategories2()->sync($data['subsubcategories']);
        DB::commit();
        return response()->json(Auth::user());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeLang($lang){
       $user=  Auth::user();
       $user->update(['lang' => $lang]);
       return $user->lang;
    }
}
