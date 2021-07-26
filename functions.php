<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{

  $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL, _t('ICP备案号'), _t('在这填写ICP备案号'));
  $form->addInput($beian);


  $indeximg = new
    Typecho_Widget_Helper_Form_Element_Checkbox(
      'indeximg',
      array('open_indeximg' => _t('首页文章列表预览图')),
      array('open_indeximg'),
      _t('文章预览图')
    );
  $form->addInput($indeximg->multiMode());
}


function themeInit($archive)
{
  Helper::options()->commentsMaxNestingLevels = 999; //设置评论回复的层数，typecho官方限制为7层
}


//  统计文章阅读量
function getPostViews($archive)
{
  $cid = $archive->cid;
  $db = Typecho_Db::get();
  $prefix = $db->getPrefix();
  if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
    $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
    return 0;
  }
  $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
  if ($archive->is('single')) {
    $views = Typecho_Cookie::get('extend_contents_views');
    if (empty($views)) {
      $views = array();
    } else {
      $views = explode(',', $views);
    }
    if (!in_array($cid, $views)) {
      //  如果cookie不存在才会加1
      $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
      array_push($views, $cid);
      $views = implode(',', $views);
      Typecho_Cookie::set('extend_contents_views', $views);  //  记录查看cookie
    }
  }
  return $row['views'];
}

//获取文章头图
function getPostImg($archive)
{

  $img = array();
  preg_match_all("/<img.*?src=\"(.*?)\".*?\/?>/i", $archive->content, $img);
  if (count($img) > 0 && count($img[0]) > 0) {
    $img_url = $img[1][0];
    return $img_url;
  } else {
    return 'none';
  }
}

//文章文字统计
function art_count($cid)
{

  $db = Typecho_Db::get();

  $rs = $db->fetchRow($db->select('table.contents.text')->from('table.contents')->where('table.contents.cid=?', $cid)->order('table.contents.cid', Typecho_Db::SORT_ASC)->limit(1));

  $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']);

  return mb_strlen($text, 'UTF-8');
}

//简洁时间
function timesince($older_date, $comment_date = false)
{
  if ($older_date == "no") {
    return;
  }
  $chunks = array(
    array(31536000, '年'),
    array(2592000, '个月'),
    array(604800, '周'),
    array(86400, '天'),
    array(3600, '小时'),
    array(60, '分'),
    array(1, '秒'),
  );
  $newer_date = time();
  $since = abs($newer_date - $older_date);

  for ($i = 0, $j = count($chunks); $i < $j; $i++) {
    $seconds = $chunks[$i][0];
    $name = $chunks[$i][1];
    if (($count = floor($since / $seconds)) != 0) break;
  }
  $output = $count . $name . '前';

  echo $output;
};

//评论@
function get_comment_at($coid)
{
  $db   = Typecho_Db::get();
  $prow = $db->fetchRow($db->select('parent')->from('table.comments')
    ->where('coid = ? AND status = ?', $coid, 'approved'));
  $parent = $prow['parent'];
  if ($parent != "0") {
    $arow = $db->fetchRow($db->select('author')->from('table.comments')
      ->where('coid = ? AND status = ?', $parent, 'approved'));
    $author = $arow['author'];
    if ($author) {
      $href   = '<a class="relation" href="#comment-' . $parent . '">@' . $author . '</a>';
      echo $href;
    } else {
      echo '';
    }
  } else {
    echo '';
  }
};
