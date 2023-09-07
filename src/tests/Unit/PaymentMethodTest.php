<?php 
use PHPUnit\Framework\TestCase;

class PaymentMethodTest extends TestCase {

  public function testShouldThrowExceptionWhenIdIsEmpty(){
    $this->expectException(InvalidArgumentException::class);
    $paymentMethod = new PaymentMethod("", "Pix", 0);
  }

  public function testShouldThrowExceptionWhenNameIsEmpty(){
    $this->expectException(InvalidArgumentException::class);
    $paymentMethod = new PaymentMethod("P", "", 0);
  }

  public function testShouldThrowExceptionWhenTaxValueIsNegative(){
    $this->expectException(InvalidArgumentException::class);
    $paymentMethod = new PaymentMethod("P", "Pix", -10);
  }

  public function testShouldCalculateAmountWithTax(){
    $value = 100;
    $paymentMethod = new PaymentMethod("D", "Debit Card", 3);

    $amount = $paymentMethod->calculateAmount($value);
    $this->assertEquals($amount, 103);
  }

  /**
   * @dataProvider truncateAmount
   */
  public function testShouldTruncateWhenAmountIsMoreThenTwoFractionalDigits($value, $expected){ 
    $paymentMethod = new PaymentMethod("D", "Debit Card", 5);
    $amount = $paymentMethod->calculateAmount($value);

    $this->assertEquals($amount, $expected);
  }

  static function truncateAmount(){
    return [
      [9.99, 10.48],
      [3.57, 3.74],
      [8.48, 8.9]
    ];
  }

}