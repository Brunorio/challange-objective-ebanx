<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller {
    public function create() {
        try {
            $repository = new \Repository\Account();
            $appAccount = new \Application\Account($repository);

            $id = \App\Models\Account::max('id') + 1;
            $input = new \Input\Account($id);
            $output = $appAccount->create($input);
            return response()->json([
                'conta_id' => $output->accountId,
                'saldo' => $output->balance
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'erro' => $e->getMessage(),
            ], 400);
        }
    }

    public function increaseBalance(Request $request) {
        try {
            $repository = new \Repository\Account();
            $appAccount = new \Application\Account($repository);

            $data = $request->json()->all() ?? [];
            $input = new \Input\IncreaseAccount(
                $data['conta_id'] ?? "",
                $data['valor'] ?? 0
            );

            $output = $appAccount->increaseBalance($input);
            return response()->json([
                'conta_id' => $output->accountId,
                'saldo' => $output->balance
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'erro' => $e->getMessage(),
            ], 404);
        }
    }

    public function find(Request $request) {
        try {
            $repository = new \Repository\Account();
            $appAccount = new \Application\Account($repository);

            $id = $request->query('id') ?? "";
            $input = new \Input\Account($id);
            $output = $appAccount->find($input);
            return response()->json([
                'conta_id' => $output->accountId,
                'saldo' => $output->balance
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'erro' => $e->getMessage(),
            ], 404);
        }
    }
}
