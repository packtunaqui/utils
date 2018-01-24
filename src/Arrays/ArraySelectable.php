<?php
/**
 * @autor: EstevanTn
 * @email: <tumenaquiche@gmail.com>
 *
 * Copyright (c) 2018. TunaquiSoft
 */

namespace Tunaqui\Utils\Arrays;

use ArrayAccess;
use Tunaqui\Utils\Exception\AttributeNotFoundException;


/**
 * Allows you to select a value from a multidimensional array.
 * Class ArraySelectable
 * @package Tunaqui\Utils\Arrays
 */
class ArraySelectable implements ArrayAccess
{
    protected $original;
    protected $selected;
    protected $attributes;
    const DEFAULT_EMPTY_VALUE = 'none';

    public function __construct(array $attributes=[])
    {
        $this->original = $attributes;
        $this->attributes = [];
        foreach ($attributes as $key => $attribute) {
            $this->setAttribute($key, $attribute);
        }
    }

    public function setAttribute($offset, $value) {
        $this->original[$offset] = $value;
        if(is_array($value)) {
            $value = new ArraySelectable($value);
        }
        $this->attributes[$offset] = $value;
    }

    public function getAttribute($offset) {
        if(isset($this->attributes[$offset])) {
            return $this->attributes[$offset];
        } else {
            if(empty($this->attributes[$offset])){
                return new AttributeNotFoundException($offset, get_class($this));
            }else{
                return null;
            }
        }
    }

    public function findKey($offset) {
        $this->selected = $this->getAttribute($offset);
        if ($this->selected instanceof ArraySelectable) {
            return $this->selected;
        }
        return $this;
    }

    public function getVal(){
        if ($this->selected instanceof AttributeNotFoundException) {
            throw $this->selected;
        }
        return $this->selected ? $this->selected : $this->attributes;
    }

    public function select($offset) {
        $keys = explode('.', $offset);
        $selectable = $this->findKey($keys[0]);
        for ($i=1; $i<count($keys); $i++) {
            if ($selectable instanceof ArraySelectable) {
                $selectable = $selectable->findKey($keys[$i]);
            }
        }
        return $selectable;
    }

    public function hasAttribute($offset) {
        if(count(explode('.', $offset))>1) {
            $select = $this->select($offset)->selected;
            return $select instanceof AttributeNotFoundException ? false : true;
        } else {
            return isset($this->attributes[$offset]);
        }
    }

    public function find($offset) {
        if($this->hasAttribute($offset)){
            return $this->select($offset)->getVal();
        } else {
            //throw new AttributeNotFoundException($offset, get_class($this));
        }
    }

    public function setItem($offset, $value){
        $keys = explode('.', $offset);
        $lastIndex = $keys[count($keys)-1];
        if($this->hasAttribute($offset)) {
            $selectValue = $this->select($offset);
            $selectValue->setAttribute($lastIndex, $value);
        } else {
            for($x=0; $x<count($keys)-1; $x++) {
                $key = $this->factoryKey($keys, $x+1);
                if($x>=1) {
                    if(!$this->hasAttribute($key)) {
                        $beforeIndex = $this->factoryKey($keys,$x-1);
                        $this->select($beforeIndex)->setAttribute($keys[$x], []);
                    }
                } else {
                    $this->setAttribute($key, []);
                }
            }
            $this->select($offset)->setAttribute($lastIndex, $value);
        }
    }

    private function factoryKey($keys, $count)
    {
        $key = '';
        for ($i = 0; $i < $count; $i++) {
            $key .= $keys[$i];
            if ($i < $count) {
                $key .= '.';
            }
        }
        return $key;
    }

    public function getItem($offset) {
        return $this->find($offset);
    }

    public static function toSelectable(array $attributes){
        $model = new ArraySelectable($attributes);
        foreach ($attributes as $key => $value){
            $model->setAttribute($key, $value);
        }
        return $model;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->find($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->setItem($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $value = $this->find($offset);
            unset($value);
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

}