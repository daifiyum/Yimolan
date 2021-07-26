<!-- 下面是自定义评论列表 -->
<?php function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';  //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $commentClass .= ' comment-by-user';  //如果是评论作者的添加 .comment-by-user 样式
        }
    }
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
?>

    <!-- html部分 -->
    <div id="<?php $comments->theId(); ?>" class="comcell">
        <div class="comcellbox">
            <?php $comments->gravatar('40', ''); ?>
            <div class="cellRight">
                <div class="commentTitle">
                    <?php $comments->author(); ?>
                    <?php if ($comments->authorId == $comments->ownerId) : ?>
                        <span class="badge">作者</span>
                    <?php endif; ?>
                </div>
                <div class="cellhave">
                    <?php get_comment_at($comments->coid); ?> <!--@别人-->
                    <?php $comments->content(); ?>
                </div>
                <div class="cellTools">
                    <p>
                        <?php timesince($comments->created); ?> <!--简洁时间-->
                    </p>
                    <?php $comments->reply(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 子评论 -->
    <?php if ($comments->children) { ?>
        <div class="commentChild">
            <?php $comments->threadedComments($options); ?>
        </div>
    <?php } ?>

<?php } ?> <!--自定义评论列表结束-->

<?php $this->comments()->to($comments); ?>
<?php if ($this->allow('comment')) : ?>
    <!-- 表单输入 -->
    <div id="<?php $this->respondId(); ?>" class="docom">
        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <?php if ($this->user->hasLogin()) : ?>
                <div class="ifsign">
                    <span>
                        <?php _e('已登录: '); ?>
                        <?php $this->user->screenName(); ?>
                    </span>
                    <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">
                        <?php _e('退出?'); ?>
                    </a>
                </div>
            <?php else : ?>
                <div class="stalkhead">
                    <input type="text" name="author" placeholder="昵称" value="" required="required">
                    <input type="email" name="mail" placeholder="邮箱" value="" required="required">
                    <input type="url" name="url" placeholder="http://(可不填)" value="">
                </div>
            <?php endif; ?>
            <div class="textareap">
                <textarea name="text" placeholder="来啊，快活啊 ( ゜- ゜)" required="required"></textarea>
            </div>
            <div class="submitBit">
                <!-- 取消回复 -->
                <?php $comments->cancelReply('<button>取消</button>'); ?>
                <div class="spacecom"></div>
                <button type="submit">发送</button>
            </div>
        </form>
    </div>
<?php else : ?>
    <!--评论已关闭-->
<?php endif; ?>

<?php if ($comments->have()) : ?>
    <!--<h4><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h4>-->
    <?php $comments->listComments(); ?>
    <div id="root1">
        <div class="orignext" ref="more" v-if="mshow">
            <?php $comments->pageNav('&laquo;', '&raquo;', 1, '...', array('wrapTag' => 'ul', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'pageactive', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
        </div>
    </div>
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
<?php endif; ?>