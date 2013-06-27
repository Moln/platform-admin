<?php
/**
 * platform-admin Ftp.php
 * @DateTime 13-5-30 下午1:39
 */

namespace Platform\File\Storage;

use Platform\Client\Ftp as FtpClient;

/**
 * Class Ftp
 * @package Platform\File\Storage
 * @author Xiemaomao
 * @version $Id$
 */
class Ftp extends AbstractStorage
{
    protected $ftp;

    public function __construct(array $config)
    {
        if (empty($config['ftp'])) {
            throw new \InvalidArgumentException('Unknown ftp config.');
        }

        $this->ftp = new FtpClient($config['ftp']);
        parent::__construct($config);
    }

    public function move($source, $target)
    {
        $this->ftp->chdir($this->getDefaultPath());
        return $this->ftp->upload($source, $target);
    }

    /**
     * @param      $directory
     * @param bool $showDetail
     *
     * @return array|FileInfo[]
     */
    public function readDirectory($directory, $showDetail = false)
    {
        $this->ftp->chdir($this->getDefaultPath());
        if ($showDetail) {
            $list = $this->ftp->rawlist($directory);
            foreach ($list as &$file) {
                $file = new FileInfo($file);
            }

            return $list;
        } else {
            return $this->ftp->nlist($directory);
        }
    }

    public function upload($value)
    {
        if (!(is_array($value) && isset($value['tmp_name']))) {
            throw new \InvalidArgumentException('Invalid upload parameter.');
        }
        $this->ftp->chdir($this->getDefaultPath());

        /** @var \Platform\Filter\File\RenameUpload $filter */
        $filter = $this->getFilter('renameupload');
        $target = $filter->getFinalTarget($value);

        if ($this->ftp->upload($value['tmp_name'], $target)) {
            $value['tmp_name'] = $target;
            return $value;
        } else {
            throw new \RuntimeException('Ftp upload error: ' . $this->ftp->getErrorMessage());
        }
    }

    public function mkdirs($path, $mode = 0777)
    {
        $this->ftp->chdir($this->getDefaultPath());
        return $this->ftp->mkdirs($path, $mode);
    }
}