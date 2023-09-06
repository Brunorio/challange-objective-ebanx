<?php

class Account {
  
  public function __construct(
    private string $id,
    private float $balance
  ) {
    $this->validate();
  }

  private function validate(){
    if(empty(trim($this->id ?? "")))
      throw new InvalidArgumentException("Id cannot be empty");

    if($this->balance < 0)
      throw new InvalidArgumentException("Balance cannot be negative");
  }

  public function increaseBalance(float $value){
    if($value < 0)
      throw new InvalidArgumentException("Value cannot be negative");
    $this->balance += $value;
  }

  public function decreaseBalance(float $value){
    if($value < 0)
      throw new InvalidArgumentException("Value cannot be negative");
    if($this->balance - $value < 0)
      throw new Exception("Insufficient balance");
      
    $this->balance -= $value;
  }

  public function getId(){
    return $this->id;
  }

  public function getBalance(){
    return $this->balance;
  }
}