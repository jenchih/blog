<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @desc   将二维数组中某个值提出来，当成新数组中的key，旧数组中剩余部分为值
 *         $arr = [
 *         		['name'=>1111,'hosts'=>222222],
 *         		['name'=>22222,'hosts'=>333],
 *         		['name'=>4444,'hosts'=>5555],
 *         ];
 *         $xxx = arrayColunmToValue( $arr, 'name' )
 *         =>    $xxx = [
 *         			['1111'=>['hosts'=>'22222']],
 *         			['22222'=>['hosts'=>'333']],
 *         			['4444'=>['hosts'=>'5555']],
 *         		];
 * @date   2016-12-01
 * @author rzliao
 */
function arrMakeVlueToKey( $arr, $name )
{
	if( !is_array($arr) || !count($arr)>0 ) return $arr;
	$result = [];
	foreach( $arr as $value )
	{
		$key = $value[$name];
		unset($value[$name]);
		$result[$key] = $value;
	}
	return $result;
}

/**
 * @desc   生成带小数点的随机数
 * @date   2016-12-02
 * @author rzliao
 * @param  integer    $min    [最小值]
 * @param  integer    $max    [最大值]
 * @param  integer    $count  [保留小数点数量]
 */
function randomFloat($min = 0, $max = 1, $count = 10) {
	return round($min + mt_rand() / mt_getrandmax() * ($max - $min), $count);
}

/**
 * @desc   随机返回数组中某个值
 * @date   2016-12-02
 * @author rzliao
 */
function arrayRandToValue( $array )
{
	if( !is_array($array) || count($array) === 0 ) return '';
	return $array[array_rand($array)];
}

/**
 * @desc   根据前端返回的日期，做月份分表查询处理
 * @date   2016-12-13
 * @author rzliao
 * @param  string     $start [description]
 * @param  string     $end   [description]
 * @return array  按照年月返回值
 *         2014-01 ~ 2016-12
 *         [
 *         		'201401',
 *         		'201402',
 *         		·········
 *         		'201611',
 *         		'201612',
 *         ]
 */
function getTimeDiff( $start, $end )
{
	$return = [];
	$sy     = date('Y',strtotime($start));
	$ey     = date('Y',strtotime($end));
	$sm     = date('m',strtotime($start));
	$em     = date('m',strtotime($end));
	if( $sy > $ey ) list($sy, $ey) = [ $ey, $sy ];
	$yList = range($sy, $ey);
	foreach( $yList as $key => $y )
	{
		if( $key == 0 )
		{
			while ( $sm <= 12 )
			{
				$sm = sprintf('%02d',$sm);
				$return[] = $y.$sm;
				$sm++;
			}
		}
		elseif( $key == (count($yList)-1) )
		{
			while ( $em >= 1 )
			{
				$em = sprintf('%02d',$em);
				$return[] = $y.$em;
				$em--;
			}
		}
		else
		{
			$all = 12;
			while ( $all >= 1 )
			{
				$all = sprintf('%02d',$all);
				$return[] = $y.$all;
				$all--;
			}
		}
	}
	sort($return);
	return $return;
}

/**
 * @desc   根据时间戳返回过去时间多久的描述
 * @author rzliao
 * @date   2015-11-28
 * @param  int  $time 时间戳
 */
function from_time($time){
	$way = time() - $time;
		$r = '';
	if($way < 60){
		$r = '刚刚';
	}elseif($way >= 60 && $way <3600){
		$r = floor($way/60).'分钟前';
	}elseif($way >=3600 && $way <86400){
		$r = floor($way/3600).'小时前';
	}elseif($way >=86400 && $way <2592000){
		$r = floor($way/86400).'天前';
	}elseif($way >=2592000 && $way <15552000){
		$r = floor($way/2592000).'个月前';
	}
	return $r;
}

/**
 * @desc   随机生成字符串
 * @author rzliao
 * @date   2015-11-28
 * @param  integer    $length [需要的字符长度]
 * @return string
 */
function generateRandomString($length = 10) { 
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$randomString = ''; 
	for ($i = 0; $i < $length; $i++) { 
		$randomString .= $characters[rand(0, strlen($characters) - 1)]; 
	} 
	return $randomString; 
}


/**
 * @desc   获取文件的后缀名
 * @author rzliao
 * @date   2015-11-28
 * @param  string     $fileName [文件名可包含路径]
 */
function getFileExt( $fileName = ''){

	return substr( strrchr( $fileName , '.'), 1);
}

/**
 * @desc   获取文件大小后转化成方便读的文字格式
 * @author rzliao
 * @date   2016-06-28
 * @param  integer    $size 
 * @return string
 */
function formatSize($size) {
	$sizes = [" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB"];
	return $size == 0 ? 'n/a' : round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i];
}

/**
 * @desc   获取更精确的uuid
 * @date   2017-04-06
 * @author rzliao
 */
function genUuid(){
	return md5(uniqid(md5(microtime(true)),true));
}

/**
* 加密字符串
* @param string $str 字符串
* @param string $key 加密key
* @param integer $expire 有效期（秒）     
* @return string
*/
function encrypt($data, $key, $expire = 0) {

	$expire = sprintf('%010d', $expire ? $expire + time():0);
	$key  = md5($key);
	$data = base64_encode($expire.$data);
	$x    = 0;
	$len  = strlen($data);
	$l    = strlen($key);
	$char = $str    =   '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	for ($i = 0; $i < $len; $i++) {
		$str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
	}
	return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
* 解密字符串
* @param string $str 字符串
* @param string $key 加密key
* @return string
*/
function decrypt($data, $key) {
	$key    = md5($key);
	$data   = str_replace(array('-','_'),array('+','/'),$data);
	$mod4   = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	$data   = base64_decode($data);

	$x      = 0;
	$len    = strlen($data);
	$l      = strlen($key);
	$char   = $str = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		}else{
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	$data   = base64_decode($str);
	$expire = substr($data,0,10);
	if($expire > 0 && $expire < time()) {
		return '';
	}
	$data   = substr($data,10);
	return $data;
}