<?php

use App\Http\Controllers\ApiDocController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\IsEquipeConnected;
use App\Models\Equipe;
use App\Models\Membre;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\Route;

include('inc/api.php');

// Routes de base
Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/hackathon', [MainController::class, 'hackathon'])->name('hackathon');


// Routes d'authentification et de gestion d'équipe
Route::get('/login', [EquipeController::class, 'login'])->name('login');
Route::post('/login', [EquipeController::class, 'connect'])->name('connect');
Route::get('/join', [HackathonController::class, 'join'])->name('join');
Route::any('/create-team', [EquipeController::class, 'create'])->name('create-team'); // Any pour gérer les GET et POST
Route::get('/memberequipe', function () {
    $membres = Membre::all();

    return view('memberequipe', [
        'memberequipe' => $membres
    ]);
});

// Routes de l'API pour la documentation et les listes
Route::get('/doc-api/', [ApiDocController::class, 'liste'])->name('doc-api');
Route::get('/doc-api/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
Route::get('/doc-api/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
Route::get('/doc-api/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');

// Routes protégées nécessitant une session active, pour les équipes.
// Proctection par le middleware IsEquipeConnected (voir app/Http/Middleware/IsEquipeConnected.php)
Route::middleware(isEquipeConnected::class)->group(function () {
    Route::get('/logout', [EquipeController::class, 'logout'])->name('logout');
    Route::get('/me', [EquipeController::class, 'me'])->name('me');
    Route::post('/membre/add', [EquipeController::class, 'addMembre'])->name('membre-add');
});
