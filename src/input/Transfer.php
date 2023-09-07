<?php 

namespace Input;

class Transfer {
  function __construct(
    public int $accountSenderId,
    public int $accountReceiverId,
    public int $value,
    public string $paymentMethodId
  ){}
}