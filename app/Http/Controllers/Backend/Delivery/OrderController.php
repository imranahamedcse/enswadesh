<?php

namespace App\Http\Controllers\Backend\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery\DeliveryMemberAssign;
use App\Models\User;
use App\Models\Location\Market;
use App\Models\Order\Order;
use App\Models\Shop\Shop;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::select(
            'orders.id',
            'orders.order_no',
            'orders.order_status',
            'users.name',
            'users.phone_number',
            'markets.name as market_name',
            'markets.id as market_id',
            'shops.name as shop_name',
            'shops.shop_no',
        )
        ->join('users','orders.customer_id', "=", 'users.id')
        ->join('shops','orders.shop_id', "=", 'shops.id')
        ->join('markets','shops.market_id', "=", 'markets.id')
        ->orderByDesc('orders.id')
        ->get();
        // dd($orders);
        return view('backend.delivery.order.index',compact('orders'));
    }


    public function calculate()
    {
        $members = User::select(
            'users.id',
            'users.name',
            'users.phone_number',
        )
        ->join('delivery_members','delivery_members.user_id', "=", 'users.id')
        ->get();
        // dd($members);
        return view('backend.delivery.order.calculate', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
