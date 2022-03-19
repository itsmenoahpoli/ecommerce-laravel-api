<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Resources\Users\UsersResource;
use App\Models\User;

use Exception;

class UserRepository implements UserRepositoryInterface
{
    protected $model;
    protected $modelRelationships;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->modelRelationships = ['user_addresses'];
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

    public function create($payload)
    {
        try
        {
            $payload['password'] = bcrypt($payload['password']);

            $data = $this->baseModel()->create($payload);

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
