<?php

/**
 * @param array $context
 *
 * @return string
 */
return static function ($context = []) {
    $c = (new App\Component\ServiceContainer())
        ->register(
            'birthday',
            static function ($birthday) {
                if (null === $birthday) {
                    return null;
                }

                return sprintf('<span class="cgray">(%s)</span>', $birthday);
            }
        );

    $profile  = $context['profile'];
    $age      = profile_peer::getAge($profile);
    $birthday = profile_peer::getBirthday($profile);

    if (null === $age) {
        return null;
    }

    return <<<HTML
<div>
<span>{$age}</span>
<span style="font-weight: normal !important"> {$c->call('birthday', $birthday)}</span>
</div>
HTML;
};


