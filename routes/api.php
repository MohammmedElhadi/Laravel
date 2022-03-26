<?php

use api\TypeController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\auth\LoginController as Lcont;
use App\Http\Controllers\api\DemandeController;
use App\Http\Controllers\api\EtatController;
use App\Http\Controllers\api\MarqueController;
use App\Http\Controllers\api\ModeleController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\SubcategoryController;
use App\Http\Controllers\api\SubCategory2Controller;
use App\Http\Controllers\api\TypeController as ApiTypeController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ReponseController;
use App\Http\Controllers\api\WilayaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Broadcast;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//TODO:: Midlewares
Route::controller(MarqueController::class)->group(function () {
    Route::post('marque/modele', 'getModeles')->name('marque.modeles');
});
Route::controller(CategoryController::class)->group(function () {
    Route::post('category/subcategories', 'getSubCategories')->name('category.subcategories');
});
Route::controller(SubcategoryController::class)->group(function () {
    Route::post('subcategory/subcategory2s', 'getSubSubCategories')->name('subcategory.subcategory2s');
});
Route::controller(DemandeController::class)->group(function () {
    Route::post('demande/{id}/offer', 'SubmitOffer')->name('demande.offer');
    Route::get('demande/my_demandes', 'MyDemandes')->name('demande.mine');
    Route::get('demande/demandesvues', 'DemandesVues')->name('demande.mine');
    Route::get('demande/demandesaime', 'DemandesAime')->name('demande.mine');
    Route::get('demande/{id}/markAsSeen', 'MarkAsSeen')->name('demande.markAsSeen');
    Route::get('demande/{id}/ToggleSaved', 'ToggleSaved')->name('demande.ToggleSaved');

});
Route::controller(ReponseController::class)->group(function () {
    Route::get('reponse/{id}', 'getMyOffer');
    Route::get('reponse/{id}/all', 'getAllOffer');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::controller(Lcont::class)->group(function () {
    Route::post('/login', 'authenticate')->name('user.authenticate');
});

Route::controller(Lcont::class)->group(function () {
    Route::post('/logout', 'logout')->name('user.logout');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'store')->name('user.store');
});

    Route::resource('demande', DemandeController::class);
    Route::resource('type', ApiTypeController::class);
    Route::resource('marque', MarqueController::class);
    Route::resource('modele', ModeleController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubCategoryController::class);
    Route::resource('subcategory2', SubCategory2Controller::class);
    Route::resource('wilaya', WilayaController::class);
    Route::resource('etat', EtatController::class);
    Route::resource('reponse', ReponseController::class);
    Route::resource('notification', NotificationController::class);
