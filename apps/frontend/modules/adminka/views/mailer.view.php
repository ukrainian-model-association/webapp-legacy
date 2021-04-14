<style>
    .amu_messages_menu {
        border-bottom: 1px solid #a0a0a0;
    }

    .amu_messages_menu a {
        border: 1px solid #a0a0a0;
        border-bottom: 0;
        padding: 0 10px;
        margin-left: 3px;
    }

    .amu_messages_menu a:hover {
        background: #f0f0f0;
    }

    .amu_messages_menu a.selected {
        border: 1px solid #a0a0a0;
        border-bottom: 1px solid white;
    }
</style>

<div class="d-flex flex-row">
<?php include 'admin_menu.php' ?>
<div class="ml-3">
    <div class="amu_messages_menu">
        <a href="/adminka/mailer?frame=add"
           class="<?= (request::get('frame') === 'add' || !request::get('frame')) ? ' selected' : '' ?>">Новая
            рассылка</a>
        <a href="/adminka/mailer?frame=drafts" class="<?= (request::get('frame') === 'drafts') ? ' selected' : '' ?>">Черновики</a>
        <a href="/adminka/mailer?frame=active" class="<?= (request::get('frame') === 'active') ? ' selected' : '' ?>">Активные</a>
        <a href="/adminka/mailer?frame=in_queue"
           class="<?= (request::get('frame') === 'in_queue') ? ' selected' : '' ?>">В очереди</a>
        <a href="/adminka/mailer?frame=complete"
           class="<?= (request::get('frame') === 'complete') ? ' selected' : '' ?>">Завершенные</a>

    </div>
    <?php if (request::get('frame') === 'add' || !request::get('frame')) { ?>
        <div id="form-box">
            <?php include 'mailer/form.php' ?>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <?php if (in_array(request::get('frame'), ['active', 'in_queue', 'complete'])) { ?>
        <div id="list-box">
            <?php include 'mailer/list.php' ?>
        </div>
    <?php } ?>
    <?php if (request::get('frame') === 'drafts') { ?>
        <div id="drafts-box">
            <?php include 'mailer/drafts.php' ?>
        </div>
    <?php } ?>

</div>
</div>