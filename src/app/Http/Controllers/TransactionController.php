<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller {
    private \Application\Transaction $app;
    function __construct(){
        $accountRepository = new \Repository\Account();
        $paymentMethodRepository = new \Repository\PaymentMethod();
        $this->app = new \Application\Transaction(
            $paymentMethodRepository, 
            $accountRepository
        );
    }

    public function pay(Request $request){
        try {
            $data = $request->json()->all() ?? [];
            $input = new \Input\TransactionPayment(
                $data['conta_id'] ?? "",
                $data['valor'] ?? 0,
                $data['forma_pagamento'] ?? ""
            );
            $output = $this->app->pay($input);
            return response()->json([
                'conta_id' => $output->accountId,
                'saldo' => $output->balance
            ], 201);
        } catch(\Exception $e) {
            return response('', 404);
        }
    }
}
