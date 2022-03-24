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
        //verifica se o usuário é assinante.
        if (auth()->user()->subscribed('default'))
            return redirect()->route('subscriptions.premium');

        return view('subscriptions.index', [
            'intent' => auth()->user()->createSetupIntent(),
        ]);
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
        if (!auth()->user()->subscribed('default'))
            return redirect()->route('subscriptions.checkout');

        return view('subscriptions.premium');
    }

}
