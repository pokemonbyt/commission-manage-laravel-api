<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/29 16:58
 */

namespace App\Modules\User\Entity;

use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\User\Enum\UserTypesEnum;
use Illuminate\Http\Request;

/**
 * Notes: 用户数据类
 *
 * Class User
 * @package App\Modules\User\Entity
 */
class UserVO
{
    private $username;
    private $name;
    private $types;
    private $password;
    private $is_active;
    private $pid;

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param mixed $pid
     */
    public function setPid($pid): void
    {
        $this->pid = $pid;
    }

    public function setRequest(Request $request)
    {
        $this->setUsername($request->username);
        $this->setName($request->name);
        $this->setTypes($request->types);
        $this->setPid(my_user_id());
        $this->setIsActive(SwitchEnum::YES);
        $this->setPassword($request->password);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = utils()->replaceSpace($username);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = utils()->replaceSpace($name);
    }

    /**
     * @return mixed
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param mixed $types
     */
    public function setTypes($types): void
    {
        $this->types = $types;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
