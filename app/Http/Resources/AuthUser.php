<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUser extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'policies' => $this->when(auth()->check(), function() {
                return collect([
                    'view_any_students' => auth()->user()->can('viewAny', \App\Student::class),
                    'create_student' => auth()->user()->can('create', \App\Student::class),
                ])->filter(function($item) {return $item == true; })->keys();
            }),
        ];
    }
}
