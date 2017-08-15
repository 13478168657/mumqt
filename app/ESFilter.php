<?php

namespace App;

/**
 * Description of ESFilter
 *
 * @author yuanl
 */
class ESFilter {
    
    public $field;
    public $type;
    public $minValue;
    public $maxValue;
    public $values;
    
    public function __construct($field,$type,$minVal,$maxVal,$values){
        $this->field = $field;
        $this->minValue = $minVal;
        $this->maxValue = $maxVal;
        $this->values = $values;
        $this->type = $type;
    }
}
