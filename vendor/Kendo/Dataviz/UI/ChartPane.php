<?php

namespace Kendo\Dataviz\UI;

class ChartPane extends \Kendo\SerializableObject {
//>> Properties

    /**
    * The unique pane name.
    * @param string $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function name($value) {
        return $this->setProperty('name', $value);
    }

    /**
    * The margin of the pane.
    * @param float| $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function margin($value) {
        return $this->setProperty('margin', $value);
    }

    /**
    * The padding of the pane.
    * @param float| $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function padding($value) {
        return $this->setProperty('padding', $value);
    }

    /**
    * The background color of the pane.
    * @param string $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function background($value) {
        return $this->setProperty('background', $value);
    }

    /**
    * The border of the pane.
    * @param \Kendo\Dataviz\UI\ChartPaneBorder|array $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function border($value) {
        return $this->setProperty('border', $value);
    }

    /**
    * The pane height in pixels.
    * @param float $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function height($value) {
        return $this->setProperty('height', $value);
    }

    /**
    * The pane title text or configuration.
    * @param string|\Kendo\Dataviz\UI\ChartPaneTitle|array $value
    * @return \Kendo\Dataviz\UI\ChartPane
    */
    public function title($value) {
        return $this->setProperty('title', $value);
    }

//<< Properties
}

?>
