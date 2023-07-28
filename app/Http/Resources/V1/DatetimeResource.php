<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatetimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    //  Chỉ trả về những field chỉ định ta khai báo bên dưới
    public function toArray(Request $request): array
    {
        return [
            'human' => $this->diffForHumans(),
            'date_time' => $this->toDateTimeString(),
        ];
    }
}
