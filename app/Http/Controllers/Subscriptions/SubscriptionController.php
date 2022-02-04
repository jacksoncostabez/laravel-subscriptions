<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']); //define que para usar qualquer método deste construtor precisa estar autenticado.
    }

    public function index()
    {
        return view('subscriptions.index');
    }

    public function store(Request $request)
    {
        //cria a assinatura do plano
        $request->user()
            ->newSubscription('default', 'price_1KPIbREMXy5fvtlA88OzKI9J')
            ->create($request->token);

        return redirect()->route('subscriptions.premium');
    }

    public function premium()
    {
        return view('subscriptions.premium');
    }

}
