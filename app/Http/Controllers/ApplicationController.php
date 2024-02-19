<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\List_;

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

    public function show(Listing $listing)
    {
        $listing = Listing::with('users')->where('slug', $listing->slug)->first();
        return view('applicants.show', compact('listing'));
    }

    public function shortlist($listingId, $userId)
    {
        $listing = Listing::find($listingId);
        if ($listing) {
            $listing->users()->updateExistingPivot($userId, ['shortlisted' => true]);
            return back()->with('success', 'User shortlisted successfully');
        }
        return back()->with('error', 'An error occurred');
    }
}
