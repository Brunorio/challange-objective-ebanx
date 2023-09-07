<?php 

namespace Output;

class Account {
  function __construct(
    public $accountId,
    public $balance
  ){}
}