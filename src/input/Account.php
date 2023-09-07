<?php 

namespace Input;

class Account {
  public function __construct(
    public int $accountId,
    public float $value = 0
  ){ }
}