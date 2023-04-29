<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 14:20
 */

namespace App\Modules\Init\Core;


use App\Models\User;
use App\Models\UserBaseInfo;
use App\Models\UserStatusInfo;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Init\Config\InitModuleConfig;
use App\Modules\Permission\Config\DefaultPermissionConfig;
use App\Modules\Permission\Config\DefaultRoleConfig;

/**
 * Notes: 初始化超级管理员
 *
 * Class InitSuperAdmin
 * @package App\Modules\Init\Core
 */
class InitSuperAdmin extends BaseInitModule
{
    public function __construct()
    {
        parent::__construct(InitModuleConfig::INIT_SUPER_ADMIN);
    }

    /**
     * Notes: 执行逻辑
     * User: admin
     * Date: 2021/04/30 15:07
     *
     * @return bool|void
     */
    public function start()
    {
        $username = 'admin';
        $model = User::where('username', $username)->first();
        if ($model) {
            $this->setResult("Nguoi dung da ton tai");
            return;
        }

        try {
            \DB::transaction(function () use ($username) {
                $user = new User();
                $user->username = $username;
                $user->name = 'admin';
                $user->pid = 0;
                $user->password = '123123';
                $user->privacy_password = '123123';
                $user->types = \App\Modules\User\Enum\UserTypesEnum::SUPER_ADMIN;
                $user->is_active = SwitchEnum::YES;
                $user->save();

                $this->saveRecord($user);
            });

            $this->setResult("Init User thanh cong：{$username}，pass：{123123}");

        } catch (\Throwable $e) {
            $this->setResult("Init User that bai");
            \Log::error($e);
        }
    }
}
