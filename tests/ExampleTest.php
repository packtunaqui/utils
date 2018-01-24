<?php

namespace Tunaqui\Utils;

use Tunaqui\Utils\Arrays\ArraySelectable;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue()
    {
        $selectable = new ArraySelectable([
            'node1' => [
                'numeric' => 9,
                'list' => [ 1, 2, 3, 4, 5, 6, 7, 8, 9],
                'bool' => true
            ],
            'node2' => [
                'bool' => false,
                'string' => 'Hola mundo',
            ],
            'node3' => null
        ]);
        $this->assertTrue(is_array($selectable->find('node1.list')));
    }
}
