<?php

/**
 * @param array $context
 *
 * @return string
 */
return static function ($context) {
    $elementId = 'admin_block[top50_19]';

    return <<<HTML
<div class="row mt-2">
    <div class="col">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="{$elementId}">
                TOP50'19
            </label>
        </div>
    </div>
</div>
<script src="/public/js/app/profile/index/admin_block/top50_19.js?profileId={$context['profile']['user_id']}"
        type="application/javascript"></script>
HTML;
};

