<?php

namespace App\Providers;

use App\Events\UserCreate;
use App\Listeners\CheckinServerNotification;
use App\Listeners\CloudDiskUserInitNotification;
use App\Listeners\InductionScheduleNotification;
use App\Listeners\InitAllowanceAfterUserCreate;
use App\Listeners\InitAnnualLeaveAfterUserCreate;
use App\Listeners\InitDepositAfterUserCreate;
use App\Listeners\InitTaskScoreAfterUserCreate;
use App\Listeners\OldOAUserInitNotification;
use App\Listeners\PromotionSystemUserInitNotification;
use App\Listeners\UserHasFunctionInitNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Telanflow\Binlog\Contracts\EventInterface;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        /**
         * 监听考勤服务器数据库变动事件
         */
        EventInterface::class => [
            CheckinServerNotification::class,
        ],
        /**
         * 用户创建事件
         */
        UserCreate::class => [
            //用户功能初始化
            UserHasFunctionInitNotification::class,
            //初始化用户排班
            InductionScheduleNotification::class,
            //初始化机票药补
            InitAllowanceAfterUserCreate::class,
            //初始化年假
            InitAnnualLeaveAfterUserCreate::class,
            //初始化任务积分
            InitTaskScoreAfterUserCreate::class,
            //初始化押金扣款
            InitDepositAfterUserCreate::class,
            //初始化云盘用户
            CloudDiskUserInitNotification::class,
            //初始化推广系统用户
            PromotionSystemUserInitNotification::class,
            //初始化旧OA系统用户
            OldOAUserInitNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
