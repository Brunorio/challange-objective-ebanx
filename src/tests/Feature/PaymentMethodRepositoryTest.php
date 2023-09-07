<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodRepositoryTest extends TestCase {
  
  use RefreshDatabase;

  public function testShouldCreatePaymentMethod(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $paymentMethod = new \PaymentMethod("D", "Debit", 100);
    $paymentMethodRepository->create($paymentMethod);

    $paymentMethodModel = \App\Models\PaymentMethod::where('id', $paymentMethod->getId())->first();
    $this->assertEquals($paymentMethodModel->id, $paymentMethod->getId());
    $this->assertEquals($paymentMethodModel->name, $paymentMethod->getName());
    $this->assertEquals($paymentMethodModel->tax, $paymentMethod->getTax());
  }

  public function testShouldThrowExceptionWhenCreateRepetedPaymentMethodId(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $paymentMethod = new \PaymentMethod("A", "PaymentA", 100);
    $paymentMethodRepository->create($paymentMethod);

    $this->expectException(\Exception::class);
    $paymentMethod = new \PaymentMethod("A", "PaymentA", 100);
    $paymentMethodRepository->create($paymentMethod);
  }

  public function testShouldUpdatePaymentMethod(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $paymentMethod = new \PaymentMethod("C", "Credit", 100);
    $paymentMethodRepository->create($paymentMethod);

    $paymentMethodModel = \App\Models\PaymentMethod::where('id', $paymentMethod->getId())->first();
    $this->assertEquals($paymentMethodModel->id, $paymentMethod->getId());
    $this->assertEquals($paymentMethodModel->name, $paymentMethod->getName());
    $this->assertEquals($paymentMethodModel->tax, $paymentMethod->getTax());
  }

  public function testShouldFindPaymentMethod(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $paymentMethod = new \PaymentMethod("P", "Pix", 100);
    $paymentMethodRepository->create($paymentMethod);

    $paymentMethodModel = \App\Models\PaymentMethod::where('id', $paymentMethod->getId())->first();

    $paymentMethodFounded = $paymentMethodRepository->find($paymentMethod->getId());
    $this->assertEquals($paymentMethodModel->id, $paymentMethodFounded->getId());
    $this->assertEquals($paymentMethodModel->name, $paymentMethodFounded->getName());
    $this->assertEquals($paymentMethodModel->tax, $paymentMethodFounded->getTax());
  }

  public function testShouldExpectFalseWhenPaymentMethodIsNotFound(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $this->expectException(\Exception::class);
    $paymentMethodFounded = $paymentMethodRepository->find(1000);
  }
 

}