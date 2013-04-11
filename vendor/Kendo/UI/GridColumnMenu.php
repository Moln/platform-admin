<?php

namespace Kendo\UI;

class GridColumnMenu extends \Kendo\SerializableObject {
//>> Properties

    /**
    * Enable/disable columns section in column header menu.
    * @param boolean $value
    * @return \Kendo\UI\GridColumnMenu
    */
    public function columns($value) {
        return $this->setProperty('columns', $value);
    }

    /**
    * Enable/disable filter section in column header menu.
    * @param boolean $value
    * @return \Kendo\UI\GridColumnMenu
    */
    public function filterable($value) {
        return $this->setProperty('filterable', $value);
    }

    /**
    * Enable/disable sorting section in column header menu.
    * @param boolean $value
    * @return \Kendo\UI\GridColumnMenu
    */
    public function sortable($value) {
        return $this->setProperty('sortable', $value);
    }

    /**
    * Sets the columnMenu messages.
    * @param \Kendo\UI\GridColumnMenuMessages|array $value
    * @return \Kendo\UI\GridColumnMenu
    */
    public function messages($value) {
        return $this->setProperty('messages', $value);
    }

//<< Properties
}

?>
