<?php
/**
 * platform-admin LowerCaseName.php
 * @DateTime 13-6-5 上午10:48
 */

namespace Platform\Filter\File;
use Zend\Filter\StringToLower;

/**
 * Class LowerCaseName
 * @package Platform\Filter\File
 * @author Moln Xie
 * @version $Id$
 */
class LowerCaseName extends StringToLower
{
    public function filter($value)
    {
        if (is_array($value) && isset($value['name'])) {
            $value['name'] = parent::filter($value['name']);
        } else if (is_string($value)) {
            $value = parent::filter($value);
        } else {
            throw new \InvalidArgumentException('Error argument type "' . gettype($value) . '"');
        }

        return $value;
    }
}