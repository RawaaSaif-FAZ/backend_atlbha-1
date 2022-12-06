<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         return [
            'id' =>$this->id,
            'type' => $this->type,
            'product' => New ProductResource($this->product),
            'title' => $this->title,
            'value' => $this->value,
'status' => $this->status !== null ? $this->status : 'active',
            'is_deleted' => $this->is_deleted !== null ? $this->is_deleted : 0,
        ];
    }
}
