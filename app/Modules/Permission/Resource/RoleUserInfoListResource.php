<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/30 11:38
 */

namespace App\Modules\Permission\Resource;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Notes: 角色拥有的用户信息列表
 *
 * Class RoleUserInfoListResource
 * @package App\Modules\Permission\Resource
 */
class RoleUserInfoListResource extends JsonResource
{
    public function toArray($request)
    {
        $info = $this->user_status_info;
        if ($info) {
            $officeAddress = $info->office_address;
            if ($officeAddress) {
                $office_address_id = $officeAddress->id;
                $office_address_name = $officeAddress->name;
            }

            $department = $info->department;
            if ($department) {
                $department_id = $department->id;
                $department_name = $department->name;
            }

            $position = $info->position;
            if ($position) {
                $position_id = $position->id;
                $position_name = $position->name;
            }
        }

        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'office_address_id' => $office_address_id??'',
            'office_address_name' => $office_address_name??'',
            'department_id' => $department_id??'',
            'department_name' => $department_name??'',
            'position_id' => $position_id??'',
            'position_name' => $position_name??'',
        ];
    }
}
