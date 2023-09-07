<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionApplicationTest extends TestCase {
  use RefreshDatabase;
  
  function testShouldBuyUsingAExistPaymentMethodAndAccount() {
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();

    $account = new Account(1, 500);
    $paymentMethod = new PaymentMethod('O', 'Pix', 0);
    $accountRepository->create($account);
    $paymentMethodRepository->create($paymentMethod);

    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);

    $input = new \Input\TransactionPayment(1, 300, 'O');
    $output = $app->pay($input);
    $this->assertEquals($output->balance, 200);
    
    $accountFounded = $accountRepository->find(1);
    $this->assertEquals($accountFounded->getBalance(), 200);
  }

  function testShouldThrowExceptionWhenNotExistPaymentMethod() {
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();
    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);

    $account = new Account(1, 500);
    $accountRepository->create($account);

    $input = new \Input\TransactionPayment(1, 300, 'O');
    $this->expectException(\Exception::class);
    $account = $app->pay($input);
  }

  function testShouldThrowExceptionWhenNotExistAccount() {
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();
    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);
    
    $input = new \Input\TransactionPayment(1, 300, 'P');
    $this->expectException(\Exception::class);
    $app->pay($input);
  }

  function testShouldThrowExceptionWhenAccountHasInsufficientBalance(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();

    $account = new Account(1, 500);
    $paymentMethod = new PaymentMethod('O', 'Pix', 0);
    $accountRepository->create($account);
    $paymentMethodRepository->create($paymentMethod);

    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);

    $input = new \Input\TransactionPayment(1, 800, 'O');
    $this->expectException(\Exception::class);
    $account = $app->pay($input);
  }

  function testShouldTransferValueIntoTwoAccounts(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();
    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);

    $accountSender = new Account(1, 500);
    $accountReceiver = new Account(2, 500);
    $paymentMethod = new PaymentMethod('O', 'Pix', 10);

    $accountRepository->create($accountSender);
    $accountRepository->create($accountReceiver);
    $paymentMethodRepository->create($paymentMethod);

    $input = new Input\Transfer(1, 2, 100, 'O');

    $app->transfer($input);

    $accountSender = $accountRepository->find(1);
    $accountReceiver = $accountRepository->find(2);

    $this->assertEquals($accountSender->getBalance(), 390);
    $this->assertEquals($accountReceiver->getBalance(), 600);
  }

  function testShouldExpectFalseWhenAccountSenderHasInsufficientBalance(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();
    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);

    $accountSender = new Account(1, 0);
    $accountReceiver = new Account(2, 500);
    $paymentMethod = new PaymentMethod('O', 'Pix', 10);

    $accountRepository->create($accountSender);
    $accountRepository->create($accountReceiver);
    $paymentMethodRepository->create($paymentMethod);

    $input = new Input\Transfer(1, 2, 100, 'O');

    $this->expectException(\Exception::class);
    $app->transfer($input);
  }

  function testShouldExpectFalseWhenAccountSenderNotExists(){
    $paymentMethodRepository = new \Repository\PaymentMethod();
    $accountRepository = new \Repository\Account();
    $app = new \Application\Transaction($paymentMethodRepository, $accountRepository);

    $accountReceiver = new Account(2, 500);
    $paymentMethod = new PaymentMethod('O', 'Pix', 10);

    $accountRepository->create($accountReceiver);
    $paymentMethodRepository->create($paymentMethod);

    $input = new Input\Transfer(1, 2, 100, 'O');
    
    $this->expectException(\Exception::class);
    $app->transfer($input);
  }
  
}