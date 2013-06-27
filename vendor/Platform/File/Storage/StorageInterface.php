<?php
/**
 * platform-admin SaveHandlerInterface.php
 * @DateTime 13-5-30 下午4:55
 */

namespace Platform\File\Storage;


interface StorageInterface
{

    /**
     *
     * @param $source
     * @param $target
     *
     * @return bool
     */
    public function move($source, $target);

}