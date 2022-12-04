<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'name' => $this->name,
            'monthly_price' => $this->monthly_price,
            'yearly_price' => $this->yearly_price,
            'discount' => $this->discount,
            'status' => $this->status,
            'is_deleted' => $this->is_deleted
        ];
    }
}
