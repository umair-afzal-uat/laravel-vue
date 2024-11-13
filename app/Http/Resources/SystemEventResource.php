<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemEventResource extends JsonResource
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
            'event_type' => $this->event_type,
            'event_description' => $this->event_description,
            'event_data' => $this->event_data,
            'occurred_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
