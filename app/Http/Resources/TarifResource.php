<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TarifResource extends JsonResource
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
            "frais_operateur" => $this->frais_ope,
            "frais_perso" => $this->frais_perso,
            "operateur_id" => $this->operator->id,
            "operateur_name" => $this->operator->libelle
        ];
    }
}
