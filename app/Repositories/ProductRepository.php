<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Products\Product;

use App\Services\APIErrorHandlerService;

use Exception;

class ProductRepository extends APIErrorHandlerService implements ProductRepositoryInterface
{
    protected $model;
    protected $modelRelationships;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll($query)
    {
        try
        {

        } catch (Exception $e)
        {
            return $this->handleApiError($e->getMessage());
        }
    }
    public function get($id)
    {
        try
        {

        } catch (Exception $e)
        {
            return $this->handleApiError($e->getMessage());
        }
    }
    public function create($payload)
    {
        try
        {
            $data = $this->model->create($payload);

            return response()->success($data, 201);
        } catch (Exception $e)
        {
            return $this->handleApiError($e->getMessage());
        }
    }
    public function update($payload, $id)
    {
        try
        {
            $this->model->findOrFail($id)->update($payload);
        } catch (Exception $e)
        {
            return $this->handleApiError($e->getMessage());
        }
    }
    public function destroy($type, $id)
    {
        try
        {

        } catch (Exception $e)
        {
            return $this->handleApiError($e->getMessage());
        }
    }
}
