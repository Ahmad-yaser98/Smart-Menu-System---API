<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price . ' $', 
            'is_available' => $this->is_available ? 'متاح' : 'غير متاح',
            'category_name' => $this->whenLoaded('category', function () {
                return $this->category->name; 
            }),
        ];
    }
}
