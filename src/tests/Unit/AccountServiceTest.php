<?php 
use PHPUnit\Framework\TestCase;

class AccountServiceTest extends TestCase {

  public function testShouldTransferValueIntoTwoAccount(){
    $tax = new Tax("P", "Pix", 0);
    $accountSender = new Account(1, 200);
    $accountReceiver = new Account(2, 0);
    $value = 75;

    \Service\Account::transfer($accountSender, $accountReceiver, $value, $tax);

    $this->assertEquals($accountReceiver->getBalance(), 75);
    $this->assertEquals($accountSender->getBalance(), 125);
  }

  public function testShouldTransferValueIntoTwoAccountWithTax(){
    $tax = new Tax("D", "Debit", 3);
    $accountSender = new Account(1, 200);
    $accountReceiver = new Account(2, 0);
    $value = 75;

    \Service\Account::transfer($accountSender, $accountReceiver, $value, $tax);

    $this->assertEquals($accountReceiver->getBalance(), 75);
    $this->assertEquals($accountSender->getBalance(), 122.75);
  }

  public function testShouldThrowExceptionWhenAccountSenderDoNotHasSufficientBalance(){
    $tax = new Tax("C", "Credit", 5);
    $accountSender = new Account(1, 100);
    $accountReceiver = new Account(2, 0);
    $value = 100;

    $this->expectException(\Exception::class);
    \Service\Account::transfer($accountSender, $accountReceiver, $value, $tax);
  }

  public function testShouldThrowInvalidArgumentExceptionWhenValueIsNegative(){
    $tax = new Tax("P", "Pix", 0);
    $accountSender = new Account(1, 1000);
    $accountReceiver = new Account(2, 100);
    $value = -100;

    $this->expectException(\InvalidArgumentException::class);
    \Service\Account::transfer($accountSender, $accountReceiver, $value, $tax);
  }

  public function testShouldPay(){
    $tax = new Tax("D", "Debit", 3);
    $account = new Account(1, 1000);
    $value = 50;
    \Service\Account::pay($account, $value, $tax);
    $this->assertEquals($account->getBalance(), 948.5);


    $tax = new Tax("C", "Credit", 5);
    $value = 100;
    \Service\Account::pay($account, $value, $tax);
    $this->assertEquals($account->getBalance(), 843.5);
  }

  public function testShouldNotPayWhenBalanceIsInsufficient(){
    $tax = new Tax("D", "Debit", 3);
    $account = new Account(1, 100);
    $value = 150;
    $this->expectException(\Exception::class);
    \Service\Account::pay($account, $value, $tax);
  }

 

}