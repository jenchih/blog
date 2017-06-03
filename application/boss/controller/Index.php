<?php
namespace app\boss\controller;
use think\Db;

class Index extends Base
{
	public function index()
	{
		echo 'hello world';
	}

	public function setType()
	{
		$name = input('name','');
		$sort = input('sort', '');
		$id   = input('id', 0);
		if( empty($name) || !is_numeric($sort) || !is_numeric($id)  ) 
		{
			$this->code    = 400;
			$this->message = '错误数据';
			return $this->returnData();
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
		return $this->returnData();
	}

	public function getTypeList()
	{
		$this->data = Db::table('article_type')->field('id,sorting `desc`,name,ctime time')->order('sorting desc')->select();
		return $this->returnData();
	}

	public function delType()
	{
		$id = input('tid', 0);
		$id = intval($id);
		$this->code    = 400;
		$this->message = '错误数据';
		
		if( $id && Db::table('article_type')->where('id', $id)->delete() )
		{
			$this->code    = 200;
			$this->message = '删除成功';
		}
		return $this->returnData();
	}

	public function setArticle()
	{
		$content = input('content','');
		$typeid  = input('typeid', 0);
		$title   = input('title', '');
		$status  = input('status', '');
		$id      = input('id', 0);

		if( empty($content) || empty($typeid) || empty($title) ) 
		{
			$this->code    = 400;
			$this->message = '数据验证错误';
			return $this->returnData();
		}

		// 添加数据
		$data            = [];
		$data['content'] = $content;
		$data['type_id'] = $typeid;
		$data['title']   = $title;
		$data['utime']   = date('Y-m-d H:i:s');
		$data['status']  = intval($status);

		if( $id )
		{
			$res = Db::table('article')->where('id', $id)->update( $data );
		}
		else
		{
			$data['status']  = 1;
			$data['ctime'] = date('Y-m-d H:i:s');
			$data['aid']   = genUuid();
			$res = Db::table('article')->insert( $data );
		}

		if( !$res )
		{
			$this->code    = 400;
			$this->message = '保存数据失败';
		}
		return $this->returnData();
	}

	public function getArticleByid()
	{
		$id = input('id','');
		if( $data = Db::table('article')->find( $id ) )
		{
			$this->data = $data;
		}
		else
		{
			$this->code    = 404;
			$this->message = 'error';
		}
		return $this->returnData();
	}

	public function getArticleList()
	{
		$p   = input('p', 1);
		$aid = input('aid','');
		$page_limit = 10;
		$where = [];
		if( !empty($aid) ) $where['aid'] = ['like',"%$aid%"];
		$data['list'] =  Db::table('article a')->field('a.id,a.aid,a.type_id,a.title,a.status,a.ctime,a.utime,t.name')
								->join('article_type t','a.type_id = t.id')
								->where($where)
								->limit(($p-1)*$page_limit, $page_limit)
								->select();
		$data['total'] = Db::table('article a')->field('a.id,a.aid,a.type_id,a.title,a.status,a.ctime,a.utime,t.name')
								->join('article_type t','a.type_id = t.id')
								->where($where)
								->count();
		$this->data = $data;
		return $this->returnData();
	}

	public function articleDel()
	{
		$id     = input('id','');
		$status = input('status','');
		$id     = intval($id);
		$status = intval($status);
		$this->message = Db::table('article')->where('id', $id)->update(['status'=>$status])?'修改成功':'更新失败';
		return $this->returnData();
	}

	public function editpwd()
	{
		$name   = input('name');
		$oldpwd = input('oldpwd');
		$newpwd = input('newpwd');

		$passHashModel = new \app\boss\model\User;

		$dbPwd = Db::table('admin')->where('username', $name)->value('password');
		if( $passHashModel->check_password($dbPwd, config('pwd_cfg').$oldpwd)   )
		{
			$data = [];
			$data['password'] = $passHashModel->hash( config('pwd_cfg').$newpwd );
			Db::table('admin')->where('username', $name)->update($data);
		}
		else
		{
			$this->code = '400';
			$this->message = '密码错误';
		}
		return $this->returnData();
	}

	public function getSystemConfig()
	{
		$this->data = Db::table('system_config')->select();
		return $this->returnData();
	}

	public function updateConfig()
	{
		$id    = input('id', 0);
		$name  = input('name','');
		$value = input('value','');
		if( empty($id) || empty($name) || empty($value) )
		{
			$this->code    = 400;
			$this->message = '数据验证错误';
			return $this->returnData();
		}

		if( Db::table('system_config')->find( $id ) )
		{
			$data['name']  = $name;
			$data['value'] = $value;
			$data['utime'] = date('Y-m-d H:i:s');
			if( !Db::table('system_config')->where('id', $id)->update( $data ) )
			{
				$this->code    = 400;
				$this->message = '未知错误';
			}
		}
		else
		{
			$this->code    = 400;
			$this->message = '未知错误';
		}
		return $this->returnData();
	}
}
