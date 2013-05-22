<?php
/**
 * platform-admin Ui.php
 * @DateTime 13-5-20 下午5:06
 */

namespace Platform\Mvc\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Stdlib\DispatchableInterface;

/**
 * Class Ui
 * @package Platform\Mvc\Controller\Plugin
 * @author Moln Xie
 * @version $Id$
 */
class Ui extends AbstractPlugin
{
    /**
     * @var UiAdapter\UiAdapterInterface
     */
    protected $adapter;

    public function setController(DispatchableInterface $controller)
    {
        parent::setController($controller);
        $this->adapter = new UiAdapter\Kendo($this->getController()->getRequest());
    }

    /**
     * @param array $fieldMap
     *
     * @return \Zend\Db\Sql\Where|array
     */
    public function filter($fieldMap = array())
    {
        return $this->adapter->filter($fieldMap);
    }

    /**
     * @return array
     */
    public function sort()
    {
        return $this->adapter->sort();
    }

    public function result($data, $total = null, array $dataTypes = null)
    {
        return $this->adapter->result($data, $total, $dataTypes);
    }

    public function errors($messages)
    {
        return $this->adapter->errors($messages);
    }
}