<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class modificador extends JsonResource
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
            'fecha' => $this->fecha,
            'valor' => $this->valor,
            'SoB' => $this->SoB,
        ];
    }
}
