<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Http\Resources\Products\ProductCategoriesResource;
use App\Models\Orders\Order;

use App\Services\APIErrorHandlerService;

use Exception;

class OrderRepository extends APIErrorHandlerService implements OrderRepositoryInterface
{
    protected $model;
    protected $modelRelationships;

    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->modelRelationships = ['user'];
    }

    public function baseModel()
    {
        return $this->model->with(
            $this->modelRelationships
        );
    }

    public function getAll($query)
    {
        try
        {
            $data = $this->baseModel()->orderBy('id', 'desc')->get();

            return response()->success(ProductCategoriesResource::collection($data));
        } catch (Exception $e)
        {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function get($id)
    {
        try
        {
            $data = $this->model->where('id', $id)->first();

            if (!$data) {
                return response()->error('Not Found', 404);
            }

            return response()->json($data);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
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
            return response()->error($e->getMessage());
        }
    }

    public function update($payload, $id)
    {
        try
        {
            $data = $this->model->findOrFail($id);

            $data->update($payload);

            return response()->success($data);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }

    public function destroy($type, $id)
    {
        try
        {
            $data = $this->model->delete($id);

            return response()->success($data, 204);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }
}
