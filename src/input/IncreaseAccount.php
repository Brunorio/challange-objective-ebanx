<?php 

namespace Input;

class IncreaseAccount {
  public function __construct(
    public int $conta_id,
    public float $valor
  ){ }
}