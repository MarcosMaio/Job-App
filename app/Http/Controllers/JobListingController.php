<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $salary = $request->query('sort');
        $date = $request->query('date');
        $jobType = $request->query('job_type');
        $listing = Listing::query();

        switch ($salary) {
            case 'salary_high_to_low':
                $listing->orderBy('salary', 'desc');
                break;
            case 'salary_low_to_high':
                $listing->orderBy('salary', 'asc');
                break;
        }

        switch ($date) {
            case 'latest':
                $listing->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $listing->orderBy('created_at', 'asc');
                break;
        }

        switch ($jobType) {
            case 'full-time':
                $listing->where('job_type', 'Full-Time');
                break;
            case 'part-time':
                $listing->where('job_type', 'Part-Time');
                break;
            case 'casual':
                $listing->where('job_type', 'Casual');
                break;
            case 'contract':
                $listing->where('job_type', 'Contract');
                break;
        }

        $jobs = $listing->with('profile')->get();
        // dd($jobs);
        return view('home', compact('jobs'));
    }

    public function show(Listing $listing)
    {
        // dd($listing->id);
        $verifiyIfAlredyApply = DB::table('listing_user')->where('listing_id', $listing->id)->where('user_id', auth()->user()->id)->get();
        // dd($verifiyIfAlredyApply);
        return view('job.show', [
            'listing' => $listing,
            'verifiyIfAlredyApply' => $verifiyIfAlredyApply
        ]);
    }

    public function company($id)
    {
        $company = User::with('jobs')->where('id', $id)->where('user_type', 'employer')->first();
        return view('company', compact('company'));
    }
}
