<?php

/**
 * @param int $personId
 * @param     $context
 *
 * @return string
 */
return static function ($personId, $context) {
    $userAuth = user_auth_peer::instance()->get_item($personId);

    if (4 === $userAuth['type']) {
        return call_user_func(require __DIR__.'/work_place/agent.php', $personId);
    }

    return call_user_func(require __DIR__.'/work_place/default.php', $personId);
};