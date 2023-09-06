<?php

class Account {
  
  public function __construct(
    private string $id,
    private string $balance
  ) {
    $this->validate();
  }

  private function validate(){
    if(empty(trim($this->id ?? "")))
      throw new InvalidArgumentException("Id cannot be empty");

    if($this->balance < 0)
      throw new InvalidArgumentException("Balance cannot be negative");

  }
}