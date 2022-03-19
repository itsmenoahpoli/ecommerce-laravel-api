<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\Products\ProductsResource;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;

use App\Services\APIErrorHandlerService;

use Str;
use Exception;

class ProductRepository extends APIErrorHandlerService implements ProductRepositoryInterface
{
    protected $model;
    protected $modelRelationships;

    protected $productImageModel;

    public function __construct(Product $model, ProductImage $productImageModel)
    {
        $this->model = $model;
        $this->modelRelationships = ['product_categories', 'product_images'];

        $this->productImageModel = $productImageModel;
    }

    public function baseModel()
    {
        return $this->model->with(
            $this->modelRelationships
        );
    }

    public function generateSku()
    {
        return strtoupper(Str::random(10));
    }

    public function getAll($query)
    {
        try
        {
            $data = $this->baseModel()->orderBy('id', 'desc')->get();

            return response()->success(ProductsResource::collection($data));
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
            $payload['sku'] = $this->generateSku();

            $imageName = $payload['sku'].'-'.time().'.'.$payload['image']->getClientOriginalExtension();
            $payload['image']->move(public_path('/images/product-images'), $imageName);

            // After upload remove image from payload
            array_splice($payload, 4, 1);

            $data = $this->model->create([
                'sku' => $payload['sku'],
                'name' => $payload['name'],
                'description' => $payload['description'],
                'quantity' => $payload['quantity'],
                'price' => $payload['price'],
                'type' => '',
            ]);

            $this->productImageModel->create([
                'product_id' => $data->id,
                'img_path' => env('APP_URL').':8000/images/product-images/'.$imageName
            ]);

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

    public function destroy($id)
    {
        try
        {
            $data = $this->model->find($id)->delete();

            return response()->success($data, 204);
        } catch (Exception $e)
        {
            return response()->error($e->getMessage());
        }
    }
}
