<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'complete_name' => $this->complete_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'level' => new Level($this->whenLoaded('level')),
            'parents' => new Parents($this->whenLoaded('parents')),
            'policies' => $this->when(auth()->check(), function() {
                return collect([
                    'view' => auth()->user()->can('view', $this->resource),
                    'update' => auth()->user()->can('update', $this->resource),
                    'enable' => auth()->user()->can('enable', $this->resource),
                    'disable' => auth()->user()->can('disable', $this->resource),
                ]);
            })
        ]);
    }
}
