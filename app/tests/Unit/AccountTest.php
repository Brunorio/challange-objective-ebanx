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
 
}