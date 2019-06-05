<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MemberResource as MemberResource;
use App\Http\Resources\SubTaskResource as SubTaskResource;

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
            'id_proj' => $this->id_project,
            'name' => $this->name,
            'description' => $this->description,
            'creation_date' => $this->creation_date,
            'due_date' => $this->due_date,
            'issue' => $this->issue,
            'list_name' => $this->list_name,
            'checklist' => SubTaskResource::collection($this->checklist()),
            'members' => MemberResource::collection($this->members())
        ];
    }
}
