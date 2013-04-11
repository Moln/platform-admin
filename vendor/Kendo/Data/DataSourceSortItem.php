<?php

namespace Kendo\Data;

class DataSourceSortItem extends \Kendo\SerializableObject {
//>> Properties

    /**
    * Sets the field to sort on.
    * @param string $value
    * @return \Kendo\Data\DataSourceSortItem
    */
    public function field($value) {
        return $this->setProperty('field', $value);
    }

    /**
    * Sets the sort direction. Possible values are: "asc", "desc", null. If null is set, the sort expression is removed.
    * @param string $value
    * @return \Kendo\Data\DataSourceSortItem
    */
    public function dir($value) {
        return $this->setProperty('dir', $value);
    }

//<< Properties
}

?>
