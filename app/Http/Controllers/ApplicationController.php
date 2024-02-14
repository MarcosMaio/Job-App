<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index()
    {
        $listings = Listing::latest()->withCount('users')->where('user_id', auth()->user()->id)->get();
        // dd($listings->pluck('id'));
        // $records = DB::table('listing_user')->whereIn('listing_id', $listings->pluck('id'))->get();
        // dd($records);

        return view('applicants.index', compact('listings'));
    }
}
