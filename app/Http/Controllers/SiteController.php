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
}
