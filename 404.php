<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="content">
    <div class="mainContent">
        <div class="box404">
            <img src="<?php $this->options->themeUrl('assets/images/404.svg'); ?>" alt="">
        </div>
    </div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>