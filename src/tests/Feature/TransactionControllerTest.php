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

  public function testShouldTransfer(){
    $repository = new Repository\Account();
    $paymentMethodRepository = new Repository\PaymentMethod();

    $accountSender = new Account(1, 500);
    $repository->create($accountSender);

    $accountReceiver = new Account(2, 500);
    $repository->create($accountReceiver);
    
    $paymentMethod = new PaymentMethod('P', 'Pix', 0);
    $paymentMethodRepository->create($paymentMethod);

    $response = $this->postJson('/transacao/transferencia', 
      [
        'conta_origem_id' => 1, 
        'conta_destino_id' => 2, 
        'valor' => 100, 
        'forma_pagamento' => 'P'
      ]
    );
    $response->assertStatus(201);

    $accountSender = $repository->find(1);
    $accountReceiver = $repository->find(2);

    $this->assertEquals($accountSender->getBalance(), 400);
    $this->assertEquals($accountReceiver->getBalance(), 600);
  }

  public function testShouldExpectNotFoundWhenAccountSenderHasInsufficientBalance(){
    $repository = new Repository\Account();
    $paymentMethodRepository = new Repository\PaymentMethod();

    $accountSender = new Account(1, 50);
    $repository->create($accountSender);

    $accountReceiver = new Account(2, 500);
    $repository->create($accountReceiver);
    
    $paymentMethod = new PaymentMethod('P', 'Pix', 0);
    $paymentMethodRepository->create($paymentMethod);

    $response = $this->postJson('/transacao/transferencia', 
      [
        'conta_origem_id' => 1, 
        'conta_destino_id' => 2, 
        'valor' => 100, 
        'forma_pagamento' => 'P'
      ]
    );
    $response->assertStatus(404);
  }


}