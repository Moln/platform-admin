<?php
/**
 * platform-admin StorageFactory.php
 * @DateTime 13-6-3 下午2:37
 */

namespace Platform\File\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class StorageFactory
 * @package Platform\File
 * @author Moln Xie
 * @version $Id$
 */
class StorageFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @throws \RuntimeException
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = $config['file_storage'];
        if (!$config['type']) {
            throw new \RuntimeException('Unknown "type" config.');
        }
        if (!$config['options']) {
            throw new \RuntimeException('Unknown "options" config.');
        }

        $className = __NAMESPACE__ . '\\' . ucfirst($config['type']);
        if (!class_exists($className)
            && in_array(__NAMESPACE__ . '\\' . 'StorageInterface', class_implements($className))
        ) {
            throw new \RuntimeException('Error config type:' . $config['type']);
        }


        /** @var AbstractStorage $fileStorage */
        $fileStorage = new $className($config['options']);

        $validatorsAliases = array(
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

        $filtersAliases = array(
            'decrypt'      => 'filedecrypt',
            'encrypt'      => 'fileencrypt',
            'lowercase'    => 'filelowercase',
            'rename'       => 'filerename',
            'uppercase'    => 'fileuppercase',
//            'renameupload' => 'filerenameupload',
        );

        /**
         * @var \Zend\Validator\ValidatorPluginManager $vm
         * @var \Zend\Filter\FilterPluginManager       $fm
         */
        $vm = $serviceLocator->get('ValidatorManager');
        $fm = $serviceLocator->get('FilterManager');

        foreach ($validatorsAliases as $key => $value) {
            $vm->setAlias($key, $value);
        }

        foreach ($filtersAliases as $key => $value) {
            $fm->setAlias($key, $value);
        }

        $fm->setInvokableClass('lowercasename', 'Platform\Filter\File\LowerCaseName');
        $fm->setInvokableClass('renameupload', 'Platform\Filter\File\RenameUpload');

        $fileStorage->getValidatorChain()->setPluginManager($vm);
        $fileStorage->getFilterChain()->setPluginManager($fm);

        if (isset($config['options']['validators'])) {
            $fileStorage->addValidators($config['options']['validators']);
        }

        if (isset($config['options']['filters'])) {
            $fileStorage->addFilters($config['options']['filters']);
        }
        return $fileStorage;
    }
}