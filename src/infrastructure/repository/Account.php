<?php

namespace Repository;

class Account implements \Repository\Interface\Account {
  function create($account){
    \App\Models\Account::create([
      'id' => $account->getId(),
      'balance' => $account->getBalance()
    ]);
  }

  function update($account){
    \App\Models\Account::where('id', $account->getId())
      ->update(['balance' => $account->getBalance()]);
  }

  function find(string $id){
    $accountModel = \App\Models\Account::find($id);
    if(!empty($accountModel))
      return (new \Account($accountModel->id, $accountModel->balance));
    throw new \Exception("Account not found");
  }
}