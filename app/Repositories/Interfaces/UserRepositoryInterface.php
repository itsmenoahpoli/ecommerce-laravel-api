<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll($query);
    public function get($id);
    public function create($payload, $address);
    public function update($payload, $id);
    public function destroy($id);
}
