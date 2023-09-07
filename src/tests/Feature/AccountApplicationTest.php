<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountApplicationTest extends TestCase {
  use RefreshDatabase;

  function testShouldReturnFalseWhenAccountNotExists(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);
    $input = new \Input\Account("1");
    $output = $accountApplication->create($input);
    $this->assertEquals($output->accountId, 1);
    $this->assertEquals($output->balance, 500);
  }

  function testShouldCreateAccountWithBalance(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);
    $input = new \Input\Account("1");
    $output = $accountApplication->create($input);
    $this->assertEquals($output->accountId, 1);
    $this->assertEquals($output->balance, 500);
  }

  function testShouldIncreaseBalance(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);

    $output = $accountApplication->create(new \Input\Account(1));

    $input = new \Input\IncreaseAccount( $output->accountId, 100);

    $output = $accountApplication->increaseBalance($input);
    $this->assertEquals($output->balance, 600);
  }

  function testShouldExpectFalseWhenIncreaseBalanceOfAccountNotExists(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);

    $input = new \Input\IncreaseAccount(1, 20);
    $this->expectException(\Exception::class);
    $accountIncreased = $accountApplication->increaseBalance($input);
  }
}