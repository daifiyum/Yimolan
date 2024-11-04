<?php
$date = mt_rand(0, 7); //支持返回七天内得图片
$json_content = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=' . $date . '&n=1&mkt=zh-CN'); //读取必应api，获得相应数据
$json_content = json_decode($json_content, true);
$imgurl = 'http://cn.bing.com' . $json_content['images'][0]['url']; //组合图片url
header("Location: $imgurl");
// echo($imgurl);

?>
