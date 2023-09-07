<?php
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class TransactionControllerTest extends TestCase {
  use RefreshDatabase;
  
  public function testShouldPay(){
    $repository = new Repository\Account();
    $paymentMethodRepository = new Repository\PaymentMethod();

    $account = new Account(1, 500);
    $repository->create($account);
    
    $paymentMethod = new PaymentMethod('C', 'Credit', 3);
    $paymentMethodRepository->create($paymentMethod);

    $response = $this->postJson('/transacao', 
      [
        'conta_id' => 1, 
        'valor' => 100, 
        'forma_pagamento' => 'C'
      ]
    );
    $response
      ->assertStatus(201)
      ->assertJson([
        'conta_id' => 1,
        'saldo' => 397
      ]);
  }

  public function testShouldExpectNotFoundWhenBalanceIsInsufficient(){
    $repository = new Repository\Account();
    $paymentMethodRepository = new Repository\PaymentMethod();

    $account = new Account(1, 100);
    $repository->create($account);
    
    $paymentMethod = new PaymentMethod('C', 'Credit', 3);
    $paymentMethodRepository->create($paymentMethod);

    $response = $this->postJson('/transacao', 
      [
        'conta_id' => 1, 
        'valor' => 100, 
        'forma_pagamento' => 'C'
      ]
    );
    $response->assertStatus(404);
  }

  public function testShouldExpectNotFoundWhenAccountNoExist(){
    $response = $this->postJson('/transacao', 
      [
        'conta_id' => 1, 
        'valor' => 100, 
        'forma_pagamento' => 'C'
      ]
    );
    $response->assertStatus(404);
  }


}