<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'order_no'         => $this->order_no,
            'order_status'  => $this->order_status,
            'name'         => $this->name,
            'phone_number'         => $this->phone_number,
            'market_name'              => $this->market_name,
            'shop_name'        => $this->shop_name,
            'shop_no'        => $this->shop_no,
        ];
    }
}
