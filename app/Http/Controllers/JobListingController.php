<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index()
    {
        // dd(Listing::with('profile')->get());
        $jobs = Listing::with('profile')->get();
        return view('home', compact('jobs'));
    }
}
