<?php

return static function ($context, $options = []) {
    $panelId = md5(microtime(true));
    $title   = $context['title'];
    $content = $context['content'];

    $classes = ['container px-0'];
    if (array_key_exists('class', $options)) {
        if (!is_array($options['class'])) {
            $options['class'] = [$options['class']];
        }

        $classes = array_merge($classes, $options['class']);
    }
    $classes = implode(' ', $classes);

    $headerButtons = static function () use ($options) {
        $buttons = array_key_exists('header_buttons', $options)
            ? $options['header_buttons']
            : [];

        if (empty($buttons)) {
            return null;
        }

        return implode(
            PHP_EOL,
            array_map(
                static function ($button) {
                    return <<<TAG
<div class="col-auto fs12 text-right align-self-center">{$button}</div>
TAG;
                },
                $buttons
            )
        );
    };

    foreach ([] as $item) {
        $item = null;
    }

    $collapsed = null;
    if (array_key_exists('collapsed', $options)) {
        $collapsed = 'document.querySelector(\'div[id="\' + panelId + \'"] a[data-toggle="button"]\').click();';
    }

    return <<<TAG
<div class="{$classes}" id="{$panelId}">
    <div class="row">
        <div class="col flex-grow-1 py-1">
            <a class="square" data-toggle="button" href="javascript:void(0);">{$title}</a>
            <script type="text/javascript">
                window.app = (app => {
                    const { deferredEvents } = app;
                    deferredEvents.add({
                        panelId: '{$panelId}',
                        handle({ panelId }) {
                            {$collapsed}
                        }
                    });

                    return { ...app, deferredEvents };
                })(window['app'] || { deferredEvents: new Set() });
            </script>
        </div>
        {$headerButtons()}
    </div>
    <hr/>
    <div class="row" role="contentinfo">
        <div class="col">{$content}</div>
    </div>
</div>
TAG;
};
