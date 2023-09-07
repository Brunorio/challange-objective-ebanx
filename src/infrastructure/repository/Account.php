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

    return (new \Account($accountModel->id, $accountModel->balance));
  }
}