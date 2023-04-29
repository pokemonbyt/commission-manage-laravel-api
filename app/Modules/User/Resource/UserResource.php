<?php

namespace App\Modules\User\Resource;

use App\Models\User;
use App\Modules\User\Enum\UserTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * 用户信息资源
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (my_types() != UserTypesEnum::USER) {
            $p = User::where('id', $this->pid)->first();
            return [
                'id' => $this->id,
                'username' => $this->username,
                'name' => $this->name,
                'types' => $this->types,
                'pid_name' => $p ? $p->name : 'BOSS',
                'pid_username' => $p ? $p->username : 'BOSS'
            ];
        }
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'types' => $this->types,
            'pid_name' => $this->name,
            'pid_username' => $this->username,
        ];

    }
}
