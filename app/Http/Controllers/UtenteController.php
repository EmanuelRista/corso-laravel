<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtenteController extends Controller
{
    public function mostra($id = 'nessuno')
    {
        return 'Utente con id: ' . $id;
    }
}
