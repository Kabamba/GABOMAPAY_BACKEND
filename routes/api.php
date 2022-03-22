<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', function () {
    return User::all();
});

Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout')->middleware('auth:api');
Route::post('register', 'AuthController@register');
Route::post('forgot', 'AuthController@forgot');
Route::post('reset', 'AuthController@reset');
Route::post('profile', 'AuthController@profile');
Route::post('identite', 'AuthController@identite');

Route::post('paiement/recharge/gab', 'TransactionController@depot_gabon');
Route::post('paiement/success/gab', 'TransactionController@paie_success');

Route::post('paiement/retrait/rdc', 'TransactionController@retrait_rdc');
Route::post('paiement/envoie_compte_gabon', 'TransactionController@envoie_compte_gabon');
Route::post('paiement/envoie_gabon_rdc', 'TransactionController@envoie_gabon_rdc');
Route::post('paiement/envoie_compte_gabon_rdc', 'TransactionController@envoie_compte_gabon_rdc');
Route::post('paiement/envoie_noncompte_gabon_rdc', 'TransactionController@envoie_noncompte_gabon_rdc');

Route::post('paiement/envoie_compte_rdc', 'TransactionController@envoie_compte_rdc');
Route::post('paiement/envoie_noncompte_rdc', 'TransactionController@envoie_noncompte_rdc');
Route::post('paiement/envoie_rdc_gabon', 'TransactionController@envoie_rdc_gabon');
Route::post('paiement/recharge/rdc', 'TransactionController@depot_rdc');

Route::post('paiement/simuler', 'TransactionController@simulation');
Route::post('paiement/simulation/depot_rdc', 'TransactionController@simuler_depot_rdc');
Route::post('paiement/simulation/retrait_rdc', 'TransactionController@simuler_retrait_rdc');
Route::post('paiement/simulation/envoie_compte_rdc', 'TransactionController@simuler_compte_rdc');
Route::post('paiement/simulation/envoie_compte_rdc_gabon', 'TransactionController@simuler_compte_rdc_gabon');
Route::post('paiement/simulation/envoie_compte_gabon', 'TransactionController@simuler_compte_gabon');
Route::post('paiement/simulation/envoie_compte_gabon_rdc', 'TransactionController@simuler_compte_gabon_rdc');


Route::prefix('/admin')->group(function () {
    Route::get('admins/list', 'AdministrateurController@index');
    Route::get('admins/show/{id}', 'AdministrateurController@show');
    Route::post('admins/store', 'AdministrateurController@store');
    Route::post('admins/update', 'AdministrateurController@update');
    Route::get('admins/activate/{id}', 'AdministrateurController@activate');

    Route::get('users/list', 'UserController@index');
    Route::get('users/show/{id}', 'UserController@show');
    Route::get('users/activate/{id}', 'UserController@activate');

    Route::get('devises/list', 'DeviseController@index');
    Route::post('devises/store', 'DeviseController@store');
    Route::post('devises/update', 'DeviseController@update');
    Route::get('devises/show/{id}', 'DeviseController@show');
    Route::get('devises/activate/{id}', 'DeviseController@activate');

    Route::get('posts/list', 'PostController@index');
    Route::post('posts/store', 'PostController@store');
    Route::get('posts/show/{id}', 'PostController@show');
    Route::post('posts/update', 'PostController@update');
    Route::get('posts/activate/{id}', 'PostController@activate');

    Route::get('pays/list', 'CountryController@index');
    Route::get('pays/listoccupe', 'CountryController@listOccupe');
    Route::post('pays/store', 'CountryController@store');
    Route::get('pays/show/{id}', 'CountryController@show');
    Route::post('pays/update', 'CountryController@update');
    Route::get('pays/activate/{id}', 'CountryController@activate');

    Route::get('transactions/list', 'TransactionController@index');
    Route::get('transactions/limitation/{limit}', 'TransactionController@last');
    Route::get('transactions/show/{id}', 'TransactionController@show');
    Route::get('transactions/transacuser/{transac}/{user}', 'TransactionController@transacuser');
    Route::get('transactions/transac_user/{id}', 'TransactionController@transac_user');
    Route::get('transactions/transac_user_last/{id}', 'TransactionController@transac_user_last');
    
    Route::get('transactions/valider/{id}', 'TransactionController@valider');
    Route::post('transactions/invalider', 'TransactionController@invalider');
    Route::post('transactions/searchperdate', 'TransactionController@searchPerDate');
    Route::post('transactions/success', 'TransactionController@paie_success');
    Route::get('transactions/currenthirty', 'TransactionController@currenthirty');
    Route::get('transactions/listoday', 'TransactionController@listoday');
    Route::get('transactions/listinvalide', 'TransactionController@listinvalide');
    Route::get('transactions/listvalide', 'TransactionController@listvalide');

    Route::get('stats/usersnumber', 'StatistiqueController@nbreUsers');
    Route::get('stats/transacnumber', 'StatistiqueController@nbreTransac');
    Route::get('stats/depotnumber', 'StatistiqueController@nbreDepot');
    Route::get('stats/envoienumber', 'StatistiqueController@nbreEnvoie');

    Route::get('operators/list', 'OperatorController@index');
    Route::post('operators/store', 'OperatorController@store');
    Route::get('operators/show/{id}', 'OperatorController@show');
    Route::post('operators/update', 'OperatorController@update');
    Route::get('operators/activate/{id}', 'OperatorController@activate');

    Route::get('tarifs/list', 'tarifController@index');
    Route::post('tarifs/store', 'tarifController@store');
    Route::get('tarifs/show/{id}', 'tarifController@show');
    Route::post('tarifs/update', 'tarifController@update');
    Route::get('tarifs/activate/{id}', 'tarifController@activate');

    Route::get('taux/list', 'TauxController@index');
    Route::post('taux/update', 'TauxController@update');
    Route::get('taux/getaux/{id}', 'TauxController@getaux');

});
