<?php
/**
 * platform-admin AbstractStorage.php
 * @DateTime 13-5-31 下午5:36
 */

namespace Platform\File\Storage;
use Zend\Filter\AbstractFilter;
use Zend\Filter\FilterChain;
use Zend\Validator\ValidatorChain;

/**
 * Class AbstractStorage
 * @package Platform\File\Storage
 * @author Moln Xie
 * @version $Id$
 */
abstract class AbstractStorage implements StorageInterface
{

    /**
     * @var AbstractFilter[]
     */
    protected $filters;
    protected $validators;
    protected $validatorChain, $filterChain;
    protected $defaultPath = '/';
    protected $config = array();

    protected $validatorsAliases
        = array(
            'count'            => 'filecount',
            'crc32'            => 'filecrc32',
            'excludeextension' => 'fileexcludeextension',
            'excludemimetype'  => 'fileexcludemimetype',
            'exists'           => 'fileexists',
            'extension'        => 'fileextension',
            'filessize'        => 'filefilessize',
            'hash'             => 'filehash',
            'imagesize'        => 'fileimagesize',
            'iscompressed'     => 'fileiscompressed',
            'isimage'          => 'fileisimage',
            'md5'              => 'filemd5',
            'mimetype'         => 'filemimetype',
            'notexists'        => 'filenotexists',
            'sha1'             => 'filesha1',
            'size'             => 'filesize',
            'upload'           => 'fileupload',
            'wordcount'        => 'filewordcount',
        );

    protected $filtersAliases
        = array(
            'decrypt'      => 'filedecrypt',
            'encrypt'      => 'fileencrypt',
            'lowercase'    => 'filelowercase',
            'rename'       => 'filerename',
            'uppercase'    => 'fileuppercase',
            'renameupload' => 'filerenameupload',
        );

    public function __construct(array $config = array())
    {
        $this->filterChain    = new FilterChain();
        $this->validatorChain = new ValidatorChain();

        $this->setConfig($config);
    }

    /**
     * @param string $defaultPath
     *
     * @return AbstractStorage
     */
    public function setDefaultPath($defaultPath)
    {
        $this->defaultPath = rtrim($defaultPath, '\\/') . DIRECTORY_SEPARATOR;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultPath()
    {
        return $this->defaultPath;
    }

    /**
     *
     * @param $source
     * @param $target
     *
     * @return bool
     */
    abstract public function move($source, $target);

    /**
     * @param      $directory
     * @param bool $showDetail
     *
     * @return array|FileInfo[]
     */
    abstract public function readDirectory($directory, $showDetail = false);

    abstract public function mkdirs($path, $mode = 0777);

    public function setConfig(array $config)
    {
        foreach ($config as $key => $val) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($val);
            }
        }
        $this->config = $config;
    }

    public function addValidators(array $validators)
    {
        $chain = $this->getValidatorChain();
        foreach ($validators as $key => $options) {
            if (is_int($key)) {
                $key     = $options;
                $options = null;
            }

            $this->validators[strtolower($key)] = $validator = $chain->plugin($key, $options);
            $chain->attach($validator);
        }
        return $this;
    }

    public function addFilters(array $filters)
    {
        $chain = $this->getFilterChain();
        foreach ($filters as $key => $options) {
            if (is_int($key)) {
                $key     = $options;
                $options = null;
            }

            $this->filters[strtolower($key)]
                = $filter = $chain->getPluginManager()->get($key, $options);
            $chain->attach($filter);
        }
        return $this;
    }

    public function getFilter($name)
    {
        $name = strtolower($name);
        if (isset($this->filters[$name])) {
            return $this->filters[$name];
        } else {
            if ($name == 'renameupload') {
                $this->filters[$name] = $this->getFilterChain()->getPluginManager()->get($name);
                $this->getFilterChain()->attach($this->filters[$name]);
                return $this->filters[$name];
            }
        }

        return null;
    }

    public function getValidator($name)
    {
        return isset($this->validators[$name]) ? $this->validators[$name] : null;
    }

    /**
     * @return ValidatorChain
     */
    public function getValidatorChain()
    {
        return $this->validatorChain;
    }

    /**
     * @return FilterChain
     */
    public function getFilterChain()
    {
        return $this->filterChain;
    }

    public function isValid($value)
    {
        return $this->getValidatorChain()->isValid($value);
    }

    /**
     * Delete directory or file
     * @param string $path
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    abstract public function delete($path);

    abstract public function upload($value);
}