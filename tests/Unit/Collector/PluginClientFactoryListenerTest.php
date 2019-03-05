<?php

namespace Http\HttplugBundle\Tests\Unit\Collector;

use Http\Client\Common\PluginClientFactory as DefaultPluginClientFactory;
use Http\HttplugBundle\Collector\Collector;
use Http\HttplugBundle\Collector\Formatter;
use Http\HttplugBundle\Collector\PluginClientFactory;
use Http\HttplugBundle\Collector\PluginClientFactoryListener;
use Http\Message\Formatter as MessageFormatter;
use Nyholm\NSA;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Stopwatch\Stopwatch;

final class PluginClientFactoryListenerTest extends TestCase
{
    public function testRegisterPluginClientFactory()
    {
        $collector = new Collector();
        $formatter = new Formatter($this->createMock(MessageFormatter::class), $this->createMock(MessageFormatter::class));
        $stopwatch = $this->createMock(Stopwatch::class);

        $factory = new PluginClientFactory($collector, $formatter, $stopwatch);

        $listener = new PluginClientFactoryListener($factory);

        $listener->onEvent(new Event());

        $this->assertTrue(is_callable(NSA::getProperty(DefaultPluginClientFactory::class, 'factory')));
    }
}
