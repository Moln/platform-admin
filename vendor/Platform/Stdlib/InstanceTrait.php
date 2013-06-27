<?php
/**
 * platform-admin InstanceTrait.php
 * @DateTime 13-5-31 上午9:57
 */

namespace Platform\Stdlib;


trait InstanceTrait {
    protected static $instance;

    /**
     * Singleton instance
     *
     * @return static
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            $class = new \ReflectionClass(__CLASS__);
            self::$instance = $class->newInstanceArgs(func_get_args());
        }

        return self::$instance;
    }
}