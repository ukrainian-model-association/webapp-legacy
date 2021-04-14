<?php

/**
 * @param array $context
 * @param ServiceContainer $di
 *
 * @return string
 */

use App\Component\ServiceContainer;
use App\Component\UI\UI;

/**
 * @param array $context
 * @param ServiceContainer $di
 *
 * @return null|string
 */
return static function ($context, $di) {
    $profile  = $context['profile'];
    $contacts = profile_peer::instance()->getAvailableContacts($profile['user_id']);
    /** @var UI $ui */
    $ui = $di->get('ui');

    if (empty($contacts)) {
        return null;
    }

    $di
        ->register(
            'ContactHypertextReferenceAdapter',
            static function ($type, $value) {
                switch ($type) {
                    case 'skype':
                        return sprintf('skype: %s', $value);

                    case 'phone':
                        return sprintf('tel: %s', $value);

                    case 'email':
                        return sprintf('mailto: %s', $value);

                    default:
                        if (!preg_match('/https?:\/\//', $value)) {
                            $value = sprintf('https://%s', $value);
                        }

                        return $value;
                }
            }
        )
        ->register(
            'ContactIconReferenceAdapter',
            static function ($type) {
                switch (true) {
                    case 'wiki' === $type:
                        return 'https://img.icons8.com/ios-filled/128/000000/wikipedia.png';

                    case 'website' === $type:
                        return 'https://img.icons8.com/ios-filled/128/000000/web.png';

                    case 'modelscom' === $type:
                        return 'https://models.org.ua/public/img/models_ico.png';

                    case 'instagram' === $type:
                        return 'https://models.org.ua/public/img/insta_ico.png';

                    case 'facebook' === $type:
                        return 'https://models.org.ua/public/img/fb_ico.png';

                    default:
                        return $type;
                }
            }
        )
        ->register(
            'profile.contacts.horizontal',
            static function ($contacts) use ($di) {
                return implode(
                    PHP_EOL,
                    array_map(
                        static function ($contact) use ($di) {
                            $value = $contact['value'];
                            $icon  = $di->call('ContactIconReferenceAdapter', $contact['key']);
                            $icon  = sprintf('%s', $icon);
                            $href  = $di->call('ContactHypertextReferenceAdapter', $contact['key'], $value);

                            return <<<HTML
<li class="list-group-item px-0 py-1">
    <a href="{$href}" target="_blank">
        <img src="{$icon}" class="mr-1" style="width: 24px" alt="..."> {$value}
    </a>
</li>
HTML;
                        },
                        $contacts
                    )
                );
            }
        )
        ->register(
            'profile.contacts.vertical',
            static function ($contacts) use ($di) {
                return implode(
                    PHP_EOL,
                    array_map(
                        static function ($contact) use ($di) {
                            $value = $contact['value'];
                            $icon  = $di->call('ContactIconReferenceAdapter', $contact['key']);
                            $icon  = sprintf('%s', $icon);
                            $href  = $di->call('ContactHypertextReferenceAdapter', $contact['key'], $value);

                            return <<<HTML
<div class="mr-1">
    <a href="{$href}" target="_blank">
        <img src="{$icon}" style="width: 24px" alt="...">
    </a>
</div>
HTML;
                        },
                        $contacts
                    )
                );
            }
        );
    $renderContacts = static function ($contacts, $keys, $template) use ($di) {
        $contacts = array_filter(
            $contacts,
            static function ($contact) use ($keys) {
                $key       = $contact['key'];
                $value     = $contact['value'];
                $available = (bool) $contact['access'];

                return !empty($value) && $available && in_array($key, $keys, true);
            }
        );

        if (empty($contacts)) {
            return null;
        }

        if ('horizontal' === $template) {
            return $di->call('profile.contacts.horizontal', $contacts);
        }

        return <<<HTML
<li class="list-group-item px-0 py-1">
    <div class="d-flex flex-row">
        {$di->call('profile.contacts.vertical', $contacts)}
    </div>
</li>
HTML;
    };

    $content = sprintf(
        '<ul class="list-group list-group-flush fs12">%s%s</ul>',
        $renderContacts($contacts, ['facebook', 'modelscom', 'wiki', 'skype', 'instagram'], 'vertical'),
        $renderContacts($contacts, ['email', 'phone', 'website'], 'horizontal')
    );

    return $ui->render(
        'layout/panel',
        [
            'title'   => 'Контакты',
            'content' => $content,
        ],
        [
            'class' => 'mt-1',
        ]
    );
};
