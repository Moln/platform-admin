<?php
/**
 * platform-admin UiAdapterInterface.php
 * @DateTime 13-5-21 下午2:35
 */

namespace Platform\Mvc\Controller\Plugin\UiAdapter;

use Zend\Http\Request;

interface UiAdapterInterface
{
    public function __construct(Request $request);

    public function filter($fieldMap = array());

    public function sort();

    public function result($data, $total = null, array $dataTypes = null);

    public function errors($messages);
}