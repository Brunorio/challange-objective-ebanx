<?php

namespace Repository;

class PaymentMethod implements \Repository\Interface\PaymentMethod {
  function create($paymentMethod){
    \App\Models\PaymentMethod::create([
      'id' => $paymentMethod->getId(),
      'name' => $paymentMethod->getName(),
      'tax' => $paymentMethod->getTax()
    ]);
  }

  function update($paymentMethod){
    \App\Models\PaymentMethod::where('id', $paymentMethod->getId())
      ->update(['tax' => $paymentMethod->getTax()]);
  }

  function find(string $id){
    $paymentMethodModel = \App\Models\PaymentMethod::where('id', $id)->first();
    if(!empty($paymentMethodModel))
      return (new \PaymentMethod($paymentMethodModel->id, $paymentMethodModel->name, $paymentMethodModel->tax));
    throw new \Exception("Payment Method not found");
  }
}