<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompteToCompteRdc extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->type_trans == 1) {
            $type_name = "Depôt";
        } elseif ($this->type_trans == 2) {
            $type_name = "Depôt";
        } elseif ($this->type_trans == 3) {
            $type_name = "Transac cmpt à cmpt";
        } elseif ($this->type_trans == 4) {
            $type_name = "";
        } elseif ($this->type_trans == 5) {
            $type_name = "Transac cmpt à cmpt";
        } elseif ($this->type_trans == 6) {
            $type_name = "";
        } elseif ($this->type_trans == 7) {
            $type_name = "";
        }

        return [
            "id" => $this->id,
            "montant" => $this->montant,
            "date_trans" => $this->date_trans,
            "date_time_trans" => date('Y-m-d à H:i', strtotime($this->date_time_trans)),
            "reference" => $this->reference,
            "status" => $this->status,
            "raison" => $this->raison,
            "type_trans" => $this->type_trans,
            "type_trans_name" => $type_name,
            "user" => UserResource::make($this->user),
            "country" => $this->country,
            "more" => UserResource::make($this->compte_to_compte_rdc->recever),
            "second_id" => $this->second_id
        ];
    }
}
