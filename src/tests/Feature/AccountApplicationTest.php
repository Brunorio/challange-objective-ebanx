<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountApplicationTest extends TestCase {
  use RefreshDatabase;
  
  function testShouldReturnCorrectAccount(){
    $repository = new \Repository\Account();
    $account = new \Account("1", 200);
    $repository->create($account);

    $accountApplication = new \Application\Account($repository);
    $input = new \Input\Account("1");
    $accountFounded = $accountApplication->find($input);

    $this->assertEquals($account->getId(), $accountFounded->getId());
    $this->assertEquals($account->getBalance(), $accountFounded->getBalance());
  }

  function testShouldReturnFalseWhenAccountNotExists(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);
    $input = new \Input\Account("1");
    $accountFounded = $accountApplication->create($input);
    $this->assertEquals($accountFounded->getId(), 1);
    $this->assertEquals($accountFounded->getBalance(), 500);
  }

  function testShouldCreateAccountWithBalance(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);
    $input = new \Input\Account("1");
    $accountFounded = $accountApplication->create($input);
    $this->assertEquals($accountFounded->getId(), 1);
    $this->assertEquals($accountFounded->getBalance(), 500);
  }

  function testShouldIncreaseBalance(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);

    $account = $accountApplication->create(new \Input\Account(1));

    $input = new \Input\IncreaseAccount(
      $account->getId(), 
      100);

    $accountIncreased = $accountApplication->increaseBalance($input);
    $this->assertEquals($accountIncreased->getBalance(), 600);
  }

  function testShouldExpectFalseWhenIncreaseBalanceOfAccountNotExists(){
    $repository = new \Repository\Account();
    $accountApplication = new \Application\Account($repository);

    $input = new \Input\IncreaseAccount(1, 20);
    $accountIncreased = $accountApplication->increaseBalance($input);
    $this->assertEquals($accountIncreased, false);
  }
}