<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function getAll($query);
    public function get($id);
    public function create($payload, $shippingAddress);
    public function update($payload, $id);
    public function destroy($id);
}
