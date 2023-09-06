<?php 

class Tax {
  public function __construct(
    private string $id,
    private string $name,
    private float $tax
  ) {
    $this->validate();
  }

  private function validate() {
    if(empty(trim($this->id ?? "")))
      throw new InvalidArgumentException("Id cannot be empty");
    if(empty(trim($this->name ?? "")))
      throw new InvalidArgumentException("Name cannot be empty");
    if($this->tax < 0)
      throw new InvalidArgumentException("Tax cannot be negative");
  }

  function calculateAmount(float $value): float {
    return floor(($value + (($this->tax * $value) / 100)) * 10 ** 2) / 10 ** 2;
  }
}