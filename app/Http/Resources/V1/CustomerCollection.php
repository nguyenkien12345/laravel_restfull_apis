<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Trả lại toàn bộ các data của đối tượng model Customer
            'data' => $this->collection,
            // Cấu hình lại meta thay vì trả hết toàn bộ các thuộc tính thì ta sẽ chỉ định chỉ trả về những thuộc tính nào
            'meta' => [
                'total' => $this->total(),
                'perPage' => $this->perPage(),
                'currentPage' => $this->currentPage(),
                'lastPage' => $this->lastPage(),
            ]
        ];
    }
}
