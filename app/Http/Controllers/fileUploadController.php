<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class fileUploadController extends Controller
{
    public function store(Request $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file')->store('resumes', 'public');
            User::where('id', auth()->user()->id)->update(['resume' => $file]);

            return response()->json(['success' => 'Resume uploaded successfully']);
        }

        return response()->json(['error' => 'An error occurred']);
    }
}
