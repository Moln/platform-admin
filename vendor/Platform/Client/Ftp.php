<?php
/**
 * platform-admin Ftp.php
 * @DateTime 13-5-31 上午9:55
 */

namespace Platform\Client;
use Platform\Stdlib\InstanceTrait;

/**
 * Class Ftp
 * Copy from self
 * @package Platform\Ftp
 * @author Xiemaomao
 * @version $Id$
 */
class Ftp
{
    use InstanceTrait;

    const FTP_ERR_CONNECT_TO_SERVER = 'Connect error';
    const FTP_ERR_USER_NO_LOGGIN    = 'Login error';
    const FTP_ERR_CHDIR             = 'Error "chdir"';
    const FTP_ERR_MKDIR             = 'Error "mkdir"';
    const FTP_ERR_SOURCE_READ       = 'Source read error';
    const FTP_ERR_TARGET_WRITE      = 'Target write error';
    const FTP_ERR_SITE              = 'Error "site"';
    const FTP_ERR_CHMOD             = 'Error "chmod"';

    protected $config
        = array(
            'host'     => null,
            'username' => null,
            'password' => null,
            'ssl'      => false,
            'port'     => 21,
            'timeout'  => 10,
        );

    protected $func;
    protected $cid;
    protected $error;

    public function __construct(array $config)
    {
        if (empty($config['host']) || empty($config['username']) || empty($config['password'])) {
            throw new \RuntimeException('Ftp config error!');
        }

        $this->config['host']     = $config['host'];
        $this->config['username'] = $config['username'];
        $this->config['password'] = $config['password'];

        if (!empty($config['port'])) {
            $this->config['port'] = (int)$config['port'];
        }
        if (!empty($config['timeout'])) {
            $this->config['timeout'] = (int)$config['timeout'];
        }

        if (!empty($config['ssl'])) {
            $this->config['ssl'] = (boolean)$config['ssl'];
        }
    }

    public function getConnect()
    {
        if (!$this->cid) {
            $this->connect();
        }
        return $this->cid;
    }

    public function connect($pasv = false)
    {
        if ($this->cid) {
            return true;
        }

        $call = $this->config['ssl'] ? 'ftp_ssl_connect' : 'ftp_connect';

        if (!function_exists($call)) {
            throw new \RuntimeException("Function \"$call\" not exists.");
        }

        $this->cid = $call(
            $this->config['host'], $this->config['port'], $this->config['timeout']
        );
        if ($this->cid) {
            $r = @ftp_login($this->cid, $this->config['username'], $this->config['password']);
            if ($r) {
                $this->pasv($pasv);
                return true;
            } else {
                $this->setError(self::FTP_ERR_USER_NO_LOGGIN);
                return false;
            }
        } else {
            $this->setError(self::FTP_ERR_CONNECT_TO_SERVER);
            return false;
        }
    }

    public function upload($source, $target)
    {
        if (!file_exists($source) || !is_readable($source)) {
            $this->setError(self::FTP_ERR_SOURCE_READ);
            return false;
        }

        $current  = $this->pwd();
        $dirname  = dirname($target);
        $filename = basename($target);
        if (!$this->chdir($dirname)) {
            if ($this->mkdirs($dirname)) {
                if (!$this->chdir($dirname)) {
                    $this->setError(self::FTP_ERR_CHDIR);
                    return false;
                }
            } else {
                $this->setError(self::FTP_ERR_MKDIR);
                return false;
            }
        }

        if (!$this->put($filename, $source)) {
            $this->setError(self::FTP_ERR_TARGET_WRITE);
            return false;
        }

        $this->chdir($current);

        return true;
    }

    public function setError($code = 0)
    {
        $this->error = $code;
        return false;
    }

    public function getErrorMessage()
    {
        return $this->error;
    }

    public function setOption($option, $value)
    {
        return @ftp_set_option($this->getConnect(), $option, $value);
    }

    public function mkdirs($path, $mode = 0777)
    {
        $paths  = explode(
            DIRECTORY_SEPARATOR,
            str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, trim($path, '/\/'))
        );
        $root   = '';
        $result = false;
        foreach ($paths as $dir) {
            if ($dir == '.' || $dir == '..') {
                continue;
            }

            $root .= '/' . $dir;
            if ($result = @ftp_mkdir($this->getConnect(), $root)) {
                $this->chmod($root, $mode);
            }
        }
        return $result;
    }

    public function rmdir($directory)
    {
        return @ftp_rmdir($this->getConnect(), $directory);
    }

    public function put($remote_file, $local_file, $mode = FTP_BINARY)
    {
        return @ftp_put($this->getConnect(), $remote_file, $local_file, $mode);
    }

    public function fput($remote_file, $sourcefp, $mode = FTP_BINARY, $startpos = 0)
    {
        return @ftp_fput($this->getConnect(), $remote_file, $sourcefp, $mode, $startpos);
    }

    public function size($remote_file)
    {
        return @ftp_size($this->getConnect(), $remote_file);
    }

    public function close()
    {
        return @ftp_close($this->getConnect());
    }

    public function delete($path)
    {
        return @ftp_delete($this->getConnect(), $path);
    }

    public function get($local_file, $remote_file, $mode = FTP_BINARY, $resumepos = 0)
    {
        return @ftp_get($this->getConnect(), $local_file, $remote_file, $mode, $resumepos);
    }

    public function pasv($pasv)
    {
        return @ftp_pasv($this->getConnect(), (bool)$pasv);
    }

    public function chdir($directory)
    {
        $directory = rtrim($directory, '\\/');
        return @ftp_chdir($this->getConnect(), $directory) or $this->setError(self::FTP_ERR_CHDIR);
    }

    public function site($cmd)
    {
        return @ftp_site($this->getConnect(), $cmd) or $this->setError(self::FTP_ERR_SITE);
    }

    public function chmod($filename, $mod = 0777)
    {
        return @
            ftp_chmod($this->getConnect(), $mod, $filename) or $this->setError(self::FTP_ERR_CHMOD);
    }

    public function pwd()
    {
        return @ftp_pwd($this->getConnect());
    }

    public function rename($oldname, $newname)
    {
        return @ftp_rename($this->getConnect(), $oldname, $newname);
    }

    public function nlist($directory)
    {
        return ftp_nlist($this->getConnect(), $directory);
    }

    public function rawlist($directory, $recursive = false)
    {
        $data = ftp_rawlist($this->getConnect(), $directory, $recursive);
        return $this->parseList($data);
    }

    private function parseList($data)
    {
        $filetypes = array('-' => 'file', 'd' => 'directory', 'l' => 'link');
        $files     = array();

        foreach ($data as $line) {
            if (substr(strtolower($line), 0, 5) == 'total') {
                continue;
            } # first line, skip it
            preg_match(
                '/' . str_repeat('([^\s]+)\s+', 7) . '([^\s]+) (.*)/', $line, $matches
            ); # Here be Dragons
            list($permissions, $children, $owner, $group, $size, $month, $day, $time, $name)
                = array_slice($matches, 1);
            # if it's not a file, directory or link, I don't really care to know about it :-) comment out the next line if you do
            if (!in_array($permissions[0], array_keys($filetypes))) {
                continue;
            }
            $month = date('m', strtotime($month));
            $type = $filetypes[$permissions[0]];

            $date = date('Y-m-d H:i:00',
                (strpos($time, ':') ? mktime(substr($time, 0, 2), substr($time, -2), 0, $month, $day
                ) : mktime(0, 0, 0, $month, $day, $time))
            );

            $files[] = array(
                'name'        => $name,
                'type'        => $type,
                'permissions' => substr($permissions, 1),
                'children'    => $children,
                'owner'       => $owner,
                'group'       => $group,
                'size'        => $size,
                'mtime'       => $date
            );
        }

        return $files;
    }
}