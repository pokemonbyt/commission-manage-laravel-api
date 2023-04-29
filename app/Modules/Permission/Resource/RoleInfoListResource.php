<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/28 15:53
 */

namespace App\Modules\Permission\Resource;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Notes: 角色信息列表
 *
 * Class RoleInfoListResource
 * @package App\Modules\Permission\Resource
 */
class RoleInfoListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->model_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'role_name' => $this->role->name,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
