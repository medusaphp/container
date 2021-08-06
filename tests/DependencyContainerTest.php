<?php declare(strict_types = 1);
namespace Medusa\Container;

use DateTime;
use Medusa\Container\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class DependencyContainerTest
 * @package medusa/container
 * @author  Pascal Schnell <pascal.schnell@getmedusa.org>
 */
class DependencyContainerTest extends TestCase {

    public function test__constructError() {
        $this->expectException(TypeError::class);
        new DependencyContainer([
                                    'key' => 'value',
                                ]);
    }

    public function testGet() {
        $di = new DependencyContainer(
            services: [
                          'Test1' => function() {
                              $dt = new DateTime('2021-01-01');
                              return $dt;
                          },
                      ],
            singletonServices: [
                          'Test2' => function() {
                              $dt = new DateTime("2021-01-01");
                              return $dt;
                          },
                      ],

        );

        $this->assertTrue($di->get('Test1') !== $di->get('Test1'));
        $this->assertSame($di->get('Test2'), $di->get('Test2'));
        $this->assertTrue($di->get('Test2') !== $di->get('Test1'));
        $this->assertTrue($di->has('Test1'));
        $this->assertTrue($di->has('Test2'));
        $this->assertFalse($di->has('Test3'));
        $this->expectException(NotFoundException::class);
        $di->get('unknown');
    }
}
