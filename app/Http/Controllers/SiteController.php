<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(Plan $plan)
    {
        //whith -> Na mesma consulta, ele já retorna o plano e as features dele.
        $plans = $plan->with('features')->get();

        return view('home.index', compact('plans'));
    }

    public function createSessionPlan(Plan $plan, $urlPlan)
    {
        //se não encontrar a url do plano retorna para a home do site.
        if (!$plan = $plan->where('url', $urlPlan)->first()) {
            return redirect()->route('site.home');
        }

        session()->put('plan', $plan);

        return redirect()->route('subscriptions.checkout');
    }
}
