<?php
namespace app\boss\controller;
use think\Db;

class Index extends Base
{
	public function index()
	{
	}

	public function setType()
	{
		$name = input('name','');
		$sort = input('sort', '');
		$id   = input('id', 0);
		if( empty($name) || $sort == '' ) 
		{
			$this->code    = 400;
			$this->message = 'error datas';
			$this->returnData();
		}

		$data            = [];
		$data['name']    = $name;
		$data['sorting'] = intval($sort);

		if( $id )
		{
			$res = Db::table('article_type')->where('id', $id)->update( $data );
		}
		else
		{
			$data['ctime']   = date('Y-m-d H:i:s');
			$res = Db::table('article_type')->insert( $data );
		}

		if( !$res )
		{
			$this->code    = 400;
			$this->message = '保存数据失败';
		}
		$this->returnData();
	}

	public function getTypeList()
	{
		$this->data = Db::table('article_type')->select();
		$this->returnData();
	}

	public function setArticle()
	{
		$content = input('content','');
		$typeid  = input('typeid', 0);
		$id      = input('id', 0);

		if( empty($content) || empty($typeid) ) 
		{
			$this->code    = 400;
			$this->message = '数据验证错误';
			$this->returnData();
		}

		// 添加数据
		$data            = [];
		$data['content'] = $content;
		$data['type_id'] = $typeid;
		$data['status']  = 1;
		$data['utime']   = date('Y-m-d H:i:s');

		if( $id )
		{
			$res = Db::table('article')->where('id', $id)->update( $data );
		}
		else
		{
			$data['ctime']   = date('Y-m-d H:i:s');
			$res = Db::table('article')->insert( $data );
		}

		if( !$res )
		{
			$this->code    = 400;
			$this->message = '保存数据失败';
		}
		$this->returnData();
	}
}
