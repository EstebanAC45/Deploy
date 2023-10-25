<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Stripe;

class StripePaymentController extends Controller
{
    
    public function stripe()
    {
        return view('stripe');
    }
    

    public function stripePost(Request $request)
    {
        $precio_total = request('precio_venta');
        
        $datosVenta = request()->except('_token', 'stripeToken', 'stripeTokenType', 'stripeEmail','compras_realizadas');

        Venta::insert($datosVenta);

        $compras_realizadas = $request->input('compras_realizadas');
        $id_cliente = $request->input('id_cliente');

        $compras_realizadas = $compras_realizadas + 1;

        $sentenciaParaActualizarCompra = "UPDATE clientes SET compras_realizadas = $compras_realizadas WHERE id = $id_cliente";
        \DB::select($sentenciaParaActualizarCompra);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $precio_total * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
        
        
        return redirect ('venta');
        
    }
}
    // ...

    /*
    public function stripePost(Request $request){

        try{
            
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $res = $stripe->tokens->create([
                'card' => [
                  'number' => $request->card_number,
                  'exp_month' => $request->expiry_month,
                  'exp_year' => $request->expiry_year,
                  'cvc' => $request->cvc,
                ],
              ]);

              $response = $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $res->id,
                'description' => $request->description,
              ]);

              return response()->json([$response->status], 200);

        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }

    }

}*/
