<?php
namespace Moln\Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class ImageBrowserController
 *
 * @package Admin\Controller
 * @author  Moln
 *
 * @method \Zend\Http\Request getRequest();
 */
class ImageBrowserController extends AbstractActionController
{
    /**
     * @return \Gzfextra\FileStorage\Adapter\AbstractStorageAdapter
     */
    public function getFileStorage()
    {
        return $this->getServiceLocator()->get('FileStorage');
    }

    public function readAction()
    {
        $path  = $this->getRequest()->getPost('path');
        $files = array();
        foreach ($this->getFileStorage()->readDirectory($path, true) as $file) {
            $files[] = array(
                'name' => $file->getName(),
                'type' => $file->isDir() ? 'd' : 'f',
                'size' => $file->getSize(),
            );
        }

        return new JsonModel($files);
    }

    public function deleteAction()
    {
        $path = $this->getRequest()->getPost('path') ? : '.';
        $name = $this->getRequest()->getPost('name');
        $this->getFileStorage()->delete(rtrim($path, '\\/') . '/' . $name);
        return new JsonModel(array());
    }

    public function createAction()
    {
        $path = $this->getRequest()->getPost('path');
        $name = $this->getRequest()->getPost('name');

        $this->getFileStorage()->mkdirs($path . '/' . $name);
        return new JsonModel(array());
    }

    public function thumbnailAction()
    {
        return new JsonModel(array());
    }

    public function uploadAction()
    {
        $name = 'file';
//        $urlPath = date('/Ym/d/');
//        $this->mkdirs($path);

        $fileStorage = $this->getFileStorage();
        $file        = $this->getRequest()->getFiles('file');

        if ($fileStorage->isValid($file)) {
            $file = $fileStorage->upload($file);
            return new JsonModel(array(
                'size' => $file['size'],
                'name' => basename($file['tmp_name']),
                'type' => 'f',
//            'path' => $urlPath . basename($file['tmp_name']),
            ));
        } else {
            return $this->ui()->errors($fileStorage->getValidatorChain()->getMessages());
        }
    }
}