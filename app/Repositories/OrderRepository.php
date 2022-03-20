<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Http\Resources\Products\ProductCategoriesResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderShippingAddress;
use App\Models\User;
use App\Models\UserAddress;

use App\Services\APIErrorHandlerService;

use Str;
use Exception;

class OrderRepository extends APIErrorHandlerService implements OrderRepositoryInterface
{
    protected $model;
    protected $modelRelationships;

    protected $orderShippingAddress;
    protected $userAddressModel;

    public function __construct(Order $model, OrderShippingAddress $orderShippingAddress, User $userModel, UserAddress $userAddressModel)
    {
        $this->model = $model;
        $this->modelRelationships = ['user', 'order_shipping_address'];

        $this->orderShippingAddress = $orderShippingAddress;
        $this->userModel = $userModel;
        $this->userAddressModel = $userAddressModel;
    }

    public function baseModel()
    {
        return $this->model->with(
            $this->modelRelationships
        );
    }

    public function generateReferenceCode()
    {
        return strtoupper('ORDER-#'.Str::random(10));
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

    public function getCustomerInfo($userId)
    {
        return $this->userModel->findOrFail($userId);
    }

    public function get($id)
    {
        try
        {
            $data = $this->baseModel()->where('id', $id)->first();

            if (!$data) {
                return response()->error('Not Found', 404);
            }

            return response()->json($data);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }

    public function create($payload, $shippingAddress)
    {
        try
        {
            $payload['reference_code'] = $this->generateReferenceCode();
            $payload['order_products'] = json_encode($payload['order_products']);
            $payload['customer_name'] = $payload['user_id'] ? null : $payload['customer_name'];
            $payload['customer_email'] = $payload['user_id'] ? null : $payload['customer_email'];

            $data = $this->baseModel()->create($payload);

            $userAddress;

            if ($payload['user_id'])
            {
                $userId = $payload['user_id'];

                $userAddress = $this->userAddressModel->where('user_id', $userId)->first();
            }

            if (!$payload['user_id'])
            {
                $userAddress = $shippingAddress;
            }

            $this->orderShippingAddress->create([
                'order_id' => $data->id,
                'address' => $userAddress['address'],
                'barangay' => $userAddress['barangay'],
                'city' => $userAddress['city'],
                'zip_code' => $userAddress['zip_code'],
                'contact_number' => $userAddress['contact_number'],
                'region' => $userAddress['region']
            ]);

            $createdOrder = $this->baseModel()->findOrFail($data->id);

            return response()->success($createdOrder, 201);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }

    public function update($payload, $id)
    {
        try
        {
            $data = $this->baseModel()->findOrFail($id);

            $data->update($payload);

            return response()->success($data);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try
        {
            $data = $this->baseModel()->find($id)->delete();

            return response()->success($data, 204);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }
}
