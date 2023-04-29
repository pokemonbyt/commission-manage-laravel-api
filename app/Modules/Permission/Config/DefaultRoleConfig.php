<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/7/28 12:37
 */

namespace App\Modules\Permission\Config;


/**
 * Notes: 配置项目内置的角色
 *
 * Class DefaultRoleConfig
 * @package App\Modules\Permission\Config
 */
class DefaultRoleConfig
{
    /**
     * 超级管理员
     */
    const SUPER_ADMIN = 'super_admin';
    /**
     * 基础角色，所有人员都需要拥有
     */
    const BASE = "base";
    /**
     * 推广员角色，推广部人员拥有
     */
    const PROMOTER = "promoter";
    /**
     * 后勤角色，后勤部人员拥有
     */
    const LOGISTICS = "logistics";
    /**
     * 菲籍员工使用的角色，菲籍人员拥有
     */
    const LOCALS = "locals";

    /**
     * 部门主管
     */
    const DEPARTMENT_HEAD = "department_head";
    /**
     * 部门助理
     */
    const DEPARTMENT_ASSISTANT = "department_assistant";
    /**
     * 财务会计
     */
    const FINANCIAL_ACCOUNTING = "financial_accounting";
    /**
     * 财务出纳
     */
    const FINANCIAL_CASHIER = "financial_cashier";
    /**
     * 仓库管理员
     */
    const WAREHOUSE_MANAGER = "warehouse_manager";
    /**
     * 宿舍管理员
     */
    const DORMITORY_MANAGER = "dormitory_manager";
    /**
     * 护照管理员
     */
    const PASSPORT_MANAGER = "passport_manager";
//    /**
//     * 调薪管理员
//     */
//    const SALARY_MANAGER = "salary_manager";
    /**
     * 停薪管理员
     */
    const STOP_PAY_MANAGER = "stop_pay_manager";
    /**
     * 组织调动管理员
     */
    const ORGANIZATION_TRANSFER_MANAGER = "organization_transfer_manager";
    /**
     * 员工离职管理员
     */
    const EMPLOYEE_DEPARTURE_MANAGER = "employee_departure_manager";
    /**
     * 请假管理员
     */
    const LEAVE_MANAGER = "leave_manager";
    /**
     * OA单据更改-人资专员
     */
    const DOCUMENT_CHANGE_HR_COMMISSIONER = "document_change_hr_commissioner";
    /**
     * OA单据更改-IT专员
     */
    const DOCUMENT_CHANGE_IT_COMMISSIONER = "document_change_it_commissioner";
    /**
     * 考勤管理员
     */
    const ATTENDANCE_MANAGER = "attendance_manager";
    /**
     * 工作流程管理员
     */
    const WORK_FLOW_MANAGER = "work_flow_manager";
    /**
     * 财务流程管理员
     */
    const FINANCIAL_FLOW_MANAGER = "financial_flow_manager";
    /**
     * 任务积分管理员
     */
    const TASK_SCORE_MANAGER = "task_score_manager";
    /**
     * 公告审批管理员
     */
    const IMPORTANT_ANNOUNCEMENT_AUDITOR = "important_announcement_auditor";
    /**
     * 押金扣款管理员
     */
    const DEPOSIT_DEBIT_MANAGER = "deposit_debit_manager";
    /**
     * 员工档案管理员
     */
    const EMPLOYEE_FILE_MANAGER = "employee_file_manager";
    /**
     * 护照工签管理员
     */
    const PASSPORT_WORK_PERMIT_MANAGER = "passport_work_permit_manager";
    /**
     * 存假管理员
     */
    const HOLIDAY_MANAGER = "holiday_manager";
    /**
     * 年假管理员
     */
    const ANNUAL_LEAVE_MANAGER = "annual_leave_manager";
    /**
     * 权限管理员
     */
    const PERMISSION_MANAGER = "permission_manager";
    /**
     * IT故障报修管理员
     */
    const IT_FAULT_REPAIR_MANAGER = "it_fault_repair_manager";
    /**
     * 行政故障报修管理员
     */
    const ADMINISTRATIVE_FAULT_REPAIR_MANAGER = "administrative_fault_repair_manager";

    /**
     * 公告通知管理员
     */
    const ANNOUNCEMENT_MANAGER = "announcement_manager";
    /**
     * 广播超级管理员
     */
    const NOTICE_SUPER_MANAGER = "notice_super_manager";
    /**
     * 广播通知管理员
     */
    const NOTICE_MANAGER = "notice_manager";
    /**
     * 公司福利管理员
     */
    const COMPANY_BENEFITS_MANAGER = "company_benefits_manager";
    /**
     * 班次管理员
     */
    const SHIFT_MANAGER = "shift_manager";
    /**
     * 重置密码管理员
     */
    const RESET_PASSWORD_MANAGER = "reset_password_manager";
    /**
     * 公司活动管理员
     */
    const COMPANY_ACTIVITIES_MANAGER = "company_activities_manager";
    /**
     * 文章管理员
     */
    const ARTICLE_MANAGER = "article_manager";
    /**
     * 机票药补管理员
     */
    const ALLOWANCE_MANAGER = "allowance_manager";
    /**
     * 人资数据修改员
     */
    const HR_DATA_MODIFY = 'hr_data_modify';

    /**
     * [数据报表] 考勤报表管理
     */
    const ATTENDANCE_REPORT_MANAGER = 'attendance_report_manager';
    /**
     * [数据报表] 员工报表管理
     */
    const USER_REPORT_MANAGER = 'user_report_manager';
    /**
     * [数据报表] 考勤流程管理
     */
    const ATTENDANCE_PROCESS_REPORT_MANAGER = 'attendance_process_report_manager';
    /**
     * [数据报表] 人资流程管理
     */
    const HR_PROCESS_REPORT_MANAGER = 'hr_process_report_manager';

    /**
     * 人资总监
     */
    const HR_DIRECTOR = "hr_director";
    /**
     * 财务总监
     */
    const FINANCIAL_DIRECTOR = "financial_director";
    /**
     * 采购总监
     */
    const PURCHASE_DIRECTOR = "purchase_director";
    /**
     * IT总监
     */
    const IT_DIRECTOR = "it_director";
    /**
     * 行政总监
     */
    const EXECUTIVE_DIRECTOR = "executive_director";
    /**
     * 推广总监
     */
    const PROMOTION_DIRECTOR = "promotion_director";
    /**
     * 推广副总监
     */
    const PROMOTION_DEPUTY_DIRECTOR = "promotion_deputy_director";
    /**
     * 总经理
     */
    const GENERAL_MANAGER = "general_manager";
    /**
     * 副总经理
     */
    const DEPUTY_GENERAL_MANAGER = "deputy_general_manager";
    /**
     * 董事长
     */
    const CHAIRMAN = "chairman";
    /**
     * 副董事长
     */
    const DEPUTY_CHAIRMAN = "deputy_chairman";

    /**
     * 文字滚动查看员
     */
    const SCROLL_VIEWER = "scroll_viewer";
    /**
     * 文字滚动管理员
     */
    const SCROLL_MANAGER = "scroll_manager";
    /**
     * 用户名称修改员
     */
    const NAME_CHANGE_MANAGER = "name_change_manager";
    /**
     * 推广开始日期修改员
     */
    const MARKETING_DATE_CHANGE_MANAGER = "marketing_date_change_manager";

    /**
     * 组织管理员
     */
    const DEPARTMENT_MANAGER = "department_manager";
    /**
     * 市场管理员
     */
    const MARKET_MANAGER = "market_manager";
    /**
     * 办公地点管理员
     */
    const OFFICE_ADDRESS_MANAGER = "office_address_manager";

    /**
     * 补打卡管理员
     */
    const MAKE_UP_MANAGER = "make_up_manager";

    /**
     * 国籍管理员
     */
    const COUNTRY_MANAGER = "country_manager";


    /**
     * Notes: 获取角色名字
     * User: admin
     * Date: 2020/7/28 12:46
     *
     * @return string[]
     */
    public static function getNames()
    {
        return [
            self::SUPER_ADMIN => '[系统] 超级管理员',
            self::BASE => "[系统] 基础角色",
            self::PROMOTER => "[系统] 推广员",
            self::LOGISTICS => "[系统] 后勤",
            self::LOCALS => "[系统] 菲籍",

            self::DEPARTMENT_HEAD => "[组织架构] 部门主管",
            self::DEPARTMENT_ASSISTANT => "[组织架构] 部门助理",

            self::FINANCIAL_ACCOUNTING => "[工作安排-审批范围] 财务会计",
            self::FINANCIAL_CASHIER => "[工作安排-审批范围] 财务出纳",
            self::WAREHOUSE_MANAGER => "[工作安排-审批范围] 仓库管理员",
            self::DORMITORY_MANAGER => "[工作安排-审批范围] 宿舍管理员",
            self::PASSPORT_MANAGER => "[工作安排-审批范围] 护照管理员",
//            self::SALARY_MANAGER => "[工作安排-审批范围] 调薪管理员",
            self::STOP_PAY_MANAGER => "[工作安排-审批范围] 停薪管理员",
            self::ORGANIZATION_TRANSFER_MANAGER => "[工作安排-审批范围] 组织调动管理员",
            self::EMPLOYEE_DEPARTURE_MANAGER => "[工作安排-审批范围] 员工离职管理员",
            self::LEAVE_MANAGER => "[工作安排-审批范围] 请假管理员",
            self::DOCUMENT_CHANGE_HR_COMMISSIONER => "[工作安排-审批范围] OA单据更改-人资专员",
            self::DOCUMENT_CHANGE_IT_COMMISSIONER => "[工作安排-审批范围] OA单据更改-IT专员",

            self::ATTENDANCE_MANAGER => "[工作安排-工作授权] 考勤管理员",
            self::WORK_FLOW_MANAGER => "[工作安排-工作授权] 工作流程管理员",
            self::FINANCIAL_FLOW_MANAGER => "[工作安排-工作授权] 财务流程管理员",
            self::DEPOSIT_DEBIT_MANAGER => "[工作安排-工作授权] 押金扣款管理员",
            self::EMPLOYEE_FILE_MANAGER => "[工作安排-工作授权] 员工档案管理员",
            self::PASSPORT_WORK_PERMIT_MANAGER => "[工作安排-工作授权] 护照工签管理员",
            self::HOLIDAY_MANAGER => "[工作安排-工作授权] 存假管理员",
            self::ANNUAL_LEAVE_MANAGER => "[工作安排-工作授权] 年假管理员",
            self::PERMISSION_MANAGER => "[工作安排-工作授权] 权限管理员",
            self::IT_FAULT_REPAIR_MANAGER => "[工作安排-工作授权] IT故障报修管理员",
            self::ANNOUNCEMENT_MANAGER => '[工作安排-工作授权] 公告通知管理员',
            self::NOTICE_SUPER_MANAGER => '[工作安排-工作授权] 广播通知超级管理员',
            self::NOTICE_MANAGER => '[工作安排-工作授权] 广播通知管理员',
            self::COMPANY_BENEFITS_MANAGER => '[工作安排-工作授权] 公司福利管理员',
            self::SHIFT_MANAGER => '[工作安排-工作授权] 班次管理员',
            self::RESET_PASSWORD_MANAGER => '[工作安排-工作授权] 重置密码管理员',
            self::COMPANY_ACTIVITIES_MANAGER => '[工作安排-工作授权] 公司活动管理员',
            self::ARTICLE_MANAGER => '[工作安排-工作授权] 文章管理员',
            self::ADMINISTRATIVE_FAULT_REPAIR_MANAGER => "[工作安排-工作授权] 行政故障报修管理员",
            self::ATTENDANCE_REPORT_MANAGER => '[工作安排-工作授权][数据报表] 考勤报表管理',
            self::USER_REPORT_MANAGER => '[工作安排-工作授权][数据报表] 员工报表管理',
            self::ATTENDANCE_PROCESS_REPORT_MANAGER => '[工作安排-工作授权][数据报表] 考勤流程管理',
            self::HR_PROCESS_REPORT_MANAGER => '[工作安排-工作授权][数据报表] 人资流程管理',

            self::HR_DIRECTOR => "[工作安排-职务安排] 人资总监",
            self::FINANCIAL_DIRECTOR => "[工作安排-职务安排] 财务总监",
            self::PURCHASE_DIRECTOR => "[工作安排-职务安排] 采购总监",
            self::IT_DIRECTOR => "[工作安排-职务安排] IT总监",
            self::EXECUTIVE_DIRECTOR => "[工作安排-职务安排] 行政总监",
            self::PROMOTION_DIRECTOR => "[工作安排-职务安排] 推广总监",
            self::PROMOTION_DEPUTY_DIRECTOR => "[工作安排-职务安排] 推广副总监",
            self::GENERAL_MANAGER => "[工作安排-职务安排] 总经理",
            self::DEPUTY_GENERAL_MANAGER => "[工作安排-职务安排] 副总经理",
            self::CHAIRMAN => "[工作安排-职务安排] 董事长",
            self::DEPUTY_CHAIRMAN => "[工作安排-职务安排] 副董事长",

            self::ALLOWANCE_MANAGER => '[公司福利] 机票药补管理员',
            self::TASK_SCORE_MANAGER => '[任务积分] 任务积分管理员',
            self::IMPORTANT_ANNOUNCEMENT_AUDITOR => '[公告] 公告审批管理员',

            self::SCROLL_VIEWER => '[财务管理] 文字滚动查看员',
            self::SCROLL_MANAGER => '[财务管理] 文字滚动管理员',

            self::NAME_CHANGE_MANAGER => '[员工数据] 用户名称修改员',
            self::HR_DATA_MODIFY => '[员工数据] 人资数据修改员',
            self::MARKETING_DATE_CHANGE_MANAGER => '[员工数据] 推广开始日期修改员',

            self::DEPARTMENT_MANAGER => '[组织架构] 组织管理员',
            self::MARKET_MANAGER => '[组织架构] 市场管理员',
            self::OFFICE_ADDRESS_MANAGER => '[组织架构] 办公地点管理',

            self::MAKE_UP_MANAGER => '[考勤管理] 补打卡管理',
            self::COUNTRY_MANAGER => '[国籍管理] 国籍管理员',
        ];
    }

    /**
     * Notes: 获取角色说明
     * User: admin
     * Date: 2020/7/28 12:47
     *
     * @return string[]
     */
    public static function getDescription()
    {
        return [
            self::SUPER_ADMIN => '系统超级管理员',
            self::BASE => "所有员工都的拥有的基础角色",
            self::PROMOTER => "推广部员工拥有的角色",
            self::LOGISTICS => "后勤部员工拥有的角色",
            self::LOCALS => "菲籍员工使用的角色",

            self::DEPARTMENT_HEAD => "部门职务主管拥有的角色",
            self::DEPARTMENT_ASSISTANT => "部门职务助理拥有的角色",

            self::FINANCIAL_ACCOUNTING => "关联工作安排-审批范围的财务会计",
            self::FINANCIAL_CASHIER => "关联工作安排-审批范围的财务出纳",
            self::WAREHOUSE_MANAGER => "关联工作安排-审批范围的仓库管理员",
            self::DORMITORY_MANAGER => "关联工作安排-审批范围的宿舍管理员",
            self::PASSPORT_MANAGER => "关联工作安排-审批范围的护照管理",
//            self::SALARY_MANAGER => "关联工作安排-审批范围的调薪管理员",
            self::STOP_PAY_MANAGER => "关联工作安排-审批范围的停薪管理员",
            self::ORGANIZATION_TRANSFER_MANAGER => "关联工作安排-审批范围的组织调动管理员",
            self::EMPLOYEE_DEPARTURE_MANAGER => "关联工作安排-审批范围的员工离职管理员",
            self::LEAVE_MANAGER => "关联工作安排-审批范围的请假管理员",
            self::DOCUMENT_CHANGE_HR_COMMISSIONER => "关联工作安排-审批范围的OA单据更改-人资专员",
            self::DOCUMENT_CHANGE_IT_COMMISSIONER => "关联工作安排-审批范围的OA单据更改-IT专员",

            self::ATTENDANCE_MANAGER => "关联工作安排-工作授权的考勤管理员",
            self::WORK_FLOW_MANAGER => "关联工作安排-工作授权的工作流程管理员",
            self::FINANCIAL_FLOW_MANAGER => "关联工作安排-工作授权的财务流程管理员",
            self::DEPOSIT_DEBIT_MANAGER => "关联工作安排-工作授权的押金扣款管理员",
            self::EMPLOYEE_FILE_MANAGER => "关联工作安排-工作授权的员工档案管理员",
            self::PASSPORT_WORK_PERMIT_MANAGER => "关联工作安排-工作授权的护照工签管理员",
            self::HOLIDAY_MANAGER => "关联工作安排-工作授权的存假管理员",
            self::ANNUAL_LEAVE_MANAGER => "关联工作安排-工作授权的年假管理员",
            self::PERMISSION_MANAGER => "关联工作安排-工作授权的权限管理员",
            self::IT_FAULT_REPAIR_MANAGER => "关联工作安排-工作授权的IT故障报修管理员",
            self::ANNOUNCEMENT_MANAGER => '关联工作安排-工作授权的公告通知管理员',
            self::NOTICE_SUPER_MANAGER => '关联工作安排-工作授权的广播通知超级管理员',
            self::NOTICE_MANAGER => '关联工作安排-工作授权的广播通知管理员',
            self::COMPANY_BENEFITS_MANAGER => '关联工作安排-工作授权的公司福利管理员',
            self::SHIFT_MANAGER => '关联工作安排-工作授权的班次管理员',
            self::RESET_PASSWORD_MANAGER => '关联工作安排-工作授权的重置密码管理员',
            self::COMPANY_ACTIVITIES_MANAGER => '关联工作安排-工作授权的公司活动管理员',
            self::ARTICLE_MANAGER => '关联工作安排-工作授权的文章管理员',
            self::ADMINISTRATIVE_FAULT_REPAIR_MANAGER => "关联工作安排-工作授权的行政故障报修管理员",
            self::ATTENDANCE_REPORT_MANAGER => '关联工作安排-工作授权 [数据报表] 考勤报表管理',
            self::USER_REPORT_MANAGER => '关联工作安排-工作授权 [数据报表] 员工报表管理',
            self::ATTENDANCE_PROCESS_REPORT_MANAGER => '关联工作安排-工作授权 [数据报表] 考勤流程管理',
            self::HR_PROCESS_REPORT_MANAGER => '关联工作安排-工作授权 [数据报表] 人资流程管理',

            self::HR_DIRECTOR => "关联工作安排-职务安排的人资总监",
            self::FINANCIAL_DIRECTOR => "关联工作安排-职务安排的财务总监",
            self::PURCHASE_DIRECTOR => "关联工作安排-职务安排的采购总监",
            self::IT_DIRECTOR => "关联工作安排-职务安排的IT总监",
            self::EXECUTIVE_DIRECTOR => "关联工作安排-职务安排的行政总监",
            self::PROMOTION_DIRECTOR => "关联工作安排-职务安排的推广总监",
            self::PROMOTION_DEPUTY_DIRECTOR => "关联工作安排-职务安排的推广副总监",
            self::GENERAL_MANAGER => "关联工作安排-职务安排的总经理",
            self::DEPUTY_GENERAL_MANAGER => "关联工作安排-职务安排的副总经理角色",
            self::CHAIRMAN => "关联工作安排-职务安排的董事长",
            self::DEPUTY_CHAIRMAN => "关联工作安排-职务安排的副董事长",

            self::ALLOWANCE_MANAGER => '机票药补管理员',
            self::TASK_SCORE_MANAGER => '任务积分管理员',
            self::IMPORTANT_ANNOUNCEMENT_AUDITOR => '公告审批管理员',

            self::SCROLL_VIEWER => '文字滚动查看员',
            self::SCROLL_MANAGER => '文字滚动管理员',

            self::HR_DATA_MODIFY => '人资数据修改员',
            self::NAME_CHANGE_MANAGER => '不限制次数的修改员工的艺名',
            self::MARKETING_DATE_CHANGE_MANAGER => '更改任意员工的任务开始时间，更改后的日期需要遵守一定规则',

            self::DEPARTMENT_MANAGER => '新增、删除组织，设置组织的领导和助理',
            self::MARKET_MANAGER => '新增、编辑、停用市场',
            self::OFFICE_ADDRESS_MANAGER => '新增、编辑、停用办公地点',

            self::MAKE_UP_MANAGER => '可以帮助员工补打卡',
            self::COUNTRY_MANAGER => '可以操作国籍管理模块',
        ];
    }

    /**
     * Notes: 获取创建用户需要选择的角色
     * User: admin
     * Date: 2020/7/30 14:15
     *
     * @return string[]
     */
    public static function getUserRoleSelect()
    {
        return [
            self::PROMOTER => "推广",
            self::LOGISTICS => "后勤",
            self::LOCALS => "菲籍",
        ];
    }

    /**
     * Notes: 部门职务的权限
     * User: admin
     * Date: 2020/8/1 17:36
     *
     * @return string[]
     */
    public static function departmentPost() {
        return [
            self::DEPARTMENT_HEAD,
            self::DEPARTMENT_ASSISTANT,
        ];
    }

    /**
     * Notes: 大部门领导
     * User: admin
     * Date: 2020/9/28 20:28
     *
     * @return string[]
     */
    public static function bigDepartmentHead()
    {
        return [
            self::SUPER_ADMIN,
            self::HR_DIRECTOR,
            self::FINANCIAL_DIRECTOR,
            self::PURCHASE_DIRECTOR,
            self::IT_DIRECTOR,
            self::EXECUTIVE_DIRECTOR,
            self::PROMOTION_DIRECTOR
        ];
    }
}
