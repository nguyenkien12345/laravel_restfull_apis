<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Trả ra các field chỉ định của 1 đối tượng Invoice
        // Ta cũng có thể hoàn toàn custom key trả về của đối tượng
        // vd billed_date => billedDate, paid_date => paidDate, void_date => voidDate
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'billedDate' => $this->billed_date,
            'paidDate' => $this->paid_date,
            'voidDate' => $this->void_date,
        ];
    }
}
