<?php

namespace App\Intl;

use session;

class LanguageSwitcher
{
    public function __construct()
    {
    }

    public static function create()
    {
        return new self();
    }

    public function __toString()
    {
        $selectors = array_map([$this, 'createLanguageSelector'], [LanguageTypes::RU, LanguageTypes::EN]);

        return sprintf('<div class="btn-group" role="group" aria-label="Language Switcher">%s</div>', PHP_EOL . implode(PHP_EOL, $selectors) . PHP_EOL);
    }

    public function createLanguageSelector($language)
    {
        $className = 'light';

        if (session::get('language') === $language) {
            $className = 'dark';
        }

        return sprintf('<a href="/sign/language?code=%s" class="btn btn-sm btn-%s">%s</a>', strtolower($language), $className, strtoupper($language));
    }
}
