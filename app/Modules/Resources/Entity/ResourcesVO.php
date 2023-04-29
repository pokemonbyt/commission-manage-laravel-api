<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/3 14:52
 */

namespace App\Modules\Resources\Entity;

use App\Models\Resources;

/**
 * Notes: 资源上传表数据对象
 *
 * Class ResourcesVO
 * @package App\Modules\Resources\Entity
 */
class ResourcesVO
{
    private $model_type;
    private $model_id;
    private $name;
    private $path;
    private $extension;
    private $mine_type;
    private $size;
    private $md5;

    /**
     * Notes: 获取资源表对象
     * User: admin
     * Date: 2020/3/3 16:05
     *
     * @param Resources|null $resources
     * @return Resources
     */
    public function getTableObject(Resources $resources = null)
    {
        if (!$resources) {
            $resources = new Resources();
        }

        $resources->model_type = $this->getModelType();
        $resources->model_id = $this->getModelId();
        $resources->name = $this->getName();
        $resources->path = $this->getPath();
        $resources->extension = $this->getExtension();
        $resources->mine_type = $this->getMineType();
        $resources->size = $this->getSize();
        $resources->md5 = $this->getMd5();

        return $resources;
    }

    /**
     * @return mixed
     */
    public function getModelType()
    {
        return $this->model_type;
    }

    /**
     * @param mixed $model_type
     */
    public function setModelType($model_type): void
    {
        $this->model_type = $model_type;
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->model_id;
    }

    /**
     * @param mixed $model_id
     */
    public function setModelId($model_id): void
    {
        $this->model_id = $model_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getMineType()
    {
        return $this->mine_type;
    }

    /**
     * @param mixed $mine_type
     */
    public function setMineType($mine_type): void
    {
        $this->mine_type = $mine_type;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * @param mixed $md5
     */
    public function setMd5($md5): void
    {
        $this->md5 = $md5;
    }
}
