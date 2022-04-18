<?php

use api\TypeController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\auth\LoginController as Lcont;
use App\Http\Controllers\api\ContinentController;
use App\Http\Controllers\api\DemandeController;
use App\Http\Controllers\api\EtatController;
use App\Http\Controllers\api\FilterController;
use App\Http\Controllers\api\MarqueController;
use App\Http\Controllers\api\ModeleController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\ProfessionController;
use App\Http\Controllers\api\SubcategoryController;
use App\Http\Controllers\api\SubCategory2Controller;
use App\Http\Controllers\api\TypeController as ApiTypeController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ReponseController;
use App\Http\Controllers\api\StatController;
use App\Http\Controllers\api\WilayaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UploadController;
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
//TODO:: File uploads
Route::post('upload', [UploadController::class, 'upload']);
Route::delete('delete', [UploadController::class, 'delete']);
//TODO:: Midlewares
Route::controller(MarqueController::class)->group(function () {
    Route::post('marque/modele', 'getModeles');//('marque.modeles');

});
Route::controller(CategoryController::class)->group(function () {
    Route::post('category/subcategories', 'getSubCategories');//('category.subcategories');
});
Route::controller(FilterController::class)->group(function () {
    Route::get('type/{id}/demandes', 'showTypes');//('marque.modeles');
    Route::get('continent/{id}/demandes', 'showContinents');//('marque.modeles');
    Route::get('category/{id}/demandes', 'showCategories');//('marque.modeles');
    Route::get('subcategory/{id}/demandes', 'showSubcategories');//('marque.modeles');
    Route::get('subcategory2/{id}/demandes', 'showSubcategories2');//('marque.modeles');
    Route::get('marque/{id}/demandes', 'showMarques');//('marque.modeles');
    Route::get('modele/{id}/demandes', 'showModeles');//('marque.modeles');
    Route::get('wilaya/{id}/demandes', 'showWilayas');//('marque.modeles');
    Route::get('etat/{id}/demandes', 'showEtats');//('marque.modeles');
    Route::get('filter/{ids}', 'search');//('marque.modeles');
    Route::get('filter', 'index');//('marque.modeles');
});
Route::controller(SubcategoryController::class)->group(function () {
    Route::post('subcategory/subcategory2s', 'getSubSubCategories');//('subcategory.subcategory2s');

});
Route::controller(DemandeController::class)->group(function () {
    Route::post('demande/{id}/offer', 'SubmitOffer');//('demande.offer');
    Route::get('demande/my_demandes', 'MyDemandes');//('demande.mine');
    Route::get('demande/demandesvues', 'DemandesVues');//('demande.vue');
    Route::get('demande/demandesaime', 'DemandesAime');//('demande.aime');
    Route::get('demande/demandesrepondu', 'Demandesrepondue');//('demande.mine');
    Route::get('demande/{id}/markAsSeen', 'MarkAsSeen');//('demande.markAsSeen');
    Route::get('demande/{id}/ToggleSaved', 'ToggleSaved');//('demande.ToggleSaved');

});
Route::controller(ReponseController::class)->group(function () {
    Route::get('reponse/{id}', 'getMyOffer');
    Route::get('reponse/{id}/all', 'getAllOffer');

});
Route::controller(StatController::class)->group(function () {
    Route::get('stat', 'getStats');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::controller(Lcont::class)->group(function () {
    Route::post('/login', 'authenticate');//('user.authenticate');
    Route::post('/logout', 'logout');//('user.logout');
});
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notification/{id}', 'markAsRead');//('notification.markAsRead');
});
Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'store');//('user.store');
    Route::get('/user/profile', 'show');//('user.show');
    Route::put('/user/update/{id} ', 'update');//('user.show');
    Route::post('/user/lang/', 'language');//('user.language');
});

Route::resource('demande', DemandeController::class);
Route::resource('type', ApiTypeController::class);
Route::resource('profession', ProfessionController::class);
Route::resource('continent', ContinentController::class);
Route::resource('marque', MarqueController::class);
Route::resource('modele', ModeleController::class);
Route::resource('category', CategoryController::class);
Route::resource('subcategory', SubCategoryController::class);
Route::resource('subcategory2', SubCategory2Controller::class);
Route::resource('wilaya', WilayaController::class);
Route::resource('etat', EtatController::class);
Route::resource('reponse', ReponseController::class);
Route::resource('notification', NotificationController::class);


/**
 * Admin routes
 */
Route::group(['prefix'=>'admin'], function() {
    Route::resource('user', AdminUserController::class);
})
;
