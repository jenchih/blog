<?php
namespace app\index\model;
use think\Model;
use think\Db;
class User extends Model
{	
	const PAGE_LIMIT = 10;

	/**
	 * @desc   首页获取最近的
	 * @date   2017-05-10
	 * @author rzliao
	 */
	public static function getLatelyTimeData( $p )
	{
		$data = self::getData($where, $p);
		return ['code' => 200, 'data'=>$data];
	}

	public static function getTpyeData( $type, $p)
	{
		$where['type_id'] = $type;
		$data = self::getData($where, $p);
		return ['code' => 200, 'data'=>$data];
	}

	private static function getData( $where, $p )
	{
		return Db::table('article')->where($where)
			->where('status',1)
			->order('ctime desc')
			->limit(($p-1)*self::PAGE_LIMIT, self::PAGE_LIMIT)
			->select();
	}
}