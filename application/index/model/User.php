<?php
namespace app\index\model;
use think\Model;
use think\Db;
class User
{	
	const PAGE_LIMIT = 10;

	/**
	 * @desc   首页获取最近的
	 * @date   2017-05-10
	 * @author rzliao
	 */
	public static function user_getLatelyTimeData( $p = 1 )
	{
		return self::getData([], $p);
	}

	public static function user_getTpyeData( $type, $p = 1)
	{
		$type = intval($type);
		if( $type == 0 ) return [];
		$where['type_id'] = $type;
		return self::getData($where, $p);
	}

	public static function user_getTypeList()
	{
		return Db::table('article_type')->order('sorting desc')->select();
	}

	public static function user_config( $name = '' )
	{
		if( empty($name) ) return [];
		return Db::table('system_config')->where('name',$name)->find();
	}

	private static function getData( $where, $p )
	{
		$data = Db::table('article')->where($where)
					->where('status',1)
					->order('ctime desc')
					->limit(($p-1)*self::PAGE_LIMIT, self::PAGE_LIMIT)
					->select();
		$total = Db::table('article')->where($where)
					->where('status',1)
					->count();
		return ['data'=>$data,'total'=>$total];
	}

	public static function user_getDetail( $aid = '' )
	{
		return  Db::table('article')->where('aid', $aid)->find();
	}
}