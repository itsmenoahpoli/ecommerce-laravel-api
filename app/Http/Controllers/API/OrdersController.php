<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\OrderRepository;
use App\Http\Requests\Orders\OrderRequest;

/**
 * @group Orders API
 * APIs for orders management (create, read, update, delete)
 */
class OrdersController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Orders List
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->query();

        return $this->orderRepository->getAll($query);
    }

    /**
     * Create Order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        return $this->orderRepository->create($request->except('shipping_address'), $request->shipping_address);
    }

    /**
     * Show Order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->orderRepository->get($id);
    }

    /**
     * Update Order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        return $this->orderRepository->get($request->all(), $id);
    }

    /**
     * Delete Order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->productCategoryRepository->destroy($id);
    }
}
