<?php

namespace Kendo\Data;

class DataSourceGroupItem extends \Kendo\SerializableObject {
//>> Properties

    /**
    * Specifies the field to group by.
    * @param string $value
    * @return \Kendo\Data\DataSourceGroupItem
    */
    public function field($value) {
        return $this->setProperty('field', $value);
    }

    /**
    * Specifies the order of the groupped items.
    * @param string $value
    * @return \Kendo\Data\DataSourceGroupItem
    */
    public function dir($value) {
        return $this->setProperty('dir', $value);
    }

    /**
    * Adds DataSourceGroupItemAggregate to the DataSourceGroupItem.
    * @param \Kendo\Data\DataSourceGroupItemAggregate|array,... $value one or more DataSourceGroupItemAggregate to add.
    * @return \Kendo\Data\DataSourceGroupItem
    */
    public function addAggregate($value) {
        return $this->add('aggregates', func_get_args());
    }

//<< Properties
}

?>
