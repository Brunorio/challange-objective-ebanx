<?php 

namespace Application;

class Account {
  public function __construct(
    private \Repository\Account $repository
  ) { }

  public function create(\Input\Account $input) {
    $account = new \Account($input->conta_id, 500);
    $this->repository->create($account);

    return $account;
  }

  public function find(\Input\Account $input) {
    try {
      return $this->repository->find($input->conta_id);
    } catch(\Exception $error) {
      return false;
    }
  }

  public function increaseBalance(\Input\IncreaseAccount $input): bool | \Account {
    $account = $this->find(new \Input\Account($input->conta_id));
    if($account !== false) {
      $account->increaseBalance($input->valor);
      $this->repository->update($account);
      return $account;
    }
    return false;
  }
}