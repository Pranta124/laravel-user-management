<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles' => $this->roles->pluck('id'),
            'permissions' => $this->getPermissionsViaRoles()->pluck('name')->toArray(),
        ];
    }
}