<?php
/**
 *  Author     : EstevanTn
 *  Email      : tunaqui@outlook.es
 *  Repository : https://github.com/EstevanTn
 *
 *  This file ArrayObject.php is part of the Nisleen project.
 *  Created at: 2018/01/23
 **/

namespace Tunaqui\Utils\Arrays;

use ArrayAccess;
use Tunaqui\Utils\Exception\AttributeNotFoundException;

class ArrayObject implements ArrayAccess
{

    /**
     * @var int
     */
    private $index;

    /**
     * @var array
     */
    private $keys;

    /**
     * @var int
     */
    private $indexItem;

    public function __construct()
    {
        $this->index= 0;
        $this->keys = [];
        $this->indexItem = -1;
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
        return isset($this->{$offset});
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @throws \Tunaqui\Utils\Exception\AttributeNotFoundException
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if($this->offsetExists($offset)) {
            return $this->{$offset};
        }
        throw new AttributeNotFoundException($offset, __CLASS__);
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
        if(is_null($offset)) {
            $offset = $this->index;
            $this->index++;
        }
        $this->indexItem = array_push($this->keys, $offset);
        $this->{$offset} = $value;
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
        if($this->offsetExists($offset)) {
            unset($this->{$offset});
        }
    }

    /**
     * @return array
     */
    public function all() {
        $all = array();
        foreach ($this->keys as $key) {
            $all[$key] = $this->{$key};
        }
        return $all;
    }

    /**
     * @return array
     */
    public function keys() {
        return $this->keys;
    }

    /**
     * @param mixed $value
     * @return int
     */
    public function push($value) {
        $this->offsetSet(null, $value);
        return $this->indexItem;
    }

    /**
     * @param string $offset
     * @param mixed $value
     * @return int
     */
    public function add($offset, $value) {
        $this->offsetSet($offset, $value);
        return $this->indexItem;
    }

}