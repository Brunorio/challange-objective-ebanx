<?php 

namespace Application;

class Account {
  public function __construct(
    private \Repository\Account $repository
  ) { }

  public function find(\Input\Account $input): \Output\Account {
    $account =  $this->repository->find($input->accountId);
    return new \Output\Account($account->getId(), $account->getBalance());
  }

  public function create(\Input\Account $input): \Output\Account {
    $account = new \Account($input->accountId, 500);
    $this->repository->create($account);

    return new \Output\Account($account->getId(), $account->getBalance());
  }


  public function increaseBalance(\Input\IncreaseAccount $input): \Output\Account {
    $account = $this->repository->find($input->accountId);
    $account->increaseBalance($input->value);
    $this->repository->update($account);
    return new \Output\Account($account->getId(), $account->getBalance());
  }
}