<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->when($request->routeIs('posts*'), function () use ($request) {
                return ($request->routeIs(['posts.index', 'posts.show'])) ? $this->description : null;
            }),
            'like' => $this->like,
            'dislike' => $this->dislike,
            'view' => $this->view,
            'active' => $this->active ? 'Còn xuất bản' : 'Ngưng xuất bản',
            'created_at' => DatetimeResource::make($this->created_at),
            'updated_at' => DatetimeResource::make($this->updated_at)
        ];
    }
}
