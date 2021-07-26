<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="postMain">
    <article class="postText">
        <div class="mainText">
            <?php $this->content(); ?>
        </div>
        <?php if ($this->allow('comment')) : ?> <!--判断是否关闭了评论？若关闭则不显示下面的评论块-->
            <div class="postend">
                <div class="comment">
                    <?php $this->need('comments.php'); ?>
                </div>
            </div>
        <?php endif; ?>
    </article>
    <div class="siderPost">
        <!--<div class="pfirst">-->
        <!--    <h3>关于作者</h3>-->
        <!--    <ul>-->
        <!--        <li><a href="#"><?php $this->author(); ?></a></li>-->
        <!--    </ul>-->
        <!--</div>-->
        <div class="psec">
            <h3>推荐文章</h3>
            <ul>
                <?php $this->widget('Widget_Contents_Post_Recent')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
            </ul>
        </div>
    </div>
</div>
<?php $this->need('footer.php'); ?>