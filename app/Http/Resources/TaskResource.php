<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'id' => $this->id_task,
            'name' => $this->name,
            'description' => $this->description,
            'creation_date' => $this->creation_date,
            'due_date' => $this->due_date,
            'issue' => $this->issue
        ];
    }
}
