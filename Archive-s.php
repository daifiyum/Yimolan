<?php

/**
 * 归档
 *
 * @package custom
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="postMain">
    <article class="postText">
        <?php
        $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);
        $year = 0;
        $mon = 0;
        $i = 0;
        $j = 0;
        $output = '<div id="archives">';
        while ($archives->next()) :
            $year_tmp = date('Y', $archives->created);
            $mon_tmp = date('m', $archives->created);
            $y = $year;
            $m = $mon;
            if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
            if ($year != $year_tmp && $year > 0) $output .= '</ul>';
            if ($year != $year_tmp) {
                $year = $year_tmp;
                $output .= '<h3 class="">' . $year . ' 年</h3><ul class="">'; //输出年份   
            }
            if ($mon != $mon_tmp) {
                $mon = $mon_tmp;
                $output .= '<li><span class="">' . $mon . ' 月</span><ul class="">'; //输出月份   
            }
            $output .= '<li>' . date('d日: ', $archives->created) . '<a href="' . $archives->permalink . '">' . $archives->title . '</a></li>'; //输出文章日期和标题   
        endwhile;
        $output .= '</ul></li></ul></div>';
        echo $output;
        ?>
    </article>
    <div class="siderPost">
        <!--<div class="pfirst">-->
        <!--    <h3>关于作者</h3>-->
        <!--    <ul>-->
        <!--        <li><a href="#"><?php $this->author(); ?></a></li>-->
        <!--    </ul>-->
        <!--</div>-->
        <div class="psec">
            <h3>年月归档</h3>
            <ul>
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y年m月')->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
            </ul>
        </div>
    </div>
</div>
<?php $this->need('footer.php'); ?>