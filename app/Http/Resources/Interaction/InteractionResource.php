<?php

namespace App\Http\Resources\Interaction;

use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
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
            'id' => $this->id,
            'interaction_category_id' => $this->interaction_category_id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'user' => $this->user->name,
            'profile' => $this->profile->image,
            'category'=> $this->category,
            'topic' => $this->topic,
            'file' => $this->file,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
