<?php
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class AccountControllerTest extends TestCase {
  use RefreshDatabase;
  
  public function testShouldCreateAccountWithBalance(){
    $response = $this->post('/conta/criacao/bonus');
    $response
      ->assertStatus(201)
      ->assertJson([
        'conta_id' => 1,
        'saldo' => 500
      ]);
  }

  public function testShouldIncreaseBalance(){
    $repository = new Repository\Account();
    $account = new Account(1, 500);
    $repository->create($account);

    $response = $this->postJson('/conta', ['conta_id' => 1, 'valor' => 500]);
    $response
      ->assertStatus(201)
      ->assertJson([
        'conta_id' => 1,
        'saldo' => 1000
      ]);
  }

  public function testShouldExpectStatusNotFoundWhenIncreaseBalanceAndAccountNotExist(){
    $response = $this->postJson('/conta', ['conta_id' => 1, 'valor' => 500]);
    $response->assertStatus(404);
  }

  public function testShouldExpectStatusNotFoundWhenIncreaseBalanceWithNegativeValue(){
    $repository = new Repository\Account();
    $account = new Account(1, 500);
    $repository->create($account);

    $response = $this->postJson('/conta', ['conta_id' => 1, 'valor' => -500]);
    $response->assertStatus(404);
  }

  function testShouldFindAccount(){
    $repository = new Repository\Account();
    $account = new Account(1, 500);
    $repository->create($account);
    $response = $this->get('/conta?id=1');
    $response->assertStatus(200);
  }

  function testShouldExpectStatusNotFoundWhenAccountNotExist(){
    $response = $this->get('/conta?id=1');
    $response->assertStatus(404);
  }
}