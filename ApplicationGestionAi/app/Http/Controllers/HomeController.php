<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $livres = Livre::where('rating', '>=', 4)
        ->take(12)
        ->get();        
        return view('HomePage.Home', compact('livres'));
    }
}
