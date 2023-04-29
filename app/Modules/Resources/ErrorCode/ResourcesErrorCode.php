<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/3 14:47
 */

namespace App\Modules\Resources\ErrorCode;


class ResourcesErrorCode
{
    //文件读取失败
    const FILE_READ_FAILED = -1000801;
    //文件不存在
    const FILE_DOES_NOT_EXIST = -1000802;
    //文件数量超出限制
    const NUMBER_OF_FILES_EXCEEDED = -1000803;
    //文件上传异常
    const FILE_UPLOAD_EXCEPTION = -1000804;
    //用户头像上传异常
    const USER_AVATAR_UPLOAD_EXCEPTION = -1000805;
    //用户头像只可以上传一次
    const USER_AVATAR_ONLY_UPLOADED_ONCE = -1000806;
    //文件拥有关联
    const FILE_HAVE_LINK = -1000807;
    //截图解析错误
    const SCREENSHOT_PARSING_ERROR = -1000808;

    private static $text = [
        self::FILE_READ_FAILED => 'file read failed.',
        self::FILE_DOES_NOT_EXIST => 'file does not exist.',
        self::NUMBER_OF_FILES_EXCEEDED => 'number of files exceeded.',
        self::FILE_UPLOAD_EXCEPTION => 'file upload exception.',
        self::USER_AVATAR_UPLOAD_EXCEPTION => 'user avatar upload exception.',
        self::USER_AVATAR_ONLY_UPLOADED_ONCE => 'user avatar only uploaded once.',
        self::FILE_HAVE_LINK => 'file have link.',
        self::SCREENSHOT_PARSING_ERROR => 'screenshot parsing error.'
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
