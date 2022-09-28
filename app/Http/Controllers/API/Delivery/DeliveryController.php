<?php

namespace App\Http\Controllers\API\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Delivery\DeliveryMemberAssign;
use App\Http\Resources\Delivery\DeliveryResource;
use App\Http\Controllers\JsonResponseTrait;

class DeliveryController extends Controller
{
    use JsonResponseTrait;

    public function collectOrders($id)
    {
        $row = Order::find($id);
        $row->order_status = 2;
        $row->save();

        return "Collect successfully.";
    }

    public function getOrders($id)
    {
        $markets = [];
        $items = [];
        $rows = DeliveryMemberAssign::where('user_id',$id)->get();

        foreach($rows as $row)
        {
            $markets[] = $row->market_id;
        }
        $orders = Order::select(
            'orders.id',
            'orders.order_no',
            'orders.order_status',
            'users.name',
            'users.phone_number',
            'markets.name as market_name',
            'shops.name as shop_name',
            'shops.shop_no',
        )
        ->join('users','orders.customer_id', "=", 'users.id')
        ->join('shops','orders.shop_id', "=", 'shops.id')
        ->join('markets','shops.market_id', "=", 'markets.id')
        ->whereIn('markets.id', $markets)
        ->where('orders.order_status', 1)
        ->get();

        return $orders;
    }
}
