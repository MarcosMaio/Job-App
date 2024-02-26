<?php

namespace App\Http\Controllers;

use App\Mail\ShortListMail;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $this->authorize('view', $listing);

        $listing = Listing::with('users')->where('slug', $listing->slug)->first();
        return view('applicants.show', compact('listing'));
    }

    public function shortlist($listingId, $userId)
    {
        $user = User::find($userId);
        $listing = Listing::find($listingId);
        if ($listing) {
            $listing->users()->updateExistingPivot($userId, ['shortlisted' => true]);
            Mail::to($user->email)->queue(new ShortListMail($listing->title, $user->name));
            return back()->with('success', 'User shortlisted successfully');
        }
        return back()->with('error', 'An error occurred');
    }
}
