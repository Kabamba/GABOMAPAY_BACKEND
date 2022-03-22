<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "phone" => $this->phone,
            "solde" => $this->solde,
            "is_active" => $this->is_active,
            "adresse" => $this->adresse,
            "sexe" => $this->sexe,
            "identite" => $this->identite,
            "profile" => $this->profile,
            "country" => $this->country->name,
            "country_id" => $this->country->id,
            "iso" => $this->country->iso3,
            "created_at" => date('Y-m-d à H:i', strtotime($this->created_at))
        ];
    }
}
