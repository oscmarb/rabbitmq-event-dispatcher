<?php

declare(strict_types=1);

namespace Oscmarb\RabbitMQEventDispatcher;

use Oscmarb\Ddd\Domain\DomainEvent\DomainEvent;
use Oscmarb\Ddd\Domain\DomainEvent\EventDispatcher;
use Oscmarb\RabbitMQ\RabbitMQConnection;
use Oscmarb\RabbitMQ\RabbitMQRoutingConfig;
use Oscmarb\RabbitMQ\RoutedRabbitMQPublisher;

final class RabbitMQEventDispatcher implements EventDispatcher
{
    private RoutedRabbitMQPublisher $publisher;

    public function __construct(RabbitMQConnection $connection, RabbitMQRoutingConfig $routingConfig)
    {
        $this->publisher = new RoutedRabbitMQPublisher($connection, $routingConfig);
    }

    public function dispatch(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->publisher->publish($event);
        }
    }
}