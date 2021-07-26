<?php
/**
 * 一个简洁的typecho主题
 * 
 * @SimpleBlue 
 * @author dnxrzl
 * @version 0.1
 * @link https://www.dnxrzl.com
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

?>

<div id="root1" class="content">
    <div class="mainContent">
        <?php while ($this->next()) : ?>
            <section onclick="window.open('<?php $this->permalink() ?>','_self')" class="contentCard animate__animated animate__fadeInUp">
                <div class="gadget">
                    <span><?php $this->author(); ?></span>
                    <span class="plSpace"></span>
                    <span><?php timesince($this->created); ?></span>
                    <span class="plSpace"></span>
                    <span><?php $this->category(' · '); ?></span>
                </div>

                <a class="ititle" href="<?php $this->permalink() ?>">
                    <h2><?php $this->sticky() ?><?php $this->title() ?></h2>
                </a>

                <div class="itext">
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

        <div class="orignext" ref="more" v-if="mshow">
            <?php $this->pageNav('&laquo;', '&raquo;', 1, '...', array('wrapTag' => 'ul', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'pageactive', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
        </div>
    </div>


    <?php $this->need('sidebar.php'); ?>
    <script>
        var app1 = new Vue({
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