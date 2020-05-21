<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TownResource extends JsonResource
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

            'name' => $this->name,
            'confirmed' => $this->confirmed,
            'active'  => $this->active,
            'recovered' => $this->recovered,
            'deceased' => $this->deceased
        ];
    }
}
