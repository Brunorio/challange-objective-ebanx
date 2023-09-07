<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountRepositoryTest extends TestCase {
  
  use RefreshDatabase;
  public function testShouldCreateAccount(){
    $accountRepository = new \Repository\Account();
    $id = \App\Models\Account::max('id') + 1;


    $id = \App\Models\Account::max('id') + 1;
    $account = new \Account($id, 100);
    $accountRepository->create($account);

    $accountModel = \App\Models\Account::find($id);
    $this->assertEquals($accountModel->id, $account->getId());
    $this->assertEquals($accountModel->balance, $account->getBalance());
  }

  public function testShouldUpdateAccount(){
    $accountRepository = new \Repository\Account();
    $id = \App\Models\Account::max('id') + 1;


    $id = \App\Models\Account::max('id') + 1;
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
    $id = \App\Models\Account::max('id') + 1;


    $id = \App\Models\Account::max('id') + 1;
    $account = new \Account($id, 100);
    $accountRepository->create($account);

    $accountModel = \App\Models\Account::find($id);
    $accountFounded = $accountRepository->find($id);
    $this->assertEquals($accountModel->id, $accountFounded->getId());
    $this->assertEquals($accountModel->balance, $accountFounded->getBalance());
  }
 

}