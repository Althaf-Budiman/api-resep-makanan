<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeDetailResource extends JsonResource
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
            'title' => $this->title,
            'recipe_content' => $this->recipe_content,
            'author_id' => $this->author,
            'writer' => $this->whenLoaded('writer'),
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s")
        ];
    }
}
