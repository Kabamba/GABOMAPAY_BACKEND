<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            $devise = "fcfa";
        } elseif ($this->type_trans == 2) {
            $devise = "$";
        } elseif ($this->type_trans == 3) {
            $devise = "$";
        } elseif ($this->type_trans == 4) {
            $devise = "$";
        } elseif ($this->type_trans == 5) {
            $devise = "$";
        } elseif ($this->type_trans == 6) {
            $devise = "fcfa";
        } elseif ($this->type_trans == 7) {
            $devise = "fcfa";
        }

        return [
            "id" => $this->id,
            "montant" => $this->montant,
            "devise" => $devise,
            "date_trans" => $this->date_trans,
            "date_time_trans" => date('Y-m-d à H:i', strtotime($this->date_time_trans)),
            "reference" => $this->reference,
            "status" => $this->status,
            "raison" => $this->raison,
            "type_trans" => $this->type_trans,
            "paie_syst" => $this->paie_syst,
            "user" => UserResource::make($this->user),
            "country" => $this->country,
        ];
    }
}
