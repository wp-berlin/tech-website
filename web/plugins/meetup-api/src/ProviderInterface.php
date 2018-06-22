<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 12:24
 */
declare(strict_types = 1);

namespace WpBerlin\MeetupApi;

interface ProviderInterface
{
    public function getEvents() : array;

    public function getEventHosts(string $eventId) : array;

    public function getValidEvents() : array;

    public function isValidHost(array $hosts) : bool;
}
