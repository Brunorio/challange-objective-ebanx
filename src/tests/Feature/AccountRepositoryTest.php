<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountRepositoryTest extends TestCase {
  
  use RefreshDatabase;
  public function testShouldCreateAccount(){
    $accountRepository = new \Repository\Account();
    $account = new \Account(1, 100);
    $accountRepository->create($account);

    $accountModel = \App\Models\Account::find(1);
    $this->assertEquals($accountModel->id, $account->getId());
    $this->assertEquals($accountModel->balance, $account->getBalance());
  }

  public function testShouldThrowExceptionWhenCreateRepetedAccountId(){
    $accountRepository = new \Repository\Account();
    $account = new \Account(1, 100);
    $accountRepository->create($account);

    $account = new \Account(1, 100);
    $this->expectException(\Exception::class);
    $accountRepository->create($account);
  }

  public function testShouldUpdateAccount(){
    $accountRepository = new \Repository\Account();
    $id = 1;
    $account = new \Account($id, 100);
    $accountRepository->create($account);

    $accountModel = \App\Models\Account::find($id);
    $this->assertEquals($accountModel->id, $account->getId());
    $this->assertEquals($accountModel->balance, $account->getBalance());

    $account->increaseBalance(100);
    $accountRepository->update($account);

    $accountModel = \App\Models\Account::find($id);
    $this->assertEquals($accountModel->id, $account->getId());
    $this->assertEquals($accountModel->balance, $account->getBalance());
  } 

  public function testShouldFindAccount(){
    $accountRepository = new \Repository\Account();
    $id = 1;
    $account = new \Account($id, 100);
    $accountRepository->create($account);

    $accountModel = \App\Models\Account::find($id);
    $accountFounded = $accountRepository->find($id);
    $this->assertEquals($accountModel->id, $accountFounded->getId());
    $this->assertEquals($accountModel->balance, $accountFounded->getBalance());
  }

  public function testShouldExpectedFalseWhenAccountNotFound(){
    $accountRepository = new \Repository\Account();
    $this->expectException(\Exception::class);
    $accountFounded = $accountRepository->find(1000);
  }
 

}