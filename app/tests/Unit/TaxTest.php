<?php 
use PHPUnit\Framework\TestCase;

class TaxTest extends TestCase {

  public function testShouldThrowExceptionWhenIdIsEmpty(){
    $this->expectException(InvalidArgumentException::class);
    $tax = new Tax("", "Pix", 0);
  }

  public function testShouldThrowExceptionWhenNameIsEmpty(){
    $this->expectException(InvalidArgumentException::class);
    $tax = new Tax("P", "", 0);
  }

  public function testShouldThrowExceptionWhenTaxValueIsNegative(){
    $this->expectException(InvalidArgumentException::class);
    $tax = new Tax("P", "Pix", -10);
  }

  public function testShouldCalculateAmountWithTax(){
    $value = 100;
    $tax = new Tax("D", "Debit Card", 3);

    $amount = $tax->calculateAmount($value);
    $this->assertEquals($amount, 103);
  }

  /**
   * @dataProvider truncateAmount
   */
  public function testShouldTruncateWhenAmountIsMoreThenTwoFractionalDigits($value, $expected){ 
    $tax = new Tax("D", "Debit Card", 5);
    $amount = $tax->calculateAmount($value);

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