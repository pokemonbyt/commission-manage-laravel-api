<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 15:05
 */

namespace App\Modules\Init\Service;


use App\Modules\Init\Core\InitAllowance;
use App\Modules\Init\Core\InitAnnouncement;
use App\Modules\Init\Core\InitAnnualLeave;
use App\Modules\Init\Core\InitAttendanceType;
use App\Modules\Init\Core\InitCheckin;
use App\Modules\Init\Core\InitCostCategory;
use App\Modules\Init\Core\InitCountry;
use App\Modules\Init\Core\InitCurrency;
use App\Modules\Init\Core\InitDepartmentPost;
use App\Modules\Init\Core\InitDepartmentWelfare;
use App\Modules\Init\Core\InitDeposit;
use App\Modules\Init\Core\InitDormitoryAddress;
use App\Modules\Init\Core\InitDormitoryFees;
use App\Modules\Init\Core\InitDormitoryUserFees;
use App\Modules\Init\Core\InitDormitoryUserRecord;
use App\Modules\Init\Core\InitHolidayLeave;
use App\Modules\Init\Core\InitInvoice;
use App\Modules\Init\Core\InitMakeUps;
use App\Modules\Init\Core\InitMenuPermissions;
use App\Modules\Init\Core\InitDefaultRole;
use App\Modules\Init\Core\InitDepartment;
use App\Modules\Init\Core\InitFunctionManage;
use App\Modules\Init\Core\InitOfficeAddress;
use App\Modules\Init\Core\InitPhoneNumber;
use App\Modules\Init\Core\InitPosition;
use App\Modules\Init\Core\InitPositionTime;
use App\Modules\Init\Core\InitRepair;
use App\Modules\Init\Core\InitRouterPermissions;
use App\Modules\Init\Core\InitRouters;
use App\Modules\Init\Core\InitSchedule;
use App\Modules\Init\Core\InitScheduleRule;
use App\Modules\Init\Core\InitScroll;
use App\Modules\Init\Core\InitSuperAdmin;
use App\Modules\Init\Core\InitTaskScore;
use App\Modules\Init\Core\InitTranslate;
use App\Modules\Init\Core\InitUser;
use App\Modules\Init\Core\InitUserInDormitory;
use App\Modules\Init\Core\InitUserOldSystemInfo;
use App\Modules\Init\Core\InitWarehouseAddress;
use App\Modules\Init\Core\InitWarehouseCategoryTypes;
use App\Modules\Init\Core\InitWarehouseCheck;
use App\Modules\Init\Core\InitWarehouseDoc;
use App\Modules\Init\Core\InitWarehouseGoods;
use App\Modules\Init\Core\InitWarehouseMainFixed;
use App\Modules\Init\Core\InitWarehouseMainRecord;
use App\Modules\Init\Core\InitWarehouseMainRecordFirst;
use App\Modules\Init\Core\InitWarehouseMainRecordSecond;
use App\Modules\Init\Core\InitWarehouseMainRecordThird;
use App\Modules\Init\Core\InitWarehouseShelf;
use App\Modules\Init\Core\InitWelfare;
use App\Modules\Init\Core\InitWorkArrangementType;
use App\Modules\Init\Core\InitWorkArrangementUser;
use App\Modules\Init\Repository\InitRepository;

/**
 * Notes: 项目初始化业务
 *
 * Class InitService
 * @package App\Modules\Init\Service
 */
class InitService
{
    private $repository;

    public function __construct(InitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Notes: 初始化系统超级管理员
     * User: admin
     * Date: 2021/04/30 15:05
     *
     * @return mixed|string
     */
    public function initSuperAdmin()
    {
        return (new InitSuperAdmin())->result();
    }
}
