<?php
namespace Admin\Model;

/**
 * Class Menu
 *
 * @package Admin\Model
 * @author  Moln
 * @version $Id: Menu.php 728 2014-09-11 02:55:35Z Moln $
 *
 * @property $menu_id
 * @property $parent_id
 * @property $parents
 * @property $name
 * @property $order
 * @property $url
 *
 */
class Menu
{
    /**
     * @param mixed $menu_id
     * @return Menu
     */
    public function setMenuId($menu_id)
    {
        $this->menu_id = $menu_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuId()
    {
        return $this->menu_id;
    }

    /**
     * @param mixed $name
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $order
     * @return Menu
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $parent_id
     * @return Menu
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parents
     * @return Menu
     */
    public function setParents($parents)
    {
        $this->parents = $parents;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param mixed $url
     * @return Menu
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

}