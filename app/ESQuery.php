<?php

namespace App;

/**
 * Description of ESQuery
 *
 * @author yuanl
 */
class ESQuery {
    public $field;
    public $keywords;
    
    public function __construct($field,$keywords){
        $this->field = $field;
        $this->keywords = $keywords;
    }
}
