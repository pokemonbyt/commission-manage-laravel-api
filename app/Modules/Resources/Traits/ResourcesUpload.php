<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/4 10:21
 */

namespace App\Modules\Resources\Traits;


use App\Models\Resources;
use App\Modules\Resources\Conf\ResourcesConfig;
use App\Modules\Resources\Entity\ResourcesVO;
use App\Modules\Resources\ErrorCode\ResourcesErrorCode;
use Illuminate\Database\Eloquent\Model;

/**
 * Notes: 资源上传拓展
 * （需要后期绑定，也就是说上传之后，需要重新绑定关联模型id，和模型type，如果不绑定相当于是垃圾资源，可能会被清理）
 *
 * Trait ResourcesUpload
 * @package App\Modules\Resources\Traits
 */
trait ResourcesUpload
{
    /**
     * Notes: 多态关联资源（一对多）只有绑定模型才有效
     * User: admin
     * Date: 2020/7/8 13:14
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|null
     */
    public function resources()
    {
        if ($this instanceof Model) {
            return $this->morphMany(Resources::class, 'model');
        }

        return null;
    }

    /**
     * Notes: 上传文件
     * User: admin
     * Date: 2020/3/4 12:41
     *
     * @return array|int
     */
    public function uploadFile()
    {
        $file = request()->file('file');
        if ($file) {
            if ($model = $this->saveFile($file)) {
                return [$model->id];
            }

            return [];
        }

        return ResourcesErrorCode::FILE_READ_FAILED;
    }

    /**
     * Notes: 批量上传文件
     * User: admin
     * Date: 2020/3/4 12:44
     *
     * @return array|int
     */
    public function uploadFiles()
    {
        $files = request()->file('files');
        if ($files) {
            if (count($files) > ResourcesConfig::LIMIT) {
                return ResourcesErrorCode::NUMBER_OF_FILES_EXCEEDED;
            }

            try {
                \DB::beginTransaction();

                $ids = [];
                foreach ($files as $k => $file) {
                    if ($model = $this->saveFile($file)) {
                        $ids[] = $model->id;
                    }
                }

                \DB::commit();

                return $ids;

            } catch (\Throwable $e) {
                \Log::error($e);
                return ResourcesErrorCode::FILE_UPLOAD_EXCEPTION;
            }
        }

        return ResourcesErrorCode::FILE_READ_FAILED;
    }

    /**
     * Notes: 上传截图
     * User: admin
     * Date: 2020/7/20 17:19
     *
     * @return array|int
     */
    public function uploadScreenshot()
    {
        $base64 = utils()->parseBase64(request()['file']);
        $base64Str = $base64['str'];

        $file = $base64['file'];
        if ($base64) {
            $mineType = $base64['res'][1];
            $extension = $base64['res'][2];
            $name = \Str::random(40) . ".{$extension}";
            $url = ResourcesConfig::PATH . "/$name";

            if(\Storage::put($url, $file)) {
                //保存数据库
                $vo = new ResourcesVO();
                $vo->setName($name);
                $vo->setPath($url);
                $vo->setExtension($extension);
                $vo->setMineType($mineType);
                $vo->setSize(utils()->base64Size($base64Str));
                $vo->setMd5(md5($base64Str));

                $model = $vo->getTableObject();
                $model->save();

                return [$model->id];
            }
        }

        return ResourcesErrorCode::SCREENSHOT_PARSING_ERROR;
    }

    /**
     * Notes: 根据资源id绑定资源 解绑
     * User: admin
     * Date: 2020/6/17 14:16
     *
     * @param array $ids
     */
    public function bind(array $ids)
    {
        $resources = $this->findResByIds($ids);
        foreach ($resources as $resource) {
            //如果资源已经被绑定，就拷贝多一条资源数据绑定
            if ($resource->model_type) {
                $newRes = new Resources();

                $newRes->model_type = $this->getMorphClass();
                $newRes->model_id = $this->getKey();
                $newRes->name = $resource->name;
                $newRes->path = $resource->path;
                $newRes->extension = $resource->extension;
                $newRes->mine_type = $resource->mine_type;
                $newRes->size = $resource->size;
                $newRes->md5 = $resource->md5;

                $newRes->save();

            } else {
                $resource->model_type = $this->getMorphClass();
                $resource->model_id = $this->getKey();
                $resource->save();
            }
        }
    }

    /**
     * Notes: 自定义类型绑定资源
     * User: admin
     * Date: 2020/9/18 13:38
     *
     * @param array $ids
     * @param $modelType
     * @param $modelId
     */
    public function bindByType(array $ids, $modelType, $modelId)
    {
        $resources = $this->findResByIds($ids);
        foreach ($resources as $resource) {
            //如果资源已经被绑定，就拷贝多一条资源数据绑定
            if ($resource->model_type) {
                $newRes = new Resources();

                $newRes->model_type = $modelType;
                $newRes->model_id = $modelId;
                $newRes->name = $resource->name;
                $newRes->path = $resource->path;
                $newRes->extension = $resource->extension;
                $newRes->mine_type = $resource->mine_type;
                $newRes->size = $resource->size;
                $newRes->md5 = $resource->md5;

                $newRes->save();

            } else {
                $resource->model_type = $modelType;
                $resource->model_id = $modelId;
                $resource->save();
            }
        }
    }

    /**
     * Notes: 解除资源绑定（解除绑定之后，资源就是垃圾资源）
     * User: admin
     * Date: 2020/6/17 17:34
     *
     * newRes: 新上传的资源id列表，如果旧的资源在这个列表就不需要解除资源绑定
     *
     * @param array $newRes
     */
    public function untie(array $newRes = [])
    {
        foreach ($this->resources as $resource) {
            if (!in_array($resource->id, $newRes)) {
                $resource->model_type = null;
                $resource->model_id = null;
                $resource->save();
            }
        }
    }

    /**
     * Notes: 保存
     * User: admin
     * Date: 2020/3/3 20:18
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return \App\Models\Resources
     */
    private function saveFile($file)
    {
        $md5 = md5_file('/tmp/' . $file->getFilename());

        $vo = new ResourcesVO();

        //是否是模型绑定(绑定的话直接模型调用上传接口会自动绑定resources表内的model_id， model_type)
        if (isset($this->revisionEnabled) && $this->isBindResModel) {
            $vo->setModelType($this->getMorphClass());
            $vo->setModelId($this->getKey());
        }

        $vo->setName($file->getClientOriginalName());
        $vo->setExtension($file->getClientOriginalExtension());
        $vo->setMineType($file->getClientMimeType());
        $vo->setSize($file->getSize());
        $vo->setMd5($md5);

        //利用文件MD5的唯一性，实现如果有文件存在服务器，就不需要再上传文件（实现秒传）
        //也同时会检测文件是否存在
        $res = $this->findResByMD5($md5);
        if ($res && \Storage::exists($res->path)) {
            $vo->setPath($res->path);
        } else {
            $extension = $vo->getExtension();
            //文字拓展名
            if ($extension) {
                $name = \Str::random(40) . ".{$extension}";
            } else {
                $name = \Str::random(40);
            }
            //用自己生成的文件名字和拓展名上传
            $path = \Storage::putFileAs(ResourcesConfig::PATH, $file, $name);
            $vo->setPath($path);
        }

        $model = $vo->getTableObject();
        $model->save();

        return $model;
    }

    /**
     * Notes: 根据MD5查找资源
     * User: admin
     * Date: 2020/7/8 12:24
     *
     * @param $md5
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null|Resources
     */
    private function findResByMD5($md5)
    {
        return Resources::where('md5', $md5)->first();
    }

    /**
     * Notes: 根据id查找资源列表
     * User: admin
     * Date: 2020/8/6 21:32
     *
     * @param array $ids
     * @return \Illuminate\Support\Collection|Resources[]
     */
    private function findResByIds(array $ids)
    {
        return Resources::whereIn('id', $ids)->get();
    }
}
