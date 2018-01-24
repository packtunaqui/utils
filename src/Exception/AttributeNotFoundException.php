<?php

/**
 *  Author     : EstevanTn
 *  Email      : tunaqui@outlook.es
 *  Repository : https://github.com/EstevanTn
 *
 *  This file AttributeNotFoundExceptionion.php is part of the Utils project.
 *  Created at: 2018/01/11
 **/

namespace Tunaqui\Utils\Exception;

use Exception;
use Throwable;

class AttributeNotFoundException extends Exception
{
    public function __construct($nameAttr, $nameClass, Throwable $previous = null)
    {
        parent::__construct("The attribute '{$nameAttr}' does not found in the class '{$nameClass}'.", 404, $previous);
    }
}