<?php
/**
 *  Author     : EstevanTn
 *  Email      : tunaqui@outlook.es
 *  Repository : https://github.com/EstevanTn
 *
 *  This file JsonResponsee.php is part of the Utils project.
 *  Created at: 2018/01/11
 **/

namespace Tunaqui\Utils\Http;

use ArrayAccess;
use Closure;
use Tunaqui\Utils\Exception\AttributeNotFoundException;
use Tunaqui\Utils\Objects;

/**
 * Class JsonResponse
 * @package Tunaqui\Utils\Http
 */
class JsonResponse implements ArrayAccess
{
    public $success;
    public $code;
    public $data;
    public $errors;
    public $message;
    private $index;
    public $valid_model;

    /**
     * JsonResponse constructor.
     * @param bool $success
     * @param string $message
     * @param int $code
     * @param mixed $data
     * @param array $errors
     */
    public function __construct($success=true, $message='Success!', $code=200, $data=[], $errors=[])
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
        $this->errors = $errors;
        $this->index = 0;
        $this->valid_model = null;
    }

    /**
     * Prepare an response
     * @param bool $success
     * @param string $message
     * @param int $code
     * @param mixed $data
     * @param array $errors
     */
    public function prepareResult($success, $message, $code, $data, $errors) {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
        if(is_null($this->data)) {
            $this->data = array();
        } else {
            if(!is_array($this->data)) {
                $old = $this->data;
                $this->data = array();
                array_push($this->data, $old);
            }
        }
        if(!is_null($data)) {
            if(is_array($data)) {
                $this->data = array_merge($this->data, $data);
            } else {
                array_push($this->data, $data);
            }
        }
        if(is_object($this->errors)) {
            $this->errors = Objects::attrToArray($this->errors);
        }
        if(is_string($this->errors) || is_numeric($this->errors)) {
            $err = $this->errors;
            $this->errors = array();
            $this->errors[0] = $err;
        }
        $this->errors = !is_null($errors) ? array_merge($this->errors, $errors) : $this->errors;
    }

    /**
     * Produces a failed response
     * @param string $message
     * @param mixed $data
     * @param int $code
     */
    public function prepareSuccess($message, $data=[], $code=200) {
        $this->prepareResult(true, $message, $code, $data, null);
    }

    /**
     * Produces a successful response
     * @param string $message
     * @param array $errors
     * @param int $code default 404
     */
    public function prepareError($message, $errors=[], $code=404) {
        $this->prepareResult(false, $message, $code, null , $errors);
    }

    /**
     * Add error
     * @param array ...$args
     */
    public function addError(...$args) {
        $args = func_get_args();
        if(func_num_args()>2){
            foreach ($args as $error) {
                array_push($this->errors, $error);
            }
        } else {
            if(func_get_args()==1) {
                $this->errors[] = $args[0];
            } else {
                $this->errors[$args[0]] = $args[1];
            }
        }
    }

    /**
     * Get attribute class
     * @param string $offset
     * @return mixed
     */
    public function getAttribute($offset){
        return $this->offsetGet($offset);
    }

    /**
     * Add a method to the instance
     * @param $abstract
     * @param Closure $closure
     */
    public function registerClosure($abstract, Closure $closure) {
        $this->$abstract = $closure($this);
    }

    /**
     * Is success response
     * @return bool
     */
    public function isSuccess() {
        return $this->success;
    }

    /**
     * Get or Set 'message' attribute
     * @param null $message
     * @return string
     */
    public function message($message=null) {
        if(is_null($message)) {
            return $this->message;
        }
        $this->message = $message;
    }

    /**
     * Get or Set 'data' attribute
     * @param null $data
     * @return mixed
     */
    public function data($data = null) {
        if(is_null($data)) {
            return $this->data;
        }
        $this->data = $data;
    }

    /**
     * Get or Set 'errors' attribute
     * @param null $errors
     * @return array
     */
    public function errors($errors = null) {
        if(is_null($errors)) {
            return $this->errors;
        }
        $this->errors = $errors;
    }

    /**
     * Set state response,  'success' attribute
     * @param $success
     */
    public function success($success) {
        $this->success = $success;
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
        return isset($this->$offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * @throws \Tunaqui\Utils\Exception\AttributeNotFoundException
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if($this->offsetExists($offset)) {
            return $this->$offset;
        } else {
            throw new AttributeNotFoundException($offset, __CLASS__);
        }
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
        dd($value);
        if(is_null($offset)) {
            $this->{$this->index} = $value;
            $this->index++;
        } else {
            $this->$offset = $value;
        }
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
            unset($this->$offset);
        }
    }
}