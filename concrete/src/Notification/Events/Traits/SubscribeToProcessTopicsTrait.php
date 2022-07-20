<?php

namespace Concrete\Core\Notification\Events\Traits;

use Concrete\Core\Notification\Events\MercureService;
use Concrete\Core\Notification\Events\ServerEvent\BatchUpdatedEvent;
use Concrete\Core\Notification\Events\ServerEvent\ProcessClosedEvent;
use Concrete\Core\Notification\Events\ServerEvent\ProcessOutputEvent;
use Concrete\Core\Notification\Events\Subscriber;

trait SubscribeToProcessTopicsTrait
{

    public function subscribeToProcessTopicsIfNotificationEnabled($refreshCookie = true): ?Subscriber
    {
        $mercureService = app(MercureService::class);
        if ($mercureService->isEnabled()) {
            $events = [
                BatchUpdatedEvent::class,
                ProcessClosedEvent::class,
                ProcessOutputEvent::class,
            ];
            $subscriber = $mercureService->getSubscriber();
            foreach ($events as $event) {
                $subscriber->addEvent($event);
            }
            if ($refreshCookie) {
                $subscriber->refreshAuthorizationCookie();
            }
            return $subscriber;
        }
        return null;
    }
}

