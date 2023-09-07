<?php

namespace Repository;

class Tax implements \Repository\Interface\Tax {
  function create($tax){
    \App\Models\Tax::create([
      'id' => $tax->getId(),
      'name' => $tax->getName(),
      'tax' => $tax->getTax()
    ]);
  }

  function update($tax){
    \App\Models\Account::where('id', $tax->getId())
      ->update(['balance' => $tax->getBalance()]);
  }

  function find(string $id){
    $taxModel = \App\Models\Tax::where('id', $id)->first();

    return (new \Tax($taxModel->id, $taxModel->name, $taxModel->tax));
  }
}