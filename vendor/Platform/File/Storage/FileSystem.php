<?php
/**
 * platform-admin FileSystem.php
 * @DateTime 13-5-30 下午1:39
 */

namespace Platform\File\Storage;

/**
 * Class FileSystem
 * @package Platform\File\Storage
 * @author Xiemaomao
 * @version $Id$
 */
class FileSystem extends AbstractStorage
{
    protected $defaultPath = '/tmp';

    public function move($source, $target)
    {
        return move_uploaded_file($source, $target);
    }

    /**
     * @param      $directory
     * @param bool $showDetail
     *
     * @return array|FileInfo[]
     */
    public function readDirectory($directory, $showDetail = false)
    {
        $list = glob($this->getDefaultPath() . trim($directory, '\\/') . '/*');
        if ($showDetail) {
            foreach ($list as &$file) {
                $file = new FileInfo(array(
                    'name' => basename($file),
                    'size' => filesize($file),
                    'mtime' => filemtime($file),
                    'type' => is_dir($file) ? 'directory' : 'file',
                ));
            }

            return $list;
        } else {
            return $list;
        }
    }

    public function mkdirs($path, $mode = 0777)
    {
        $path = $this->getDefaultPath() . ltrim(str_replace(array('./', '../'), '', $path), '\\/');

        $paths = explode(
            DIRECTORY_SEPARATOR,
            str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, trim($path, '\\/'))
        );
        $root = '';
        foreach ($paths as $dir) {
            $root .= '/' . $dir;
            if (!is_dir($root) && !mkdir($root, $mode)) {
                return false;
            }
        }
        return true;
    }

    public function upload($value)
    {
        $filter = $this->getFilter('renameupload');
        $target = $filter->getTarget();
        $filter->setTarget($this->getDefaultPath() . ltrim($target, '\\/'));

        return $this->getFilterChain()->filter($value);
    }
}