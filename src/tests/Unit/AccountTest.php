<?php 
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase {

  public function testShouldThrowInvalidArgumentExceptionWhenIdIsEmpty() {
    $this->expectException(\InvalidArgumentException::class);
    $account = new Account("", 0);
  }

  public function testShouldThrowInvalidArgumentExceptionWhenBalanceIsNegative() {
    $this->expectException(\InvalidArgumentException::class);
    $account = new Account("C1", -10);
  }

  public function testshouldIncreaseBalance(){
    $account = new Account("C1", 10);
    $account->increaseBalance(20);

    $this->assertEquals($account->getBalance(), 30);
  }

  public function testshouldThrowInvalidArgumentExceptionWhenIncreaseBalanceWithNegativeValue(){
    $this->expectException(\InvalidArgumentException::class);
    $account = new Account("C1", 50);
    $account->increaseBalance(-25);
  }

  public function testshouldDecreaseBalance(){
    $account = new Account("C1", 10);
    $account->decreaseBalance(10);

    $this->assertEquals($account->getBalance(), 0);
  }

  public function testshouldThrowInvalidArgumentExceptionWhenDecreaseBalanceWithNegativeValue(){
    $this->expectException(\InvalidArgumentException::class);
    $account = new Account("C1", 50);
    $account->decreaseBalance(-25);
  }

  public function testshouldThrowExceptionWhenBalanceIsInsufficient(){
    $this->expectException(\Exception::class);
    $account = new Account("C1", 10);
    $account->decreaseBalance(15);
  }


  
 
}