<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/8/21 15:49
 */

namespace App\Modules\Permission\Config;

/**
 * Notes: 系统默认权限
 *
 * Class DefaultPermissionConfig
 * @package App\Modules\Permission\Config
 */
class DefaultPermissionConfig
{
    //[流程中心] 删除考勤类单据最高权限
    const DELETE_ATTENDANCE = "delete.attendance.process";
    //[流程中心] 查看考勤类单据最高权限
    const VIEW_ATTENDANCE = "view.attendance.process";
    //[流程中心] 删除领用护照单据最高权限
    const DELETE_PASSPORT = "delete.passport.process";
    //[流程中心] 查看领用护照单据最高权限
    const VIEW_PASSPORT = "view.passport.process";
    //[流程中心] 删除转正单据最高权限
    const DELETE_TURN = "delete.turn.process";
    //[流程中心] 查看转正单据最高权限
    const VIEW_TURN = "view.turn.process";
    //[流程中心] 删除批量调部门单据最高权限
    const DELETE_DEPARTMENT = "delete.department.process";
    //[流程中心] 查看批量调部门单据最高权限
    const VIEW_DEPARTMENT = "view.department.process";
    //[流程中心] 删除批量调办公地点单据最高权限
    const DELETE_OFFICE = "delete.office.process";
    //[流程中心] 查看批量调办公地点部门单据最高权限
    const VIEW_OFFICE = "view.office.process";
    //[流程中心] 删除调薪单据最高权限
    const DELETE_WAGE = "delete.wage.process";
    //[流程中心] 查看调薪单据最高权限
    const VIEW_WAGE = "view.wage.process";
    //[流程中心] 查看调薪单内的工资字段权限
    const VIEW_WAGE_FIELD = "view.wage.field.process";
    //[流程中心] 删除停薪留职单据最高权限
    const DELETE_LEAVE_WITHOUT_PAY = "delete.leave.without.pay.process";
    //[流程中心] 查看停薪留职单据最高权限
    const VIEW_LEAVE_WITHOUT_PAY = "view.leave.without.pay.process";
    //[流程中心] 删除辞职或者辞退单据最高权限
    const DELETE_RESIGNATION = "delete.resignation.process";
    //[流程中心] 查看辞职或者辞退单据最高权限
    const VIEW_RESIGNATION = "view.resignation.process";
    //[流程中心] 查看辞职或者辞退单内银行卡相关数据权限
    const VIEW_RESIGNATION_FIELD = "view.resignation.field.process";
    //[流程中心] 删除离职交接单最高权限
    const DELETE_HANDOVER = "delete.handover.process";
    //[流程中心] 查看离职交接单最高权限
    const VIEW_HANDOVER = "view.handover.process";
    //[流程中心] 删除宿舍类单据的最高权限
    const DELETE_DORMITORY = "delete.dormitory.process";
    //[流程中心] 查看宿舍类单据的最高权限
    const VIEW_DORMITORY = "view.dormitory.process";
    //[流程中心] 删除财务类单据的最高权限
    const DELETE_FINANCE = "delete.finance.process";
    //[流程中心] 查看财务类单据的最高权限
    const VIEW_FINANCE = "view.finance.process";

    //[公告通知] 审批公告
    const ANNOUNCEMENT_APPROVAL = "announcement.approval";

    /**
     * Notes: 获取名字
     * User: admin
     * Date: 2020/8/21 16:06
     *
     * @return string[]
     */
    public static function getNames()
    {
        return [
            self::DELETE_ATTENDANCE => "[流程中心] 删除考勤类单据最高权限",
            self::VIEW_ATTENDANCE => "[流程中心] 查看考勤类单据最高权限",
            self::DELETE_PASSPORT => "[流程中心] 删除领用护照单据最高权限",
            self::VIEW_PASSPORT => "[流程中心] 查看领用护照单据最高权限",
            self::DELETE_TURN => "[流程中心] 删除转正单据最高权限",
            self::VIEW_TURN => "[流程中心] 查看转正单据最高权限",
            self::DELETE_DEPARTMENT => "[流程中心] 删除批量调部门单据最高权限",
            self::VIEW_DEPARTMENT => "[流程中心] 查看批量调部门单据最高权限",
            self::DELETE_OFFICE => "[流程中心] 删除批量调办公地点单据最高权限",
            self::VIEW_OFFICE => "[流程中心] 查看批量调办公地点部门单据最高权限",
            self::DELETE_WAGE => "[流程中心] 删除调薪单据最高权限",
            self::VIEW_WAGE => "[流程中心] 查看调薪单据最高权限",
            self::VIEW_WAGE_FIELD => '[流程中心] 查看调薪单内的工资字段权限',
            self::DELETE_LEAVE_WITHOUT_PAY => "[流程中心] 删除停薪留职单据最高权限",
            self::VIEW_LEAVE_WITHOUT_PAY => "[流程中心] 查看停薪留职单据最高权限",
            self::DELETE_RESIGNATION => "[流程中心] 删除辞职或者辞退单据最高权限",
            self::VIEW_RESIGNATION => "[流程中心] 查看辞职或者辞退单据最高权限",
            self::VIEW_RESIGNATION_FIELD => "[流程中心] 查看辞职或者辞退单内银行卡相关数据权限",
            self::DELETE_HANDOVER => "[流程中心] 删除离职交接单最高权限",
            self::VIEW_HANDOVER => "[流程中心] 查看离职交接单最高权限",
            self::DELETE_DORMITORY => "[流程中心] 删除宿舍类单据的最高权限",
            self::VIEW_DORMITORY => "[流程中心] 查看宿舍类单据的最高权限",
            self::DELETE_FINANCE => "[流程中心] 删除宿舍类单据的最高权限",
            self::VIEW_FINANCE => "[流程中心] 查看财务类单据的最高权限",

            self::ANNOUNCEMENT_APPROVAL => "[公告通知] 审批公告",
        ];
    }

    /**
     * Notes: 获取备注
     * User: admin
     * Date: 2020/8/21 16:08
     *
     * @return string[]
     */
    public static function getDescription()
    {
        return [
            self::DELETE_ATTENDANCE => "有这个权限可以无视规则删除考勤类的单据",
            self::VIEW_ATTENDANCE => "有这个权限可以无视规则查看考勤类的单据",
            self::DELETE_PASSPORT => "删除领用护照单据最高权限",
            self::VIEW_PASSPORT => "查看领用护照单据最高权限",
            self::DELETE_TURN => "删除转正单据最高权限",
            self::VIEW_TURN => "查看转正单据最高权限",
            self::DELETE_DEPARTMENT => "删除批量调部门单据最高权限",
            self::VIEW_DEPARTMENT => "查看批量调部门单据最高权限",
            self::DELETE_OFFICE => "删除批量调办公地点单据最高权限",
            self::VIEW_OFFICE => "查看批量调办公地点部门单据最高权限",
            self::DELETE_WAGE => "删除调薪单据最高权限",
            self::VIEW_WAGE => "有这个权限可以查看调薪单据和查看单据内的工资的权限",
            self::VIEW_WAGE_FIELD => '查看调薪单内的工资字段权限',
            self::DELETE_LEAVE_WITHOUT_PAY => "删除停薪留职单据最高权限",
            self::VIEW_LEAVE_WITHOUT_PAY => "查看停薪留职单据最高权限",
            self::DELETE_RESIGNATION => "删除辞职或者辞退单据最高权限",
            self::VIEW_RESIGNATION => "查看辞职或者辞退单据最高权限",
            self::VIEW_RESIGNATION_FIELD => "查看辞职或者辞退单内银行卡相关数据权限",
            self::DELETE_HANDOVER => "删除离职交接单最高权限",
            self::VIEW_HANDOVER => "查看离职交接单最高权限",
            self::DELETE_DORMITORY => "删除宿舍类单据的最高权限",
            self::VIEW_DORMITORY => "查看宿舍类单据的最高权限",
            self::DELETE_FINANCE => "删除宿舍类单据的最高权限",
            self::VIEW_FINANCE => "查看财务类单据的最高权限",

            self::ANNOUNCEMENT_APPROVAL => "有这个权限可以审批公告",
        ];
    }
}
