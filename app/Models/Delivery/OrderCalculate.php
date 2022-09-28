<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order\Order;
use App\Models\Delivery\DeliveryMemberAssign;

class OrderCalculate extends Model
{
    use HasFactory;

    // public static function status($id)
    // {
    //     $row = OrderCalculate::where('order_id',$id)->first();
    //     if($row != null)
    //     {
    //         switch ($row->status) {
    //             case 0:
    //                 return 'Canceled';
    //                 break;
    //             case 1:
    //                 return 'Pending';
    //                 break;
    //             case 2:
    //                 return 'Processing';
    //                 break;
    //             case 3:
    //                 return 'Delivery';
    //                 break;
    //             case 4:
    //                 return 'Complete';
    //                 break;
    //             case 5:
    //                 return 'Refund';
    //                 break;
    //         }
    //     }
    //     else 
    //         return 'Pending';
    // }

    public static function name($id)
    {
        $row = DeliveryMemberAssign::where('market_id',$id)->first();
        if($row != null)
        {
            $user = User::where('id',$row->user_id)->first();
            return $user->name . '('. $user->phone_number .')';
        }
        else 
            return 'Pending';
    }

    public static function cancel($id)
    {
        return OrderCalculate::where('user_id',$id)->where('status',0)->count();
    }

    public static function pending($id)
    {
        $row = DeliveryMemberAssign::where('user_id',$id)->first();
        if($row != null)
        {
            $orders = Order::join('users','orders.customer_id', "=", 'users.id')
            ->join('shops','orders.shop_id', "=", 'shops.id')
            ->join('markets','shops.market_id', "=", 'markets.id')
            ->where('markets.id',$row->market_id)
            ->count();
            return $orders;
        }
        else
            return 0;
        // return OrderCalculate::where('user_id',$id)->where('status',1)->count();
    }

    public static function processing($id)
    {
        return OrderCalculate::where('user_id',$id)->where('status',2)->count();
    }

    public static function delivery($id)
    {
        return OrderCalculate::where('user_id',$id)->where('status',3)->count();
    }

    public static function complete($id)
    {
        return OrderCalculate::where('user_id',$id)->where('status',4)->count();
    }

    public static function refund($id)
    {
        return OrderCalculate::where('user_id',$id)->where('status',5)->count();
    }

}
