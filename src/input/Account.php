<?php 

namespace Input;

class Account {
  public function __construct(
    public int $conta_id,
    public float $valor = 0
  ){ }
}