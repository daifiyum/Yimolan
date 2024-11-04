<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="sider">
    <div class="ssec">
        <h3>文章分类</h3>
        <ul>
            <?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}">{name}</a> <span>({count})</span></li>'); ?>
        </ul>
    </div>
    <div class="sthird">
        <h3>标签云</h3>
        <ul>
            <?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 20))->to($tags); ?>
            <?php $tagsColor = array(
                'color1',
                'color2',
                'color3',
                'color4',
                'color5',
                'color6'
            );
            ?>
            <?php while ($tags->next()) : ?>
                <li><a class="<?php echo $tagsColor[mt_rand(0, 5)]; ?>" rel="tag" href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
</div> <!--主体结束-->