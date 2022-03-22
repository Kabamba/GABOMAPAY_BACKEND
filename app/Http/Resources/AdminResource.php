<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "prenom" => $this->prenom,
            "email" => $this->email,
            "is_active" => $this->is_active,     
            "country" => $this->country->name,
            "iso" => $this->country->iso3,
            "country_id" => $this->country->id,
            "created_at" => date('Y-m-d à H:i', strtotime($this->created_at))
        ];
    }
}
