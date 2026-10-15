<?php
declare(strict_types=1);

function canComplete(array $session, int $eventId, int $now, int $ttl): bool {
    if ($ttl <= 0) {
        return false;
    }
    if ($eventId <= 0) {
        return false;
    }
    if (!isset($session['draft']) || !is_array($session['draft'])) {
        return false;
    }
    $draft = $session['draft'];
    if (!isset($draft['data'], $draft['created_at'])) {
        return false;
    }
    if (!is_array($draft['data'])) {
        return false;
    }
    if (!is_int($draft['created_at'])) {
        return false;
    }
    $createdAt = $draft['created_at'];
    if ($createdAt > $now) {
        return false;
    }
    if ($now - $createdAt >= $ttl) {
        return false;
    }
    if (!isset($draft['data']['event_id'])) {
        return false;
    }
    if ((int)$draft['data']['event_id'] !== $eventId) {
        return false;
    }
    return true;
}