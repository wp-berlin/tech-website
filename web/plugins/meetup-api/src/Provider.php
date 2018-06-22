<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 12:17
 */
declare(strict_types = 1);

namespace WpBerlin\MeetupApi;

class Provider implements ProviderInterface
{
    protected const BASE_URL = 'https://api.meetup.com/';
    protected const GROUP = 'Berlin-WordPress-Meetup';
    private $apiKey;
    private $eventHosts;

    public function __construct(string $apiKey, array $eventHosts)
    {
        $this->apiKey     = $apiKey;
        $this->eventHosts = $eventHosts;
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
        return json_decode(wp_remote_retrieve_body(wp_remote_get(add_query_arg([
                'sign'       => 'true',
                'photo-host' => 'public',
            ], self::BASE_URL . self::GROUP . '/events'))), true) ?? [];
    }

    public function isValidHost(array $hosts) : bool
    {
        foreach ($hosts as $host) {
            if (in_array($host['id'], $this->eventHosts)) {
                return true;
            }
        }

        return false;
    }

    public function getEventHosts(string $eventId) : array
    {
        return json_decode(wp_remote_retrieve_body(wp_remote_get(
                sprintf('%s/%s/events/%s/hosts', self::BASE_URL, self::GROUP, $eventId)
            )), true) ?? [];
    }
}
