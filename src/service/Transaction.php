<?php 

namespace Service;

class Transaction {
  static function transfer(\Account $accountSender, \Account $accountReceiver, float $value, \PaymentMethod $paymentMethod) {
    $accountSender->decreaseBalance($paymentMethod->calculateAmount($value));
    $accountReceiver->increaseBalance($value);
  }

  static function pay(\Account $account, float $value, \PaymentMethod $paymentMethod) {
    $account->decreaseBalance($paymentMethod->calculateAmount($value));
  }
}