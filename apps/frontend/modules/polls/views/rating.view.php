<?php

function generate_cols($list, $start, $count, $attr, $imgsizes, $fs, $template = null)
{
    $tooltipStyle = implode('; ', [
        'position: absolute',
        'background: black',
        'color: white',
        'border-radius: 5px',
        'font-size: 11px',
        'padding: 5px 10px',
    ]);

    if (!$template) {
        $template = <<<FRAGMENT
<td %attr% style="text-align: center">
    <div style="position: relative">
        <div class='fs14'>
            <span class='bold'>%place%</span> место
        </div>
        <div class='%fs4%' style="position: absolute; right: 5px; bottom: 0; color: white; text-shadow: 0 0 3px black">
            <img src='/rating_hand.png' style='%img2style%' alt='/rating_hand.png'> %sum%
        </div>
        <a href='/profile?id=%user_id%'>
            <img style='%imgstyle%' src='%src%' alt='' data-avatar="%user_id%">
        </a>
    </div>
    <div data-tooltip="%user_id%"
         class="hide"
         style="{$tooltipStyle}">%first_name% %last_name%
    </div>
</td>
FRAGMENT;
    }
    for ($i = $start; $i < $count; $i++) {
        $data = db::get_row('SELECT user_id,first_name,last_name, pid, ph_crop FROM user_data WHERE user_id=:id', ['id' => $list[$i]['user_id']]);
        $crop = unserialize($data['ph_crop']);
        if ($data) {
            $arr = [
                '/%mt%/'         => $fs['mt'],
                '/%attr%/'       => $attr,
                '/%fs%/'         => $fs[0],
                '/%fs2%/'        => $fs[1],
                '/%fs3%/'        => $fs[2],
                '/%fs4%/'        => $fs[3],
                '/%place%/'      => (($i + 1) + (request::get_int('page', 1) - 1) * 40),
                '/%user_id%/'    => $data['user_id'],
                '/%imgstyle%/'   => $imgsizes[0],
                '/%img2style%/'  => $imgsizes[1],
                '/%src%/'        => '/imgserve?pid='.$data['pid'].'&w='.$crop['w'].'&h='.$crop['h'].'&x='.$crop['x'].'&y='.$crop['y'].'&z=crop',
                '/%first_name%/' => $data['first_name'],
                '/%last_name%/'  => $data['last_name'],
                '/%sum%/'        => ($list[$i]['sum']),
            ];
            echo preg_replace(array_keys($arr), array_values($arr), $template);
        }
    }
}

?>
<style>
    .fs0 {
        font-size: 0px;
    }

    table td {
        text-align: center;

    }
</style>
<div class="rating_content_box">
    <?
    switch (request::get_int('type', voting_peer::MODEL_RATING)) {
        case voting_peer::MODEL_RATING:
            include 'partials/models_rating.php';
            break;
        case 'models-full':
            include 'partials/full_rating.php';
            break;
        default :
            include 'partials/models_rating.php';
            break;
    }
    ?>
</div>
