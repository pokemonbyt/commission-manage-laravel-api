<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/4/9 14:11
 */

namespace App\Modules\UEditor\Conf;

/**
 * Notes: UEditor上传的Action Key
 *
 * Class UEditorUploadAction
 * @package App\Modules\UEditor\Conf
 */
class UEditorUploadAction
{
    /**
     * 获取配置
     */
    const CONFIG = 'config';
    /**
     * 上传图片
     */
    const IMAGE = 'image';
    /**
     * 上传涂鸦
     */
    const SCRAWL = 'scrawl';
    /**
     * 上传视频
     */
    const VIDEO = 'video';
    /**
     * 附件
     */
    const FILE = 'file';
}
