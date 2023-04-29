<?php


namespace App\Modules\User\Repository;


use App\Models\Checkin;
use App\Models\Department;
use App\Models\Grade;
use App\Models\Market;
use App\Models\OfficeAddress;
use App\Models\Position;
use App\Models\Schedule;
use App\Models\ScheduleRule;
use App\Models\User;
use App\Models\UserBaseInfo;
use App\Models\UserStatusInfo;
use App\Modules\Common\Entity\TreeTools;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Organization\Enum\UserSortTypeEnum;
use App\Modules\User\Enum\UserTypesEnum;
use App\Modules\User\Resource\UserResource;
use App\Modules\UserRoles\Enum\DefaultUserRoleEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Notes: 用户表SQL操作
 *
 * Class UserRepository
 * @package App\Modules\User\Repository
 */
class UserRepository
{
    private $user;

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Notes: 创建用户
     * User: admin
     * Date: 2021/04/29 23:40
     *
     * @param \App\Modules\User\Entity\UserVO $user
     * @return User
     */
    public function create(\App\Modules\User\Entity\UserVO $user)
    {
        $createUser = new User();
        $createUser->username = $user->getUsername();
        $createUser->name = $user->getName();
        $createUser->password = $user->getPassword();
        $createUser->pid = 1;
        $createUser->privacy_password = '123123';
        $createUser->types = $user->getTypes();
        $createUser->is_active = $user->getIsActive();
        $createUser->save();

        return $createUser;
    }

    /**
     * Notes: 根据工号查找用户
     * User: admin
     * Date: 2021/04/29 23:40
     *
     * @param $username
     * @return mixed
     */
    public function findByUserName($username)
    {
        return User::where('username', $username)->first();
    }

    /**
     * Notes: 根据艺名查找用户
     * User: admin
     * Date: 2021/04/29 23:40
     *
     * @param $name
     * @return mixed
     */
    public function findByName($name)
    {
        return User::where('name', $name)->first();
    }

    /**
     * Notes: 根据id查找
     * User: admin
     * Date: 2021/04/29 23:40
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return User::where('id', $id)->first();
    }

    /**
     * Notes: 根据字段查找用户是否存在
     * User: admin
     * Date: 2021/04/29 23:41
     *
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function existsUser(string $field, $value)
    {
        return User::where($field, $value)->exists();
    }

    /**
     * Notes: 根据id列表查找用户
     * User: admin
     * Date: 2021/04/29 23:41
     *
     * @param $ids
     * @param string[] $columns
     * @return mixed
     */
    public function listByIds($ids, $columns = ['*'])
    {
        return User::whereIn('id', $ids)->get($columns);
    }

    /**
     * Notes: 根据工号列表查询
     * User: admin
     * Date: 2021/04/29 23:41
     *
     * @param $usernames
     * @param string[] $columns
     * @return mixed
     */
    public function listByUsernames($usernames, $columns = ['*'])
    {
        return User::whereIn('username', $usernames)->get($columns);
    }


    /**
     * Notes: 查找所有用户
     * User: admin
     * Date: 2021/04/29 23:41
     *
     * @return mixed
     */
    public function all()
    {
        $username = request()['username'];
        $name = request()['name'];
        //不同的角色獲取不同的用戶列表
            $select = User::selectRaw('id, username, name, types')->where('is_active', SwitchEnum::YES);
        $select->whereIn('id', $this->getMeAndChild(my_user_id()));
            if ($username) {
                $select->where('username', 'like', '%'.$username.'%');
            }
            if ($name) {
                $select->where('name', 'like', '%'.$name.'%');
            }
            $isPaginate = request()['is_paginate'];
        if ($isPaginate == SwitchEnum::YES) {
            $result = $select->paginate(request()['limit']);
            return utils()->paginate($result, UserResource::collection($result));
        }
        $result = $select->get();
        return UserResource::collection($result);
    }

    /**
     * Notes: 查找普通用户
     * User: admin
     * Date: 2021/04/29 23:42
     *
     * @param null $userIds
     * @return mixed
     */
    public function listCommonUser($userIds = null)
    {
        $select = User::where('types', UserTypesEnum::USER);

        if ($userIds) {
            $select->whereIn('id', $userIds);
        }

        return $select->get();
    }

    /**
     * Notes: 根据工号或者艺名模糊查找用户
     * User: admin
     * Date: 2021/04/29 23:42
     *
     * @param $value
     * @return mixed
     */
    public function search($value)
    {
        $select = User::types()->select(['id', 'username', 'name']);

        if ($value) {
            $select->whereRaw("concat(username,name) like '%{$value}%'");
        }

        return $select->paginate();
    }

    /**
     * Notes: 根据工号或者艺名检测用户是否存在
     * User: admin
     * Date: 2021/04/29 23:43
     *
     * @param $username
     * @param $name
     * @return mixed
     */
    public function checkUser($username, $name)
    {
        $select = User::select(['id', 'username', 'name']);

        if ($username) {
            $select->where("username", $username);
        }
        if ($name) {
            $select->where("name", $name);
        }

        return $select->exists();
    }

    /**
     * Notes: 安全密码验证
     * User: admin
     * Date: 2021/04/29 23:44
     *
     * @return mixed
     */
    public function checkNullPrivacyPassword()
    {
        return User::where('privacy_password', '')->exists();
    }

    public function getMeAndChild($id)
    {
        return TreeTools::findMeAndChild(User::tableName(), $id);
    }
}
