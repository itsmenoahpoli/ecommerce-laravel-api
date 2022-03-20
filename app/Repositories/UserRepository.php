<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Resources\Users\UsersResource;
use App\Models\User;
use App\Models\UserAddress;

use Exception;

class UserRepository implements UserRepositoryInterface
{
    protected $model;
    protected $modelRelationships;

    protected $userAddressModel;

    public function __construct(User $model, UserAddress $userAddressModel)
    {
        $this->model = $model;
        $this->modelRelationships = ['user_address'];

        $this->userAddressModel = $userAddressModel;
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

            return response()->success(UsersResource::collection($data));
        } catch (Exception $e)
        {
            return response()->json($e->getMessage(), 500);
        }
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

    public function create($payload, $address)
    {
        try
        {
            $payload['password'] = bcrypt($payload['password']);

            $data = $this->baseModel()->create($payload);

            if ($address)
            {
                $this->userAddressModel->create(
                    array_merge(
                        [
                            'user_id' => $data->id,
                        ],
                        $address
                    )
                );
            }

            return response()->success([
                'user' => $data,
                'user_address' => $address
            ], 201);
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

    public function getUserInfo($userId)
    {
        return $this->baseModel()->find($userId);
    }
}
