<?php 

namespace Repository\Interface;

interface Repository {
  public function create($entity);
  public function update($entity);
  public function find(string $id);
}