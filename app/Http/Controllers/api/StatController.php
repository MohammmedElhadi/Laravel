<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Reponse;
use App\Models\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function getStats(){
        $nbr_dem = Demande::all()->count();
        $nbr_res = Reponse::all()->count();
        $nbr_users = User::all()->count();

        return response()->json(["demandes" => $nbr_dem,
                                 "offers" => $nbr_res,
                                 "users" => $nbr_dem]     , 200);

    }
}
