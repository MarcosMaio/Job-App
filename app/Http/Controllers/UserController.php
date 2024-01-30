<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuth;
use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    const JOB_POSTER = 'employer';

    public function __construct()
    {
        $this->middleware(CheckAuth::class)->only('createSeeker', 'createEmployer', 'login');
    }

    public function createSeeker()
    {
        return view('user.seeker-register');
    }

    public function storeSeeker(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_SEEKER
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return response()->json('success');

        // return redirect()->route('verification.notice')->with('successMessage', 'Your account was created');
    }

    public function createEmployer()
    {
        return view('user.employer-register');
    }

    public function storeEmployer(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_POSTER,
            'user_trial' => Carbon::now('America/Sao_Paulo')->addWeek()->toDateString()
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return response()->json('success');

        // return redirect()->route('verification.notice')->with('successMessage', 'Your account was created');
    }

    public function login()
    {
        return view('user.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentails = $request->only('email', 'password');

        if (Auth::attempt($credentails)) {
            if (auth()->user()->user_type == 'employer') {
                return redirect()->to('dashboard');
            } else {
                return redirect()->intended('/');
            }
        } else {
            return "wrong email or password";
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }

    public function profile()
    {
        return view('user.profile');
    }


    public function seekerProfile()
    {
        return view('user.seeker-profile');
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);

            if ($request->hasFile('profile_pic')) {
                $profile_pic = $request->file('profile_pic')->store('images', 'public');
                $user->update(['profile_pic' => $profile_pic]);
            }

            $user->update($request->except('profile_pic'));
            return back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
