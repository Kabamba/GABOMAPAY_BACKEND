<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompteToMobileRdc extends JsonResource
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
            "montant" => $this->montant,
            "date_trans" => $this->date_trans,
            "date_time_trans" => date('Y-m-d à H:i', strtotime($this->date_time_trans)),
            "reference" => $this->reference,
            "status" => $this->status,
            "raison" => $this->raison,
            "type_trans" => $this->type_trans,
            "user" => UserResource::make($this->user),
            "country" => $this->country,
            "operator_name" => $this->compte_to_mobile_rdc->operator->libelle,
            "more" => $this->compte_to_mobile_rdc,
            "second_id" => $this->second_id
        ];
    }
}
