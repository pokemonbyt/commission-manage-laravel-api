<?php


namespace App\Modules\User\Service;

use App\Models\AgencyDetails;
use App\Models\AgencyManager;
use App\Models\User;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Permission\Service\RoleService;
use App\Modules\User\Entity\UserVO;
use App\Modules\User\Enum\UserTypesEnum;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Resource\UserResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Notes: 用户模块业务
 *
 * Class UserService
 * @package App\Modules\User\Service
 */
class UserService
{
    private $userRepository;
    private $roleService;

    public function __construct(UserRepository $userRepository, RoleService $roleService)
    {
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
    }

    /**
     * Notes: 创建基本的账户信息
     * User: admin
     * Date: 2021/04/29 17:03
     *
     * @param UserVO $user
     * @return bool|int
     */
    public function createAccount(UserVO $user)
    {
        //重复工号
        if ($this->userRepository->existsUser('username', $user->getUsername())) {
            return UserErrorCode::DUPLICATE_USERNAME;
        }
        // if ($user->getTypes() >= my_types()) {
        //     return UserErrorCode::CANNOT_CREATE_HIGHER_USER;
        // }
        //重复艺名
        if ($this->userRepository->existsUser('name', $user->getName())) {
            return UserErrorCode::DUPLICATE_NAME;
        }
        try {
            \DB::beginTransaction();
            //创建用户账号信息
            $this->userRepository->create($user);
            \DB::commit();
            return true;

        } catch (\Throwable $e) {
            \DB::rollBack();
            \Log::error($e);
            return UserErrorCode::USER_CREATE_EXCEPTION;
        }
    }

    /**
     * Notes: 获取登录用户信息
     * User: admin
     * Date: 2021/04/30 16:02
     *
     * @return array
     */
    public function info()
    {
        $user = $this->userRepository->findById(my_user_id());
        return [
            "username" => $user->username,
            "name" => $user->name,
            "type" => $user->types,
        ];
    }


    /**
     * Notes: 查找所有用户
     * User: admin
     * Date: 2021/04/29 17:10
     *
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return $this->userRepository->all();
    }

    /**
     * Notes: 根据工号或者艺名模糊查找用户
     * User: admin
     * Date: 2021/04/29 17:10
     *
     * @param $value
     * @return LengthAwarePaginator
     */
    public function search($value)
    {
        return $this->userRepository->search($value);
    }

    /**
     * Notes: 根据工号或者艺名检测用户是否存在
     * User: admin
     * Date: 2021/04/29 17:11
     *
     * @param $username
     * @param $name
     * @return bool
     */
    public function checkUser($username, $name)
    {
        return $this->userRepository->checkUser($username, $name);
    }

    /**
     * Notes: 删除用户
     * User: admin
     * Date: 2021/05/03 17:42
     *
     * @param $username
     * @return bool
     */
    public function delete($username)
    {
        if ($username == 10000) {
            return UserErrorCode::CANNOT_DELETE_SUPER_ADMIN;
        }
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            $user->is_active = SwitchEnum::NO;

            //删除后修改工号艺名
            $i = 0;
            $user->username = $user->username . '删除' . $i;
            $user->name = $user->name . '删除' . $i;
            $plus = 1;
            while ($this->userRepository->existsUser('username', $user->username) || $this->userRepository->existsUser('name', $user->name)) {
                $user->username = substr($user->username, 0, -1) . $plus;
                $user->name = substr($user->name, 0, -1) . $plus;
                $plus += 1;
            }
            $user->save();
            return true;
        }
        return UserErrorCode::USER_DOES_NOT_EXIST;
    }

    public function createAgencyDetails($request)
    {
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        if ($this->checkPid($request->agency)) {
            return UserErrorCode::NOT_PERMISSION_FOR_THIS_USER;
        }
        $agencyDetails = new AgencyDetails();
        $agencyDetails->agency = $request->agency;
        $agencyDetails->player_username = $request->player_username;
        $agencyDetails->full_name = $request->full_name;
        $agencyDetails->phone = $request->phone;
        if ($request->logout_days)
            $agencyDetails->logout_days = $request->logout_days;
        if ($request->month) {
            $agencyDetails->month = $request->month;
        } else {
            $agencyDetails->month = utils()->currentMonth();
        }

        $agencyDetails->total_money = $request->total_money;
        $agencyDetails->save();
        return true;
    }

    public function updateAgencyDetails($request)
    {
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        if ($this->checkPid($request->agency)) {
            return UserErrorCode::NOT_PERMISSION_FOR_THIS_USER;
        }
        $agencyDetails = AgencyDetails::whereId($request->id)->first();
        $agencyDetails->agency = $request->agency;
        $agencyDetails->player_username = $request->player_username;
        $agencyDetails->full_name = $request->full_name;
        $agencyDetails->phone = $request->phone;
        $agencyDetails->month = $request->month;
        $agencyDetails->total_money = $request->total_money;
        $agencyDetails->logout_days = $request->logout_days;
        $agencyDetails->save();
        return true;
    }

    public function getAgencyDetails()
    {
        $myRef = User::select('username')->whereIn('id', $this->userRepository->getMeAndChild(my_user_id()))->get()->pluck('username')->toArray();

        $agency = request()['agency'];
        $month = request()['month'];
        $usname = request()['player_username'];
        $phone = request()['phone'];
        $fullName = request()['full_name'];
        $logOutDays = request()['logout_days'];
        $totalMoney = request()['total_money'];
        $select = AgencyDetails::whereIn('agency', $myRef);
        if ($agency) {
            $select->where('agency', $agency);
        }
        if ($month) {
            $select->where('month', $month);
        }
        if ($usname) {
            $select->where('player_username', $usname);
        }
        if ($fullName) {
            $select->where('full_name', 'like', '%'.$fullName.'%');
        }
        if ($logOutDays) {
            $select->where('logout_days', $logOutDays);
        }
        if ($totalMoney) {
            $select->where('total_money', $totalMoney);
        }
        if ($phone) {
            $select->where('phone', $phone);
        }
        return $select->paginate(request()['limit']);
    }


    public function checkPid($username)
    {
        $pid = User::whereUsername($username)->first()->pid;
        if ($pid == my_user_id()) {
            return false;
        }
        return true;
    }

    public function deleteAgencyDetails($id)
    {
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        $item = AgencyDetails::whereId($id)->first();
        if ($this->checkPid($item->agency)) {
            return UserErrorCode::NOT_PERMISSION_FOR_THIS_USER;
        }
        $item->delete();
        return true;
    }

    public function createAgencyManager($request)
    {
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        if ($this->checkPid($request->agency)) {
            return UserErrorCode::NOT_PERMISSION_FOR_THIS_USER;
        }
        if (AgencyManager::whereAgency($request->agency)->first()) {
            return UserErrorCode::AGENCY_DUPLICATE;
        }

        $agencyManager = new AgencyManager();
        $agencyManager->agency = $request->agency;
        $agencyManager->level1 = $request->level1;
        $agencyManager->level2 = $request->level2;
        $agencyManager->level3 = $request->level3;
        $agencyManager->level4 = $request->level4;
        $agencyManager->save();
        return true;
    }

    public function updateAgencyManager($request)
    {
        $agencyManager = AgencyManager::whereId($request->id)->first();
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        if ($this->checkPid($agencyManager->agency)) {
            return UserErrorCode::NOT_PERMISSION_FOR_THIS_USER;
        }

        $agencyManager->level1 = $request->level1;
        $agencyManager->level2 = $request->level2;
        $agencyManager->level3 = $request->level3;
        $agencyManager->level4 = $request->level4;
        $agencyManager->save();
        return true;
    }

    public function deleteAgencyManager($id)
    {
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        $item = AgencyManager::whereId($id)->first();
        if ($this->checkPid($item->agency)) {
            return UserErrorCode::NOT_PERMISSION_FOR_THIS_USER;
        }
        $item->delete();
        return true;
    }

    public function getAgencyManager()
    {
        $myRef = User::select('username')->whereIn('id', $this->userRepository->getMeAndChild(my_user_id()))->get()->pluck('username')->toArray();
        $agency = request()['agency'];
        $select = AgencyManager::whereIn('agency', $myRef);
        if ($agency) {
            $select->where('agency', $agency);
        }
        return $select->paginate(request()['limit']);
    }

    public function getTotalWinLose()
    {
        $usname = request()['player_username'];
        $phone = request()['phone'];
        $month = request()['month'];
        $fullName = request()['full_name'];
        $logOutDays = request()['logout_days'];
        $totalMoney = request()['total_money'];
        $myRef = User::select('username')->whereIn('id', $this->userRepository->getMeAndChild(my_user_id()))->get()->pluck('username')->toArray();
        $agency = request()['agency'];
        $select = AgencyDetails::selectRaw('sum(total_money) as sum')->whereIn('agency', $myRef);
        if ($agency) {
            $select->where('agency', $agency);
        }
        if ($month) {
            $select->where('month', $month);
        }
        if ($usname) {
            $select->where('player_username', $usname);
        }
        if ($phone) {
            $select->where('phone', $phone);
        }
        if ($fullName) {
            $select->where('full_name', 'like', '%'.$fullName.'%');
        }
        if ($logOutDays) {
            $select->where('logout_days', $logOutDays);
        }
        if ($totalMoney) {
            $select->where('total_money', $totalMoney);
        }
        return $select->first()->sum;
    }

    public function getTotalCommission()
    {
        $month = request()['month'];
        $agency = request()['agency'];
        $usname = request()['player_username'];
        $phone = request()['phone'];
        $fullName = request()['full_name'];
        $logOutDays = request()['logout_days'];
        $totalMoney = request()['total_money'];
        if ($agency) {
            $select = AgencyDetails::selectRaw('sum(total_money) as sum')->where('agency', $agency);

            if ($month) {
                $select->where('month', $month);
            }

            if ($usname) {
                $select->where('player_username', $usname);
            }

            if ($phone) {
                $select->where('phone', $phone);
            }

            if ($fullName) {
                $select->where('full_name', 'like', '%'.$fullName.'%');
            }
            if ($logOutDays) {
                $select->where('logout_days', $logOutDays);
            }
            if ($totalMoney) {
                $select->where('total_money', $totalMoney);
            }
            $money = $select->first()->sum;
            $percent = $this->getPercentByMoney($agency, $money);
            return $money * $percent / 100;
        } else {
            $myRef = User::select('username')->whereIn('id', $this->userRepository->getMeAndChild(my_user_id()))->get()->pluck('username')->toArray();
            $total = 0;
            foreach ($myRef as $agency) {
                $select = AgencyDetails::selectRaw('sum(total_money) as sum')->where('agency', $agency);

                if ($month) {
                    $select->where('month', $month);
                }
                if ($usname) {
                    $select->where('player_username', $usname);
                }

                if ($phone) {
                    $select->where('phone', $phone);
                }

                if ($fullName) {
                    $select->where('full_name', 'like', '%'.$fullName.'%');
                }
                if ($logOutDays) {
                    $select->where('logout_days', $logOutDays);
                }
                if ($totalMoney) {
                    $select->where('total_money', $totalMoney);
                }
                $money = $select->first()->sum;
                $percent = $this->getPercentByMoney($agency, $money);
                $total += ($money * $percent / 100);
            }
            return $total;
        }

    }

    public function getPercentByMoney($agency, $money)
    {
        $point1 = -100000000;
        $point2 = -500000000;
        $point3 = -1000000000;
        $config = AgencyManager::whereAgency($agency)->first();
        if ($config) {
            if ($money < $point3) {
                return -$config->level4;
            } else if ($money < $point2 && $money >= $point3) {
                return -$config->level3;
            } else if ($money < $point1 && $money >= $point2) {
                return -$config->level2;
            } else if ($money < 0 && $money >= $point1) {
                return -$config->level1;
            } else return 0;
        }
        return 0;
    }

    public function importAgencyDetails()
    {
        if (my_types() != UserTypesEnum::MKT) {
            return UserErrorCode::USER_CANNOT_CREATE_DATA;
        }
        utils()->importExcel(new AgencyDetailsImport());
        return true;
    }
}
