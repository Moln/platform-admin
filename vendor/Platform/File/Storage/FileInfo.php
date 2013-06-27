<?php
/**
 * platform-admin FileInfo.php
 * @DateTime 13-6-6 上午9:53
 */

namespace Platform\File\Storage;

/**
 * Class FileInfo
 * @package Platform\File\Storage
 * @author Moln Xie
 * @version $Id$
 */
class FileInfo 
{
    protected $name, $size, $mtime, $type, $permissions, $owner, $group;

    public function __construct(array $config)
    {
        foreach ($config as $key => $val) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($val);
            }
        }
    }

    /**
     * @param mixed $group
     *
     * @return FileInfo
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $mtime
     *
     * @return FileInfo
     */
    public function setMtime($mtime)
    {
        $this->mtime = $mtime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtime()
    {
        return $this->mtime;
    }

    /**
     * @param mixed $name
     *
     * @return FileInfo
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
     * @param mixed $owner
     *
     * @return FileInfo
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $permissions
     *
     * @return FileInfo
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param mixed $size
     *
     * @return FileInfo
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $type
     *
     * @return FileInfo
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function isDir()
    {
        return $this->type == 'directory';
    }

    public function isFile()
    {
        return $this->type == 'file';
    }
}