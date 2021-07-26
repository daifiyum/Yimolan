<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<footer>
    <nav>
        <li>
            Powered by Typecho Theme ❤️ <a style="color:#007fff" href="https://www.dnxrzl.com/257.html">SimpleBlue</a>
        </li>
        <li><a href="https://beian.miit.gov.cn/"><?php $this->options->beian() ?></a></li>
        <li>开发中...</li>
    </nav>
    <div id="gotop"><span class="icon-expand_less"></span></div> <!--返回顶部-->
</footer>
<?php $this->footer(); ?>
<script src="<?php $this->options->themeUrl('assets/js/main.js'); ?>"></script>
</body>
</html>