<?php 

namespace Input;

class IncreaseAccount {
  public function __construct(
    public int $accountId,
    public float $value
  ){ }
}