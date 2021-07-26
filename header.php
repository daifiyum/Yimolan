<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php $this->archiveTitle(array(
                'category'  =>  _t('分类 %s 下的文章'),
                'search'    =>  _t('包含关键字 %s 的文章'),
                'tag'       =>  _t('标签 %s 下的文章'),
                'author'    =>  _t('%s 发布的文章')
            ), '', ' - '); ?><?php $this->options->title(); ?>
    </title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/agate.min.css'); ?>">
    <link rel="shortcut icon" href="<?php $this->options->themeUrl('assets/images/favicon.ico'); ?>" />
    <link rel="bookmark" href="<?php $this->options->themeUrl('assets/images/favicon.ico'); ?>" />
    <script src="<?php $this->options->themeUrl('assets/js/vue.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/highlight.min.js'); ?>"></script>
    <script>
        hljs.highlightAll();
    </script>
    <?php $this->header(); ?>
</head>

<body>
    <div id="root" class="header">
        <div class="main-head">
            <h2 class="title-head" v-show="titleHead"><a class="blueA animate__animated animate__fadeIn" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a></h2>
            <div class="right-head animate__animated animate__fadeIn" v-show="rightHead">
                <div class="rightHead-left">
                    <ul>
                        <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                        <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                        <?php while ($pages->next()) : ?>
                            <li>
                                <a<?php if ($this->is('page', $pages->slug)) : ?> class="current" <?php endif; ?> href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <form id="search-bt" class="rightHead-right" action="" method="POST">
                    <input type="text" placeholder="搜索些什么~" name="s">
                    <i class="icon-search" onclick="formSubmit()"></i>
                </form>
                <i class="icon-search startMobsearch" @click="mobSearStart"></i>
            </div>

            <form class="sec-search" action="" method="POST" v-show="secSearch">
                <input class="animate__animated animate__zoomIn" type="text" placeholder="搜索些什么~" name="s">
                <i class="icon-clear" @click="delectMobSear"></i>
            </form>
        </div>
        <div class="sec-head animate__animated animate__fadeIn">
            <ul id="mask-father">
                <div class="innerMF">
                    <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while ($pages->next()) : ?>
                        <li>
                            <a<?php if ($this->is('page', $pages->slug)) : ?> class="current" <?php endif; ?> href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                        </li>
                    <?php endwhile; ?>
                </div>
                <div>
                    <p id="timetips"></p> <!--时间问候语-->
                </div>
            </ul>
            <div id="mask-show" class="mask"></div>
        </div>
    </div> <!-- 页眉结束 -->
    <hr class="hrPlus"><!--分割线-->