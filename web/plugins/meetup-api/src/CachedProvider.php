<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 12:23
 */
declare(strict_types = 1);

namespace WpBerlin\MeetupApi;

class CachedProvider implements ProviderInterface
{

    private $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getValidEvents() : array
    {
        $events      = $this->getEvents();
        $validEvents = array_filter($events, function ($event) {
            if ($this->isValidHost($this->getEventHosts($event['id']))) {
                return true;
            }

            return false;
        });

        return $validEvents;
    }

    public function getEvents() : array
    {
        return $this->async('wpb_meetup_events', [$this->provider, 'getEvents']);
    }

    private function async(string $key, callable $callback, array $params = [], int $ttl = 300)
    {
        return tlc_transient($key)
            ->updates_with($callback, $params)
            ->expires_in($ttl)
            ->background_only()
            ->get() ?: [];
    }

    public function isValidHost(array $hosts) : bool
    {
        return $this->provider->isValidHost($hosts);
    }

    public function getEventHosts(string $eventId) : array
    {
        return $this->async('wpb_meetup_event_hosts_' . $eventId, [$this->provider, 'getEventHosts'], [$eventId]);
    }
}
