<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/11 15:54
 */

namespace App\Modules\Common\Entity;

use App\Models\User;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Resources\Conf\ResourcesConfig;

/**
 * Notes: 小工具
 *
 * Class Utils
 * @package App\Modules\Common\Entity
 */
class Utils
{
    /**
     * Notes: 判断上传的bool值是否有效
     * User: admin
     * Date: 2020/1/11 15:58
     *
     * @param $value
     * @return bool
     */
    public function boolExist($value)
    {
        return $value !== null && SwitchEnum::isExist((int)$value);
    }

    /**
     * Notes: 可以根据用户工号或者名字查找
     * User: admin
     * Date: 2020/10/7 16:37
     *
     * @param $usernameOrName
     * @return User|User[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findUser($usernameOrName)
    {
        $user = User::where('username', $usernameOrName)->first();
        if ($user) {
            return $user;
        }

        $user = User::where('name', $usernameOrName)->first();
        if ($user) {
            return $user;
        }

        return null;
    }

    /**
     * Notes: 分页再封装，方便转换数据后使用分页结构
     * User: admin
     * Date: 2020/2/11 20:34
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginate
     * @param $data
     * @return array
     */
    public function paginate($paginate, $data)
    {
        $data = [
            'current_page' => $paginate->currentPage(),
            'data' => $data,
            'first_page_url' => $paginate->url(1),
            'from' => $paginate->firstItem(),
            'last_page' => $paginate->lastPage(),
            'last_page_url' => $paginate->url($paginate->lastPage()),
            'next_page_url' => $paginate->nextPageUrl(),
            'path' => $paginate->path(),
            'per_page' => $paginate->perPage(),
            'prev_page_url' => $paginate->previousPageUrl(),
            'to' => $paginate->lastItem(),
            'total' => $paginate->total(),
        ];

        return $data;
    }

    /**
     * Notes: 替换掉字符串空格
     * User: admin
     * Date: 2020/2/26 16:35
     *
     * @param $str
     * @return string|string[]
     */
    public function replaceSpace($str)
    {
        return str_replace(' ', '', $str);
    }

    /**
     * Notes: 获取今日日期
     * User: admin
     * Date: 2020/2/22 19:03
     *
     * @return false|string
     */
    public function today()
    {
        return date('Y-m-d');
    }

    /**
     * Notes: 获取今日是几号
     * User: admin
     * Date: 2020/3/5 20:10
     *
     * @return int
     */
    public function day()
    {
        return (int)date('d');
    }

    /**
     * Notes: 获取今日年月
     * User: admin
     * Date: 2020/3/5 13:07
     *
     * @return false|string
     */
    public function currentMonth()
    {
        return date('Y-m');
    }

    /**
     * Notes: 获取上一个月
     * User: admin
     * Date: 2020/3/14 14:22
     *
     * @return false|string
     */
    public function lastMonth()
    {
        return $this->monthDistance(1, '-');
    }

    /**
     * Notes: 获取下一个月
     * User: admin
     * Date: 2020/3/5 16:58
     *
     * @return false|string
     */
    public function nextMonth()
    {
        //获取这个月1号
        $firstDayOfCurrentMonth = utils()->currentMonth().'-01';
        return $this->monthDistance(1, '+', $firstDayOfCurrentMonth);
    }

    /**
     * Notes: 计算和当前月距离的月份
     * User: admin
     * Date: 2020/3/7 10:50
     *
     * @param $distance
     * @param string $operation
     * @param null $date
     * @param bool $isDef
     * @return false|string
     */
    public function monthDistance($distance, $operation = '+', $date = null, $isDef = true)
    {
        if ($date) {
            $timestamp = $this->dateToTime($date);
        } else {
            $timestamp = time();
        }

        if ($isDef) {
            $timestamp = $this->dateToTime(date("Y-m", $timestamp) . "-01");
        }

        return date('Y-m', strtotime("{$operation}{$distance} month", $timestamp));
    }

    /**
     * Notes: 获取当月最大天数
     * User: admin
     * Date: 2020/3/6 16:52
     *
     * @param null $month
     * @return false|string
     */
    public function monthMaxDay($month = null)
    {
        //获取自定月份最大天数
        if ($month) {
          return date('t', utils()->dateToTime($month));
        }

        return date('t');
    }

    /**
     * Notes: 获取拆分的年月
     * User: admin
     * Date: 2020/3/7 10:31
     *
     * @param $date
     * @return array
     */
    public function getYearMonth($date)
    {
        $time = utils()->dateToTime($date);
        $year = date('Y', $time);
        $month = date('m', $time);

        return [$year, $month];
    }

    /**
     * Notes: 获取拆分的年月日
     * User: admin
     * Date: 2020/3/7 10:31
     *
     * @param $date
     * @return array
     */
    public function getYearMonthDay($date)
    {
        $time = utils()->dateToTime($date);
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);

        return [$year, $month, $day];
    }

    /**
     * Notes: 时间戳转成时间
     * User: admin
     * Date: 2020/2/25 14:38
     *
     * @param $timestamp
     * @return false|string
     */
    public function timeToDate($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * Notes: 时间转成时间戳
     * User: admin
     * Date: 2020/2/25 16:46
     *
     * @param $date
     * @return false|int
     */
    public function dateToTime($date)
    {
        return strtotime($date);
    }

    /**
     * Notes: 2个日期求差
     * User: admin
     * Date: 2020/3/6 14:59
     *
     * @param $start
     * @param $end
     * @param bool $toDay
     * @param bool $rounding
     * @return false|int
     */
    public function diffDate($start, $end, $toDay = false, $rounding = false)
    {
        $time = $this->dateToTime($start) - $this->dateToTime($end);

        //是否转换成天数
        if ($toDay) {
            $day = $time / 86400;

            //是否取整天数，向上取整
            if ($rounding) {
                return ceil($day);
            }

            return $day;
        }

        return $time;
    }

    /**
     * Notes: 2个日期相差多少个月
     * User: admin
     * Date: 2020/10/20 17:14
     *
     * @param $startDate
     * @param $endDate
     * @param bool $isAbs
     * @return false|float|int|string
     */
    public function diffMonth($startDate, $endDate, $isAbs = true)
    {
        $time1 = utils()->dateToTime($startDate);
        $time2 = utils()->dateToTime($endDate);

        $year1  = date("Y",$time1);   // 时间1的年份
        $month1 = date("m",$time1);   // 时间1的月份
        $year2  = date("Y",$time2);   // 时间2的年份
        $month2 = date("m",$time2);   // 时间2的月份

        $result = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
        if ($isAbs) {
            return abs($result);

        } else {
            return $result;
        }
    }

    /**
     * Notes: 计算和当前日期距离的日期
     * User: admin
     * Date: 2020/3/7 10:57
     *
     * @param $distance
     * @param string $operation
     * @param null $date
     * @return false|string
     */
    public function dayDistance($distance, $operation = '+', $date = null)
    {
        if ($date) {
            $timestamp = $this->dateToTime($date);
        } else {
            $timestamp = time();
        }

        return date('Y-m-d', strtotime("{$operation}{$distance} day", $timestamp));
    }

    /**
     * Notes: 计算和当前时间距离的时间
     * User: admin
     * Date: 2020/3/10 11:28
     *
     * @param $second
     * @param string $operation
     * @param null $date
     * @return false|string
     */
    public function timeDistance($second, $operation = '+', $date = null)
    {
        if ($date) {
            $timestamp = $this->dateToTime($date);
        } else {
            $timestamp = time();
        }

        if ($operation == '+') {
            return $this->timeToDate($timestamp + $second);

        } else if ($operation == '-') {
            return $this->timeToDate($timestamp - $second);

        } else {
            return $this->timeToDate($timestamp);
        }
    }

    /**
     * Notes: 月最后一天最后1秒
     * User: admin
     * Date: 2020/7/22 16:29
     *
     * @return false|string
     */
    public function lastDayOfMonth()
    {
        return date('Y-m-t 23:59:59');
    }

    /**
     * Notes: 月最后一天
     * User: admin
     * Date: 2020/10/18 15:18
     *
     * @param $date
     * @return false|string
     */
    public function lastOfMonth($date = null)
    {
        if ($date) {
            return date("Y-m-t", $this->dateToTime($date));
        }

        return date("Y-m-t");
    }

    /**
     * Notes: 获取一个列表的连续日期
     * User: admin
     * Date: 2020/3/7 16:20
     *
     * @param array $dates
     * @return array
     */
    public function consecutiveDate($dates)
    {
        $result = [];

        sort($dates);
        for ($i = 1; $i < count($dates); $i++) {
            $diff = $this->diffDate($dates[$i], $dates[0]);

            if ($diff == ($i * 24 * 60 * 60)) {
                if ($i == 1) {
                    $result[] = $dates[0];
                }

                $result[] = $dates[$i];
            }
        }

        return $result;
    }

    /**
     * Notes: 计算2个日期间隔的所有日期
     * User: admin
     * Date: 2020/8/18 19:17
     *
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function intervalDate($startDate, $endDate)
    {
        $dates = [];

        while ($startDate <= $endDate) {
            $dates[] = $startDate;

            $startDate = $this->dayDistance(1, "+", $startDate);
        }

        return $dates;
    }

    /**
     * Notes: 查询字符串是否存在
     * User: admin
     * Date: 2020/4/3 12:17
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public function isStrExist($haystack, $needle)
    {
        return !(strpos($haystack, $needle) === false);
    }

    /**
     * Notes: 导入excel
     * User: admin
     * Date: 2020/4/3 14:54
     *
     * @param $import
     * @param null $path
     * @return bool
     */
    public function importExcel($import, $path = null)
    {
        //指定路径
        if ($path) {
            \Excel::import($import, $path);

        //上传
        } else {
            $path = \Storage::put(ResourcesConfig::PATH, request()->file('file'));
            \Excel::import($import, $path);
            \Storage::delete($path);
        }

        return true;
    }

    /**
     * Notes: 转换excel时间格式
     * User: admin
     * Date: 2020/7/22 14:21
     *
     * @param $time
     * @param bool $isTimestamp
     * @return false|int|string
     */
    public function parseExcelTime($time, $isTimestamp = false)
    {
        $n = intval(($time - 25569) * 3600 * 24);

        if ($isTimestamp) {
            //时间戳需要用gmdate处理，不然时区对应不上
            return $n;

        } else {
            return gmdate('Y-m-d', $n);
        }
    }

    /**
     * Notes: 检测验证码是否正确
     * User: admin
     * Date: 2020/4/10 15:40
     *
     * @param $key
     * @param $captcha
     * @return bool
     */
    public function checkCaptcha($key, $captcha)
    {
        return captcha_api_check($captcha, $key);
    }

    /**
     * Notes: 解析上传的base64图片
     * User: admin
     * Date: 2020/7/20 14:56
     *
     * str -> 表示返回base64的字符串
     * decode -> 返回base64，可以用于保存成图片
     *
     * @param $base64
     * @return array
     */
    public function parseBase64($base64)
    {
        preg_match('/^(data:\s*image\/(\w+);base64,)/',$base64,$res);

        $str = str_replace($res[1],'', $base64);
        $decode = base64_decode($str);

        return ['str' => $str, 'file' => $decode, 'res' => $res];
    }

    /**
     * Notes: 计算Base64大小
     * User: admin
     * Date: 2020/7/20 15:25
     *
     * @param $base64Str
     * @return float|int
     */
    public function base64Size($base64Str)
    {
        $imgLen = strlen($base64Str);

        return $imgLen - ($imgLen / 8) * 2;
    }

    /**
     * Notes: 验证用户的二级密码
     * User: admin
     * Date: 2020/9/7 15:49
     *
     * @param $value
     * @param $baseValue
     * @return bool
     */
    public function checkPrivacyPassword($value, $baseValue)
    {
        return $value === decrypt($baseValue);
    }

    /**
     * Notes: 获取真实IP
     * User: admin
     * Date: 2020/9/13 20:23
     *
     * @return mixed
     */
    public function getRealIp()
    {
        try {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        } catch (\Throwable $e) {
             return request()->getClientIp();
        }
    }
}
