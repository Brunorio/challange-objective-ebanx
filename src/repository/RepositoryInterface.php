<?php 

namespace Repository;

interface RepositoryInterface {
  public function create($entity);
  public function update($entity);
  public function find(string $id);
}