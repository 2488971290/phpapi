<?php
header('Content-Type:application/json; charset=utf-8');
$url = isset($_GET['url']) ? $_GET['url'] : "" ; //需要解析的链接
if (empty($url)) {
    die(
        json_encode(
            array(
            'code' => 201,
            'msg' => '请输入需要解析的APP分享的短视频地址(只支持快手/抖音)'
        ),480)
);
}elseif(strstr($url, 'v.kuaishou.com')){
  $types = "kuaishou";    
}elseif(strstr($url, 'v.douyin.com')){
  $types = "douyin";    
}else{
    die(
    json_encode(
        array(
        'code' => 202,
        'msg' => '请输入正确的解析链接(只支持快手/抖音)'),480)
); 
}
$types($url);
function douyin($url){
$locs = get_headers($url, true);
if(is_array($locs['Location'])) {
    $locs = $locs['Location'][count($locs['Location'])-1];
}else{
    $locs = $locs['Location'];
}
preg_match('/note\/(.*)\?/', $locs, $dyid);
$dyids = (empty($dyid[1])) ? '' : $dyid[1];
$json = json_decode(get_curl('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids='.$dyids),true);
if(!empty($json['item_list'][0]['images'])){
//echo json_encode($json,480);
$images = array();
for($i=0;$i<count($json['item_list'][0]['images']);$i++){
    $none = $json['item_list'][0]['images'][$i]['url_list'][0];
    array_push($images,$none);
}
die(
    json_encode(array(
	'code' => 200,
	'msg' => 'success',
    'title'  => $json['item_list'][0]['desc'],
    'data'  => [
	'count' => count($json['item_list'][0]['images']),
    //'title'  => $json['photo']['caption'],
	'images' => $images,
    ],
    'author_data'  => [
        'avatar' => $json['item_list'][0]['author']['avatar_larger']['url_list'][0],
        'author' => $json['item_list'][0]['author']['nickname'],
    ],
    'text' => [
       'msg' => '抖音图集解析',
       'time'=>'当前解析时间为：'.date('Y-m-d H:i:s',time())]
    ),480)
);
}else{
    die(
        json_encode(array(
        'code' => 400,
        'msg' => 'error',
        'images' => '未解析到图集！',
    ),480)
    );
}
//echo json_encode($arr,480);
}
function kuaishou($url){
$locs = get_headers($url, true);
if(is_array($locs['Location'])) {
    $locs = $locs['Location'][count($locs['Location'])-1];
}else{
    $locs = $locs['Location'];
}
preg_match('/photoId=(.*?)\&/', $locs, $ksvid);
$ksvids = (empty($ksvid[1])) ? '' : $ksvid[1];
$post_data = '{"photoId": "'.$ksvids.'","isLongVideo": false}';
$headers = array(
    'Cookie: did=web_'.md5($locs.time()).';',
    'Referer: '.$locs, 
    'Content-Type: application/json'
);
$json = json_decode(kuaishou_curl('https://v.m.chenzhongtech.com/rest/wd/photo/info',$post_data,$headers),true);
if(!empty($json['atlas'])){
$images = array();
for($i=0;$i<count($json['atlas']['list']);$i++){
    $none = 'https://tx2.a.yximgs.com'.$json['atlas']['list'][$i];
    array_push($images,$none);
}
die(
    json_encode(array(
	'code' => 200,
	'msg' => 'success',
    'data'  => [
	'count' => count($json['atlas']['list']),
    'title'  => $json['photo']['caption'],
	'images' => $images,
    ],
    'author_data'  => [
        'avatar' => $json['photo']['headUrl'],
        'author' => $json['photo']['userName'],
    ],
    'text' => [
       'msg' => '快手图集解析',
       'time'=>'当前解析时间为：'.date('Y-m-d H:i:s',time())]
    ),480)
);
}else{
    die(json_encode(array(
    'code' => 400,
    'msg' => 'error',
    'images' => '未解析到图集！',
),480)
);
}
//echo json_encode($arr,480);
}
function get_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.128 Safari/537.36");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function kuaishou_curl($url,$post_data,$headers){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_NOBODY, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
?>
