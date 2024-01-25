<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobEditRequest;
use App\Http\Requests\JobPostRequest;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostJobController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isPremiumUser')->only(['create', 'store']);
    }

    public function index()
    {
        $jobs = Listing::where('user_id', auth()->user()->id)->get();
        return view('job.index', compact('jobs'));
    }

    public function create()
    {
        return view('job.create');
    }

    public function store(JobPostRequest $request)
    {
        try {
            $image = $request->file('feature_image')->store('images', 'public');
            $post = new Listing;
            $post->feature_image = $image;
            $post->user_id = auth()->user()->id;
            $post->title = $request->title;
            $post->description = $request->description;
            $post->roles = $request->roles;
            $post->job_type = $request->job_type;
            $post->address = $request->address;
            $post->application_close_date = \Carbon\Carbon::parse($request->application_close_date)->format('Y-m-d');
            $post->salary = $request->salary;
            $post->slug = Str::slug($request->title) . '.' . Str::uuid();
            $post->save();
            return redirect()->back()->with('success', 'Job posted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit(Listing $id)
    {
        return view('job.edit', compact('id'));
    }

    public function update($id, JobEditRequest $request)
    {
        $listing = Listing::find($id);

        if ($request->hasFile('feature_image')) {
            $featureImage = $request->file('feature_image')->store('images', 'public');
            $listing->update(['feature_image' => $featureImage]);
        }

        $listing->update($request->except('feature_image'));
        return redirect()->back()->with('success', 'Job updated successfully');
    }

    public function destroy($id)
    {
        try {
            $listing = Listing::find($id);
            $listing->delete();
            return redirect()->back()->with('success', 'Job deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
