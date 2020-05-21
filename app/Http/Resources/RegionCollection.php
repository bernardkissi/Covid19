<?php

namespace App\Http\Resources;

use App\Http\Resources\RegionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RegionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return RegionResource::collection($this->collection);
    }
}
