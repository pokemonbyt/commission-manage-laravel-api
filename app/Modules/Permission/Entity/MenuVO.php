<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/1 19:27
 */

namespace App\Modules\Permission\Entity;

use App\Models\Menus;
use Illuminate\Http\Request;

/**
 * Notes: 菜单数据实体类 (主要是用于多参数的接收)
 *
 * Class Menu
 * @package App\Modules\Permission\Entity
 */
class MenuVO
{
    private $name;
    private $path;
    private $component;
    private $redirect;
    private $title;
    private $icon;
    private $hidden;
    private $no_cache;
    private $outreach;
    private $sort;
    private $pid;

    public function setRequest(Request $request)
    {
        $this->setName($request->name);
        $this->setPath($request->path);
        $this->setComponent($request->component);
        $this->setRedirect($request->redirects);
        $this->setTitle($request->title);
        $this->setIcon($request->icon);
        $this->setHidden($request->hidden);
        $this->setNoCache($request->no_cache);
        $this->setOutreach($request->outreach);
        $this->setSort($request->sort);
        $this->setPid($request->pid);
    }

    /**
     * Notes: Menus
     * User: admin
     * Date: 2020/7/29 18:36
     *
     * @param Menus|null $menus
     * @return Menus
     */
    public function getTableObj(Menus $menus = null)
    {
        if (!$menus) {
            $menus = new Menus();
        }

        $menus->name = $this->getName();
        $menus->path = $this->getPath();
        $menus->component = $this->getComponent();
        $menus->redirect = $this->getRedirect();
        $menus->title = $this->getTitle();
        $menus->icon = $this->getIcon();
        $menus->hidden = $this->getHidden();
        $menus->no_cache = $this->getNoCache();
        $menus->outreach = $this->getOutreach();
        $menus->sort = $this->getSort();
        $menus->pid = $this->getPid();

        return $menus;
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
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param mixed $component
     */
    public function setComponent($component): void
    {
        $this->component = $component;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect): void
    {
        $this->redirect = $redirect;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param mixed $hidden
     */
    public function setHidden($hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * @return mixed
     */
    public function getNoCache()
    {
        return $this->no_cache;
    }

    /**
     * @param mixed $no_cache
     */
    public function setNoCache($no_cache): void
    {
        $this->no_cache = $no_cache;
    }

    /**
     * @return mixed
     */
    public function getOutreach()
    {
        return $this->outreach;
    }

    /**
     * @param mixed $outreach
     */
    public function setOutreach($outreach): void
    {
        $this->outreach = $outreach;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param mixed $pid
     */
    public function setPid($pid): void
    {
        $this->pid = $pid;
    }
}
