<?php
/*
蓝猫
2023/07/25
*/
$timestamp = time();
$xml = '
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <OpenUDID>[OpenUDID]</OpenUDID>
    <udid>[udid]</udid>
    <ct>11</ct>
    <cv>12050008</cv>
    <v>12050008</v>
    <chid>73387</chid>
    <os_ver>12</os_ver>
    <aid>[aid]</aid>
    <phonetype>[phonetype]</phonetype>
    <devicelevel>50</devicelevel>
    <newdevicelevel>20</newdevicelevel>
    <deviceScore>464.0</deviceScore>
    <QIMEI36>[QIMEI36]</QIMEI36>
    <oaid>[oaid]</oaid>
    <taid>[taid]</taid>
    <tmeAppID>qqmusic</tmeAppID>
    <tid>[tid]</tid>
    <modeSwitch>7</modeSwitch>
    <teenMode>0</teenMode>
    <M-Value>[M-Value]</M-Value>
    <ui_mode>1</ui_mode>
    <nettype>1030</nettype>
    <wid>[uid]</wid>
    <rom>XiaoMi/MIUI/V130</rom>
    <uid>[uid]</uid>
    <sid>[sid]</sid>
    <OpenUDID2>[OpenUDID2]</OpenUDID2>
    <tmeLoginType>2</tmeLoginType>
    <tmeLoginMethod>2</tmeLoginMethod>
    <fPersonality>0</fPersonality>
    <qq>[qq]</qq>
    <authst>'.$timestamp.'</authst>
    <psrf_qqopenid>[psrf_qqopenid]</psrf_qqopenid>
    <psrf_access_token_expiresAt>[time]</psrf_access_token_expiresAt>
    <v4ip>[v4ip]</v4ip>
    <psrf_qqaccess_token>[psrf_qqaccess_token]</psrf_qqaccess_token>
    <hotfix>200000000</hotfix>
    <traceid>[traceid]</traceid>
    <cid>228</cid>
    <item cmd="1" optime="[optime]" QQ="[qq]" time="[time]" timekey="[timekey]" songid="265294548" singerid="967661" uid="[uid]" nettype="1030" os="12" model="[phonetype]" version="12.5.0.8" songtype="1" playtype="4" from="9,30,330," dts="0" openstore="0" crytype="5" paytype="3" abt="3123_3123001" ext="eyJzZWFyY2hfZXh0IjpbIntcInJlZ2lvbl9pZFwiOiAwfSJdfQ==" searchid="337419598417195503," search_ext="eyJyZWdpb25faWQiOiAwfQ==" tjreport="" desktoplyric="0" playdevice="0" playlist_mode="0" outdev="0" url="26" playmode="1" repeat_times="0" string25="normal" string26="n" string29="0" cdn="127.0.0.1:17901" cdnip="127.0.0.1" hasFirstBuffer="3" hijackflag="0" filetype="4" sbTimePoint="" err="0" size="8066051" retry="0" time2="301" issoftdecode="1" component_type="1" string19="" string30="{&quot;firstBufferActions&quot;:{&quot;0&quot;:[0],&quot;3&quot;:[148],&quot;4&quot;:[163],&quot;7&quot;:[381],&quot;1&quot;:[120],&quot;2&quot;:[120],&quot;5&quot;:[245],&quot;6&quot;:[257]},&quot;secondBufferTimes&quot;:[]}" bandwidth_policy="0" secondCacheCount="0" wait_time="649" player_retry="0" audiotime="201013" co_singer="许嵩" vkey="[vkey]" play_duration_mi="201322" errcode="" play_speed="1.0" vip_level="69632" audio_effect="0:0" mode_string="eyJzdXBlcl9yZXNvbHV0aW9uIjowLCJzb3VuZF9iYWxhbmNlIjowLCJwbGF5X3RpbWVfcmV2IjowLCJ1c2Jfb3V0cHV0X3R5cGUiOjAsImFsYyI6MCwib3V0cHV0X3Nka190eXBlIjowfQ==" string27="eyJzY3JlZW5fb24iOjEsImFwcF9pbiI6MSwiYXBwX3RpbWUiOjI5OTgsInBsYXlwYWdlX3RpbWUiOjE4MH0=" fversion="0"/>
</root>
';

$url = 'https://stat.y.qq.com/android/fcgi-bin/imusic_tj';
$ua = 'QQMusic 12030508(android 12)';
$time = '2999';
$qq = $_GET['qq'];
$timekey = strtoupper(md5($timestamp.$time.$qq.'gk2$Lh-&l4#!4iow'));
$OpenUDID = getrandom(32);
$udid = getrandom(32);
$aid = getrandom(16);
$phonetype = generateRandomAndroidModel();
$QIMEI36 = getrandom(32);
$oaid = getrandom(50);
$taid = getrandom(88);
$tid = generateRandomNumber(19);
$M_Value = base64_encode($tid);
$uid = generateRandomNumber(10);
$sid = generateTimestamp().$uid;
$OpenUDID2 = getrandom(32);
$psrf_qqopenid = getrandom(32);
$v4ip = generateRandomIPv4();
$psrf_qqaccess_token = getrandom(32);
$traceid = '11_'.generateRandomNumber(11).'_'.$timestamp;
$vkey = getrandom(32);


$replacements = array(
    '[vkey]' => $vkey,
    '[traceid]' => $traceid,
    '[psrf_qqaccess_token]' => $psrf_qqaccess_token,
    '[v4ip]' => $v4ip,
    '[psrf_qqopenid]' => $psrf_qqopenid,
    '[sid]' => $sid,
    '[uid]' => $uid,
    '[wid]' => $uid,
    '[tid]' => $tid,
    '[M-Value]' => $M_Value,
    '[oaid]' => $oaid,
    '[taid]' => $taid,
    '[qq]' => $qq,
    '[optime]' => $timestamp,
    '[timekey]' => $timekey,
    '[OpenUDID]' => $OpenUDID,
    '[OpenUDID2]' => $OpenUDID2,
    '[udid]' => $udid,
    '[aid]' => $aid,
    '[phonetype]' => $phonetype,
    '[QIMEI36]' => $QIMEI36,
    '[time]' => $time
);

$xml = strtr($xml, $replacements);

$gzip_data = gzencode($xml);

$iterations = 2;
for ($i = 0; $i < $iterations; $i++) {
    $th = posturl($url, $gzip_data);
}


if (strpos($th, "R044000U") !== true) {
   $formattedNumber = sprintf("%.2f", ($time * $iterations) / 60);
   $array = array(
    'msg' => $qq . ' 操作成功，增加' . $formattedNumber . 'min',
    'time' => time()
    );
} else {
    $array = array(
    'msg' => $qq.' 操作失败，请稍后再试。',
    'time' => time()
    );
}

echo $v = json_encode($array,320);


function generateRandomIPv4() {
    $ip = long2ip(mt_rand(ip2long("1.0.0.0"), ip2long("223.255.255.255")));
    while (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        $ip = long2ip(mt_rand(ip2long("1.0.0.0"), ip2long("223.255.255.255")));
    }
    return $ip;
}

function getrandom($len = 12) {
    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $strlen = strlen($str);
    $randstr = "";
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    return $randstr;
}

function generateRandomAndroidModel() {
    $brands = ['Samsung', 'Xiaomi', 'Huawei', 'OPPO', 'Vivo', 'OnePlus', 'Lenovo', 'ZTE', 'Meizu'];
    $randomBrandIndex = array_rand($brands);
    $randomBrand = $brands[$randomBrandIndex];
    $modelNumber = rand(1, 9999);
    $modelName = ['Galaxy', 'Mi', 'P', 'Find', 'NEX', 'Mate', 'S', 'Y', 'K'];
    $randomModelNameIndex = array_rand($modelName);
    $randomModelName = $modelName[$randomModelNameIndex].$modelNumber;
    $randomAndroidModel = $randomBrand.' '.$randomModelName;
    return $randomAndroidModel;
}

function generateRandomNumber($length) {
    $result = '';

    for ($i = 0; $i < $length; $i++) {
        $result .= rand(0, 9);
    }

    return $result;
}


function generateTimestamp($length = 14) {
    $date = date('YmdHis');
    $time = time();
    $timestamp = $date.substr($time, -$length);
    return $timestamp;
}

function generateString() {
    $date = date('YmdHis');
    $time = time();

    $str = '22_10001_1_0_0_0_'.substr($time, -3).'_'.substr($date, 2, 6).'-0';
    return $str;
}

function posturl($url, $data) {
    $content_length = strlen($data);
	$curl = curl_init();
	$headers = array(
		        'User-Agent:QQMusic 12030508(android 12)',
		        'Content-Type: application/x-www-form-urlencoded',
		        'Connection: Keep-Alive',
		        'Content-Encoding: gzip',
		        'Content-Length: '.$content_length
		    );
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLINFO_HEADER_OUT, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 5);
		//输出返回页的header
	curl_setopt($curl, CURLOPT_HEADER, 1);
	
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}
