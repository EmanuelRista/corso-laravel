<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtenteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return 'Questo è un test!';
});

Route::get('/dati', function () {
    return ['nome' => 'Mario', 'cognome' => 'Rossi'];
});

/* Route::get('/utente/{id}', function ($id = 'nessuno') {
    return 'Utente con id: ' . $id;
}); */

Route::get('/utente/{id?}', [UtenteController::class, 'mostra']);

Route::get('/contatti', function () {
    return 'Pagina dei contatti';
})->name('contatti');

//$urlContatti = route('contatti'); //output: /contatti
