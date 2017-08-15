<?php
namespace App;

/**
 * 地图搜索房源 参数
 *
 * @author xcy
 */
class IndexUpdateEntity
{

    private $indexId = 0;

    private $fields = 'timeRefresh';

    private $value = 0;

    /**
     *
     * @return mixed
     */
    public function getIndexId()
    {
        return $this->indexId;
    }

    /**
     *
     * @param mixed $indexId             
     */
    public function setIndexId($indexId)
    {
        $this->indexId = $indexId;
    }

    /**
     *
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     *
     * @param mixed $fields            
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @param mixed $value            
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
