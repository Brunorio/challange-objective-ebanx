<?php 
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase {

  public function testShouldTransferValueIntoTwoAccount(){
    $paymentMethod = new PaymentMethod("P", "Pix", 0);
    $accountSender = new Account(1, 200);
    $accountReceiver = new Account(2, 0);
    $value = 75;

    \Service\Transaction::transfer($accountSender, $accountReceiver, $value, $paymentMethod);

    $this->assertEquals($accountReceiver->getBalance(), 75);
    $this->assertEquals($accountSender->getBalance(), 125);
  }

  public function testShouldTransferValueIntoTwoAccountWithTax(){
    $paymentMethod = new PaymentMethod("D", "Debit", 3);
    $accountSender = new Account(1, 200);
    $accountReceiver = new Account(2, 0);
    $value = 75;

    \Service\Transaction::transfer($accountSender, $accountReceiver, $value, $paymentMethod);

    $this->assertEquals($accountReceiver->getBalance(), 75);
    $this->assertEquals($accountSender->getBalance(), 122.75);
  }

  public function testShouldThrowExceptionWhenAccountSenderDoNotHasSufficientBalance(){
    $paymentMethod = new PaymentMethod("C", "Credit", 5);
    $accountSender = new Account(1, 100);
    $accountReceiver = new Account(2, 0);
    $value = 100;

    $this->expectException(\Exception::class);
    \Service\Transaction::transfer($accountSender, $accountReceiver, $value, $paymentMethod);
  }

  public function testShouldThrowInvalidArgumentExceptionWhenValueIsNegative(){
    $paymentMethod = new PaymentMethod("P", "Pix", 0);
    $accountSender = new Account(1, 1000);
    $accountReceiver = new Account(2, 100);
    $value = -100;

    $this->expectException(\InvalidArgumentException::class);
    \Service\Transaction::transfer($accountSender, $accountReceiver, $value, $paymentMethod);
  }

  public function testShouldPay(){
    $paymentMethod = new PaymentMethod("D", "Debit", 3);
    $account = new Account(1, 1000);
    $value = 50;
    \Service\Transaction::pay($account, $value, $paymentMethod);
    $this->assertEquals($account->getBalance(), 948.5);


    $paymentMethod = new PaymentMethod("C", "Credit", 5);
    $value = 100;
    \Service\Transaction::pay($account, $value, $paymentMethod);
    $this->assertEquals($account->getBalance(), 843.5);
  }

  public function testShouldNotPayWhenBalanceIsInsufficient(){
    $paymentMethod = new PaymentMethod("D", "Debit", 3);
    $account = new Account(1, 100);
    $value = 150;
    $this->expectException(\Exception::class);
    \Service\Transaction::pay($account, $value, $paymentMethod);
  }

 

}