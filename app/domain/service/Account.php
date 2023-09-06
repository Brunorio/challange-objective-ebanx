<?php 

namespace Service;

class Account {
  static function transfer(\Account $accountSender, \Account $accountReceiver, float $value, \Tax $tax) {
    $accountSender->decreaseBalance($tax->calculateAmount($value));
    $accountReceiver->increaseBalance($value);
  }

  static function pay(\Account $account, float $value, \Tax $tax) {
    $account->decreaseBalance($tax->calculateAmount($value));
  }
}