<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('subscriptions.premium');
    }

    //retorna as faturas pagas
    public function account()
    {
        $invoices = auth()->user()->invoices();

        return view('subscriptions.account', compact('invoices'));
    }

    //gera a fatura do produto adquirido
    public function invoiceDownload($idInvoice)
    {
        return Auth::user()->downloadInvoice($idInvoice, [
            'vendor' => config('app.name'),
            'product' => 'Assinatura VIP'
        ]);
    }

    //cancela o plano
    public function cancel()
    {
        auth()->user()->subscription('default')->cancel();

        return redirect()->route('subscriptions.account');
    }

    //reativa o plano cancelado.
    public function resume()
    {
        auth()->user()->subscription('default')->resume();

        return redirect()->route('subscriptions.account');
    }

}
