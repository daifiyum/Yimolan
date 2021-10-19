<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{

  $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL, _t('ICP备案号'), _t('在这填写ICP备案号'));
  $form->addInput($beian);
  
  
  $biimg = new
    Typecho_Widget_Helper_Form_Element_Checkbox(
      'biimg',
      array('open_biimg' => _t('首页必应美图')),
      array('open_biimg'),
      _t('必应美图')
    );
  $form->addInput($biimg->multiMode());
  
  
  $dimg = new Typecho_Widget_Helper_Form_Element_Text('dimg', NULL, NULL, _t('首页背景图'), _t('在这填写图片的url，当自定义背景图时请务必关闭“必应美图”'));
  $form->addInput($dimg);
  
  
  $headMusic = new
    Typecho_Widget_Helper_Form_Element_Checkbox(
      'headMusic',
      array('open_headMusic' => _t('导航栏音乐显示')),
      array('open_headMusic'),
      _t('导航栏音乐')
    );
  $form->addInput($headMusic->multiMode());
  
  
  $audiosrc = new Typecho_Widget_Helper_Form_Element_Text('audiosrc', NULL, NULL, _t('音乐'), _t('在这填写音乐的url'));
  $form->addInput($audiosrc);


  $indeximg = new
    Typecho_Widget_Helper_Form_Element_Checkbox(
      'indeximg',
      array('open_indeximg' => _t('首页文章列表预览图')),
      array('open_indeximg'),
      _t('文章预览图')
    );
  $form->addInput($indeximg->multiMode());
  
  
  $gpt = new Typecho_Widget_Helper_Form_Element_Text('gpt', NULL, NULL, _t('文章右上角图片'), _t('在这填写图片的url'));
  $form->addInput($gpt);
  
  
  $gptext = new
    Typecho_Widget_Helper_Form_Element_Checkbox(
      'gptext',
      array('open_gptext' => _t('文章问候语')),
      array('open_gptext'),
      _t('开关问候语')
    );
  $form->addInput($gptext->multiMode());
  
  $gptexts = new Typecho_Widget_Helper_Form_Element_Text('gptexts', NULL, NULL, _t('问候语文字'), _t('在这自定义问候语'));
  $form->addInput($gptexts);
  
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


function agreeNum($cid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    
    //  判断点赞数量字段是否存在
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }

    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  获取记录点赞的 Cookie
    $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断记录点赞的 Cookie 是否存在
    if (empty($AgreeRecording)) {
        //  如果不存在就写入 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array(0)));
    }

    //  返回
    return array(
        //  点赞数量
        'agree' => $agree['agree'],
        //  文章是否点赞过
        'recording' => in_array($cid, json_decode(Typecho_Cookie::get('typechoAgreeRecording')))?true:false
    );
};


function agree($cid) {
    $db = Typecho_Db::get();
    //  根据文章的 `cid` 查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));

    //  获取点赞记录的 Cookie
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断 Cookie 是否存在
    if (empty($agreeRecording)) {
        //  如果 cookie 不存在就创建 cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array($cid)));
    }else {
        //  把 Cookie 的 JSON 字符串转换为 PHP 对象
        $agreeRecording = json_decode($agreeRecording);
        //  判断文章是否点赞过
        if (in_array($cid, $agreeRecording)) {
            //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
            return $agree['agree'];
        }
        //  添加点赞文章的 cid
        array_push($agreeRecording, $cid);
        //  保存 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
    }

    //  更新点赞字段，让点赞字段 +1
    $db->query($db->update('table.contents')->rows(array('agree' => (int)$agree['agree'] + 1))->where('cid = ?', $cid));
    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  返回点赞数量
    return $agree['agree'];
};