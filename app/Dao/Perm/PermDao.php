<?php

namespace App\Dao\Perm;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
/**
 * 角色权限类数据库操作
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年11月11日 下午5:19:04
 * @version 1.0
 */
class PermDao{
	/**
	 * 获取全部角色对应功能（路由）权限
	 * @return array 权限数组
	 */
	public function allPerm(){
		$allPermFuncByRid = array();	//所有权限功能对应角色集合
		$allPermFieldByRid = array();	//所有权限字段集合（根据角色分组）
		$allPermFunc = array();
		$roleObj = DB::table('perm_role')->get();//角色表
		foreach($roleObj as $v_r){
			//权限功能
			$i = 0;
			$rId = $v_r->id;		//角色id
			$role2funcObj = DB::table('role2function')		//角色与权限功能关联对象
				->join('perm_function', 'role2function.pfId', '=', 'perm_function.id')
				->select('perm_function.*')
				->where('role2function.rId', $rId)->get();
			foreach($role2funcObj as $v_r2f){
				$allPermFuncByRid[$rId][] = $v_r2f->id;
			}
			
			//权限字段
			$role2fieldObj = DB::table('role2field')		//角色与权限字段关联对象
				->join('perm_field', 'role2field.pfId', '=', 'perm_field.id')
				->select('perm_field.*')
				->where('role2field.rId', $rId)
				->get();
			foreach($role2fieldObj as $v_r2f){
				$allPermFieldByRid[$rId][] = $v_r2f->id;
			}
		}
		Cache::forever('allPermFuncByRid', $allPermFuncByRid);
		Cache::forever('allPermFieldByRid', $allPermFieldByRid);
		$permFunctionObj = DB::table('perm_function')->get();//权限功能表
		foreach($permFunctionObj as $v_pf){
			$allPermFunc[] = $v_pf->id;
		}
		Cache::forever('allPermFunc', $allPermFunc);
		return $allPermFuncByRid;
	}
	
	/**
	 * 获取角色拥有数据权限
	 */
	public function getPermValueByRid($table_name, $relation_table_name, $relation_id, $rId){
		$relationObject = DB::table($relation_table_name)
			->where($relation_table_name.'.rId', $rId)
			->get();
		$relation_id_arr = array();
		foreach($relationObject as $v){
			$relation_id_arr[] = $v->$relation_id;
		}
		$object = DB::table($table_name)
			->whereIn('id', $relation_id_arr);
		return $object;
	}
}
