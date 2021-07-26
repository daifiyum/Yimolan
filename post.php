<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="postMain">
    <article class="postText">
        <div id="root2"> <!--文章提示语-->
            <i class="postNotice animate__animated animate__fadeInDown" v-show="pnotice">空调开放呀~</i>
        </div>
        <div class="postTbox">
            <?php $this->author->gravatar(32, 'G', NULL, 'postTimg'); ?>
            <div class="innerTbox">
                <h3><?php $this->author(); ?></h3>
                <p>
                    <?php $this->date(Y年m月d日); ?> 阅读<?php $views = getPostViews($this); ?><?php echo $views; ?>
                </p>
            </div>
        </div>
        <h2 class="postTitle"><?php $this->title() ?></h2>

        <div class="mainText">
            <?php $this->content(); ?>
        </div>

        <div class="postend">
            <div class="postNext">
                <li>分类：<?php $this->category(' · ', true, '<a href="javascript:;">暂无分类</a>'); ?></li>
                <li>标签：<?php $this->tags(' · ', true, '<a href="javascript:;">暂无标签</a>'); ?></li>
                <li>上一篇: <?php $this->thePrev('%s', '没有了'); ?></li>
                <li>下一篇：<?php $this->theNext('%s', '没有了'); ?></li>
            </div>
            <div class="comment">
                <?php $this->need('comments.php'); ?>
            </div>
        </div>
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


<script>
    //文章提示语逻辑
    new Vue({
        el: '#root2',
        data: {
            pnotice: false,
        },
        mounted: function() {
            this.pnshow();
        },
        methods: {
            pnshow: function() {
                this.pnotice = true;
                const that = this;
                setTimeout(function() {
                    that.pnotice = !that.pnotice
                }, 3000)
            }
        }
    })
</script>
<?php $this->need('footer.php'); ?>