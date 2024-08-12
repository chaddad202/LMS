<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\order\OrderRequest;
use App\Http\Resources\order\OrderIndexResource;
use App\Http\Resources\order\OrderShowResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class OrderController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return OrderIndexResource::collection($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $user_id = auth()->user()->id;
        Order::create([
            'user_id' => $user_id,
            'amount' => $request->amount
        ]);
        return $this->returnSuccessMessage('submit successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($order_id)
    {
        $order = Order::findOrFail($order_id);
        return new OrderShowResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function submit($order_id)
    {
        $order = Order::findOrFail($order_id);
        $amount = $order->amount;
        $user = User::findOrFail($order->user_id);
        $wallet =  $user->wallet + $amount;
        $user->update([
            'wallet' => $wallet
        ]);
        $order->delete();
        return $this->returnSuccessMessage('submited successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
