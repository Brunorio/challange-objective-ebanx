<?php 

namespace Application;

class Transaction {
  public function __construct(
    private \Repository\PaymentMethod $paymentMethodRepository,
    private \Repository\Account $accountRepository
  ) { }

  function pay(\Input\TransactionPayment $input): \Account {
    $account = $this->accountRepository->find($input->accountId);
    $paymentMethod = $this->paymentMethodRepository->find($input->paymentMethodId);
    \Service\Transaction::pay($account, $input->value, $paymentMethod);
    $this->accountRepository->update($account);
    return $account;
  }

  function transfer(\Input\Transfer $input) {
    $accountSender = $this->accountRepository->find($input->accountSenderId);
    $accountReceiver = $this->accountRepository->find($input->accountReceiverId);
    $paymentMethod = $this->paymentMethodRepository->find($input->paymentMethodId);

    \Service\Transaction::transfer($accountSender, $accountReceiver, $input->value, $paymentMethod);
    $this->accountRepository->update($accountSender);
    $this->accountRepository->update($accountReceiver);
  }

  
}