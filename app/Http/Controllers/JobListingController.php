<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

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
                $listing->where('job_type', 'Fulltime');
                break;
            case 'part-time':
                $listing->where('job_type', 'Parttime');
                break;
            case 'casual':
                $listing->where('job_type', 'Casual');
                break;
            case 'contract':
                $listing->where('job_type', 'Contract');
                break;
        }

        $jobs = $listing->with('profile')->get();
        return view('home', compact('jobs'));
    }

    public function show(Listing $listing)
    {
        return view('job.show', compact('listing'));
    }
}
