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
    
                        <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);
                        $year = 0;
                        $mon = 0;
                        $i = 0;
                        $j = 0;
                        $output = '';
                        while ($archives->next()) :
                            $year_tmp = date('Y', $archives->created);
                            $mon_tmp = date('m', $archives->created);
                            if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></div>';
                            if ($year != $year_tmp && $year > 0) $output .= '</ul></div>';
                            if ($mon != $mon_tmp) {
                                $mon = $mon_tmp;
                                $output .= '<div class="item"><span class="panel">' . $year_tmp . ' 年 ' . $mon . ' 月<svg class="icon" aria-hidden="true"><use xlink:href="#icon-xiala-"></use></svg></span><ul class="panel-body">';
                            }
                            $output .= '<li><a href="' . $archives->permalink . '">' . date('m/d：', $archives->created) . $archives->title . '</a>';
                            $output .= '</li>';
                        endwhile;
                        $output .= '</ul></div>';
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