<?php 

namespace Input;
class TransactionPayment {

  function __construct(
    public int $accountId,
    public float $value,
    public string $paymentMethodId
  ){}
}