<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function about(): View {
        return view('pages.about');
    }

    public function contact(): View {
        return view('pages.contact');
    }

    public function blog(): View {
        return view('pages.blog');
    }

    public function staff(): View {

        $staff = User::all();
        $title = 'Il nostro staff';
        return view('pages.staff')->with(['staff' => $staff, 'title' => $title]);
    }

}
