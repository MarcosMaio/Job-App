<?php

namespace App\Http\Controllers;

use App\Http\Middleware\doNotAllowUserToMakePayment;
use App\Http\Middleware\isEmployer;
use App\Mail\PurchaseMembershipMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class SubscriptionController extends Controller
{
    const PLAN_WEEKLY = 'price_1ObRDNEh5Iu3U0hzlnv4YPb3';
    const PLAN_MONTHLY = 'price_1ObRF5Eh5Iu3U0hzL94D7gZX';
    const PLAN_YEARLY = 'price_1ObRFrEh5Iu3U0hzSTIxf08F';

    public function __construct()
    {
        $this->middleware(['auth', isEmployer::class]);
        $this->middleware(['auth', doNotAllowUserToMakePayment::class])->except('subscribe');
    }

    public function subscribe(Request $request)
    {
        return view('subscribe.index');
    }

    public function initiatePayment(Request $request)
    {
        $plans = [
            'weekly' => [
                'name' => 'weekly',
                'price' => self::PLAN_WEEKLY,
                'quantify' => 1
            ],
            'monthly' => [
                'name' => 'monthly',
                'price' => self::PLAN_MONTHLY,
                'quantify' => 1
            ],
            'yearly' => [
                'name' => 'yearly',
                'price' => self::PLAN_YEARLY,
                'quantify' => 1
            ]
        ];

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $selectedPlan = null;
            if ($request->is('pay/weekly')) {
                $selectedPlan = $plans['weekly'];
                $billingEnds = now()->addWeek()->startOfDay()->toDateString();
            } elseif ($request->is('pay/monthly')) {
                $selectedPlan = $plans['monthly'];
                $billingEnds = now()->addMonth()->startOfDay()->toDateString();
            } elseif ($request->is('pay/yearly')) {
                $selectedPlan = $plans['yearly'];
                $billingEnds = now()->addYear()->startOfDay()->toDateString();
            }

            if ($selectedPlan) {
                $successURL = URL::signedRoute('payment.success', ['plan' => $selectedPlan['name'], 'billing_ends' => $billingEnds]);
                $failedURL = route('payment.cancel');
                $checkout_session = Session::create([
                    'payment_method_types' => ['card'],
                    'mode' => 'subscription',
                    'line_items' => [[
                        'price' => $selectedPlan['price'],
                        'quantity' => $selectedPlan['quantify'],
                    ]],
                    'success_url' => $successURL,
                    'cancel_url' => $failedURL,
                ]);

                return redirect()->to($checkout_session->url);
            }
        } catch (\Exception $e) {
            return response()->json($e);
        }

        // return redirect()->route('dashboard');
    }

    public function paymentSuccess(Request $request)
    {
        $plan = $request->plan;
        $billingEnds = $request->billing_ends;

        User::where('id', auth()->user()->id)->update([
            'plan' => $plan,
            'billing_ends' => $billingEnds,
            'status' => 'paid'
        ]);

        try {
            Mail::to(auth()->user())->queue(new PurchaseMembershipMail($plan, $billingEnds));
        } catch (\Exception $e) {
            return response()->json($e);
        }

        return redirect()->route('dashboard')->with('success', 'Payment was successfully processed');
    }

    public function paymentCancel(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Payment was not processed');
    }
}
