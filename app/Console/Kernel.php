<?php

namespace App\Console;

use App\Console\Task\AdjustAnnualLeaveAfterPositionChange;
use App\Console\Task\AllowanceDistributeTask;
use App\Console\Task\AnnualLeaveAndAllowanceDelayTask;
use App\Console\Task\AttendanceConfirmResetTask;
use App\Console\Task\AttendanceTypeCopyTask;
use App\Console\Task\ClearPopupStatusAfterUserQuitJob;
use App\Console\Task\DormitoryFeesInitTask;
use App\Console\Task\FeesConfirmResetTask;
use App\Console\Task\HolidayLeaveSettlementTask;
use App\Console\Task\LogVisitorCleanTask;
use App\Console\Task\ProcessCorrectTask;
use App\Console\Task\ProcessDepPosWageAdjustmentTask;
use App\Console\Task\ProcessLeaveWithoutPayTimeExecute;
use App\Console\Task\ProcessTransferDepartmentTask;
use App\Console\Task\ResetIncrementId;
use App\Console\Task\ScheduleRuleCopyTask;
use App\Console\Task\TaskScoreDistributeTask;
use App\Console\Task\UserConfigCopyValueTask;
use App\Console\Task\UserConfigBackupUserDataTask;
use App\Console\Task\WageDeleteTask;
use App\Console\Task\WorkStatusUpdateTask;
use App\Console\Task\AnnualLeaveDistributeTask;
use App\Console\Task\DuplicateYesterdayScroll;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
