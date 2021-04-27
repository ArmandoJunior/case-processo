<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Registry extends JsonResource
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
            'cpf' => $this->cpf,
            'cpf_invalid' => $this->cpf_invalid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
