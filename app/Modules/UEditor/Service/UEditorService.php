<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/4/9 12:27
 */

namespace App\Modules\UEditor\Service;

use App\Modules\Resources\Conf\ResourcesConfig;
use App\Modules\Resources\Entity\ResourcesVO;
use App\Modules\UEditor\Conf\UEditorUploadAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Notes: UEditor富文本编辑器需要API
 *
 * Class UEditorService
 * @package App\Modules\UEditor\Service
 */
class UEditorService
{
    /**
     * Notes: 获取UE配置
     * User: admin
     * Date: 2020/4/9 12:34
     *
     * @return array
     */
    public function config()
    {
        return [
            //图片
            "imageActionName" => UEditorUploadAction::IMAGE,
            "imageFieldName" => "file",
            "imageMaxSize" => 51200000,
            "imageAllowFiles" => [
                ".png", ".jpg", ".jpeg", ".gif", ".bmp"
            ],
            "imageCompressEnable" => true,
            "imageCompressBorder" => 1600,
            "imageUrlPrefix" => '',
            //涂鸦
            "scrawlActionName" => UEditorUploadAction::SCRAWL,
            "scrawlFieldName" => "file",
            "scrawlMaxSize" => 51200000,
            "scrawlUrlPrefix" => '',
            //视频
            "videoActionName" => UEditorUploadAction::VIDEO,
            'videoFieldName' => "file",
            "videoMaxSize" => 51200000,
            "videoAllowFiles" => [
                ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"
            ],
            "videoUrlPrefix" => '',
            //附件
            "fileActionName" => UEditorUploadAction::FILE,
            "fileFieldName" => "file",
            "fileMaxSize" => 51200000,
            "fileAllowFiles" => [
                ".png", ".jpg", ".jpeg", ".gif", ".bmp",
                ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
                ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
            ],
        ];
    }

    /**
     * Notes: 上传图片或者视频
     * User: admin
     * Date: 2020/4/9 15:09
     *
     * @return array
     */
    public function uploadFile()
    {
        $file = request()->file('file');
        if ($file) {
            $name = $file->getClientOriginalName();
            $url = \Storage::put(ResourcesConfig::PATH . '/ueditor', $file);
            $md5 = md5_file('/tmp/' . $file->getFilename());
            //保存数据库
            $this->saveRes($name, $url, $file->getClientOriginalExtension(), $file->getClientMimeType(), $file->getSize(), $md5);

            return $this->success($url, $name);

        } else {
            return $this->failed();
        }
    }

    /**
     * Notes: 上传涂鸦
     * User: admin
     * Date: 2020/4/9 15:18
     *
     * @return array
     */
    public function uploadScrawl()
    {
        $base64 = utils()->parseBase64(request()['file']);

        $file = $base64['file'];
        if ($file) {
            $mineType = $base64['res'][1];
            $extension = $base64['res'][2];
            $name = \Str::random(40) . ".{$extension}";
            $url = ResourcesConfig::PATH . "/ueditor/$name";

            if(\Storage::put($url, $file)) {
                //保存数据库
                $this->saveRes($name, $url, $extension, $mineType, utils()->base64Size($base64['str']), md5($base64['str']));

                return $this->success($url, $name);
            }
        }

        return $this->failed();
    }

    /**
     * Notes: 添加资源的数据库记录
     * User: admin
     * Date: 2020/7/20 15:14
     *
     * @param $name
     * @param $url
     * @param $extension
     * @param $mineType
     * @param $size
     * @param $md5
     */
    private function saveRes($name, $url, $extension, $mineType, $size, $md5)
    {
        try {
            \DB::beginTransaction();

            $vo = new ResourcesVO();

            $vo->setModelType("ueditor");
            $vo->setModelId(-1);
            $vo->setName($name);
            $vo->setPath($url);
            $vo->setExtension($extension);
            $vo->setMineType($mineType);
            $vo->setSize($size);
            $vo->setMd5($md5);

            $vo->getTableObject()->save();

            \DB::commit();

        } catch (\Throwable $e) {
            \Log::error($e);
            \DB::rollBack();
        }
    }

    /**
     * Notes: 成功
     * User: admin
     * Date: 2020/4/9 15:09
     *
     * @param $url
     * @param $name
     * @return array
     */
    public function success($url, $name)
    {
        return [
            "state" => "SUCCESS",
            "url" => $url,
            "title" => $name,
            "original" => $name
        ];
    }

    /**
     * Notes: 失败
     * User: admin
     * Date: 2020/4/9 15:16
     *
     * @return array
     */
    public function failed()
    {
        return [
            "state" => "FAILED",
        ];
    }
}
