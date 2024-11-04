<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="achieves">
    <h3><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 <span>%s</span> 下的文章'),
            'search'    =>  _t('包含关键字 <span>%s</span> 的文章'),
            'tag'       =>  _t('标签 <span>%s</span> 下的文章'),
            'author'    =>  _t('<span>%s</span> 发布的文章')
        ), '', ''); ?></h3>
</div>
<div id="root1" class="content">
    <div class="mainContent">
        <?php if ($this->have()) : ?>
            <?php while ($this->next()) : ?>
                <?php if ($this->hidden == 1) : ?>
            <section class="contentCard pitmsback animate__animated animate__fadeInUp">
        <?php else : ?>
            <section class="contentCard animate__animated animate__fadeInUp">
        <?php endif; ?>
                <div class="gadget">
                    <span><?php $this->author(); ?></span>
                    <span class="plSpace"></span>
                    <span><?php timesince($this->created); ?></span>
                    <?php if($this->category!=false): ?>
                    <span class="plSpace"></span>
                    <?php endif; ?>
                    <span><?php $this->category(' · '); ?></span>
                    
                </div>

                <a class="ititle" href="<?php $this->permalink() ?>">
                    <h2><?php $this->sticky() ?><?php $this->title() ?></h2>
                </a>

                <div onclick="window.open('<?php $this->permalink() ?>','_self')" class="itext">
                    <!--<?php echo $this->hidden; ?>-->
                    <?php if ($this->hidden == 1) : ?>
                        <p class="passw">文章已加密</p>
                    <?php else : ?>
                        <p><?php $this->excerpt(100, '...'); ?></p>
                    <?php endif; ?>


                    <!--下面的逻辑判断是魔鬼-->
                    <?php $img = getPostImg($this); ?>
                    <?php $tcount = art_count($this->cid); ?>
                    <!--判断是否有文字-->
                    <?php if ($tcount != 0) : ?>
                        <!--判断是否有图-->
                        <?php if ($img != "none") : ?>
                            <!--判断是否在后台关闭预览图显示-->
                            <?php if (!empty($this->options->indeximg) && in_array('open_indeximg', $this->options->indeximg)) : ?>
                                <img class="gauss-img gauss-style pictures" src="<?php $this->options->themeUrl(); ?>timthumb.php?src=<?php echo $img; ?>&w=120&h=74&q=10" data-src="<?php echo $img; ?>" alt="">
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ($img != "none") : ?>
                            <!--因为上面有个无文字就显示图的判断,导致在没图的时候会强制显示,所以在这再加一个图片判断-->
                            <img id="trueImg" class="gauss-img gauss-style pictures" src="<?php $this->options->themeUrl(); ?>timthumb.php?src=<?php echo $img; ?>&w=200&h=300&q=10" data-src="<?php echo $img; ?>" alt="">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="noSearch">
                <div></div> <!--搜索为空背景图-->
                <h2><?php _e('没有找到内容'); ?></h2>
            </div>
        <?php endif; ?>
        <div class="orignext" ref="more" v-if="mshow">
            <?php $this->pageNav('&laquo;', '&raquo;', 1, '...', array('wrapTag' => 'ul', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'pageactive', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
        </div>
    </div>
    <?php $this->need('sidebar.php'); ?>
    
<script>
    new Vue({
        el: '#root1',
        data: {
            mshow: true,
        },
        mounted: function() {
            this.add();
        },
        methods: {
            add: function() {
                if (this.$refs.more.childElementCount == 0) {
                    this.mshow = false;
                }
            }
        }
    })
</script>
<?php $this->need('footer.php'); ?>