<?php

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

Route::middleware(['auth:sanctum'])->group(function () {

    //endpoints profil
    Route::get('/profils', "ProfilController@index");
    Route::get('/profil/{profil}', "ProfilController@show");
    Route::post('/profil', "ProfilController@store");
    Route::put('/profil/{profil}', "ProfilController@update");
    Route::delete('/profil/{profil}', "ProfilController@destroy");

    //endpoints education
    Route::get('/educations', "EducationController@index");
    Route::get('/education/{education}', "EducationController@show");
    Route::post('/education', "EducationController@store");
    Route::put('/education/{education}', "EducationController@update");
    Route::delete('/education/{education}', "EducationController@destroy");

    /**
     * Competences Endpoints
    */
    Route::get('/competences', "CompetenceController@index");
    Route::post('/competence', "CompetenceController@store");
    Route::get('/competence/{competence}', "CompetenceController@show");
    
    Route::put('/competence/{competence}', "CompetenceController@update");
    Route::delete('/competence/{competence}', "CompetenceController@destroy");

    //endpoint user
    Route::post('/user/picture', 'UtilisateurController@saveUserPicture');

    //Logout endpoint
    Route::get('/user/logout', 'UtilisateurController@logout');
});


Route::middleware(['auth:api'])->group(function (){
    Route::any('/refresh', "UtilisateurController@refresh");
});

//Inscription d'un utilisateur standart
Route::post('/user/create', 'UtilisateurController@store');
Route::post('/user/login', 'UtilisateurController@login');

//Gestion publique de l'utilisateur
Route::get('/users/{limit?}', 'UtilisateurController@lastProfil');

//Get user by id
Route::get('/user/{user}', 'UtilisateurController@getBydId');
