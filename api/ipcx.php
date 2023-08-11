<?
//作者:青木倪
//请求:支持GET/POST两种请求方式
//参数:
//ip 填写该参数，获取指定ip的信息
//type 可选填txt、json 来选择返回内容格式
//lx 可选择 留空、city 前者获取访问ip，后者获取访问来源地址
//说明:抓取来源站长工具，稳定快速，原站不倒，永久免费使用(如有特殊情况，不敢保证)
error_reporting(0);
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
// 获取客户端IP
if($_SERVER['REQUEST_METHOD']=='GET'){
    $ip=$_GET['ip'];$type=$_GET['type'];$lx=$_GET['lx'];
}else if($_SERVER['REQUEST_METHOD']=='POST'){
    $ip=$_POST['ip'];$type=$_POST['type'];$lx=$_POST['lx'];
}
if($ip==""){
    $ip = getip();
}
if($type=="json"){
  if($lx=="city"){
     echo getcity($ip,$type);  
  }else{
    echo '{"code":200,"ip":"'.getip().'","msg":"获取IP成功！"}';   
  }
}else{
  if($lx=="city"){
      echo getcity($ip,$type); 
  }else{
      echo getip();
  }
}

function getIP()
{
    static $realip;
    	//定义常量
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
    return $realip;
}
function getcity($ip,$type){
$json = file_get_contents("https://www.ipshudi.com/$ip.htm"); //调用的站长工具
$b ='<td class="th">归属地</td>
<td>
<span>';
$c ='</span>';
$citydata = GetBetween($json,$b,$c);
$city_arr=explode(" ",$citydata);
$bb ='<td class="th">运营商</td><td><span>';
$cc ='</span>';
$operator_data = GetBetween($json,$bb,$cc);
     $country = $city_arr[0];     //国家
     $province = $city_arr[1];    // 省份/自治区/直辖市（少数为空）
     $city = $city_arr[2];        // 地级市（部份为空）
     $operator = $operator_data;   // 运营商
     $homeurl = $_SERVER['HTTP_HOST'];
     if($city==""){$city="未知";}     
     if($type=="json"){
      $data_json = array("code"=>200,
                   "success"=>true,
                   "msg"=>"获取成功！",
                   "ip"=>$ip,
                   "data"=>[
                       "country"=>$country,
                       "province"=>$province,
                       "city"=>$city,
                       "operator"=>$operator
                   ]
                );     
       return json_encode($data_json, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
     }else{
        return $country.".".$province.".".$city; 
     }
    
    }
function GetBetween($content,$start,$end){
$r = explode($start, $content);
if (isset($r[1])){
$r = explode($end, $r[1]);
return $r[0];
}
return '';
}
function echo_json($json){
    return json_encode($json, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
}
?>
