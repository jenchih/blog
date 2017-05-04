<?php
namespace app\index\model;
use think\Model;
use think\Db;
class User extends Model
{
	private $arr = ['leslie','jenchih','rzliao','Leslie Cheung'];
	public function getUserList( $id = 0 )
	{
		return $arr[$id];
	}
}