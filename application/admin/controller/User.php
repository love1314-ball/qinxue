<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
//我是用户控制器

class User extends AdminBase {

    //公共部分
    protected function _initialize() {
        parent::_initialize();
    }
    //用户首页

    public function index() {

        $all = Db::name( 'user' )->select();
        $this->assign( 'all', $all );
        return $this->fetch( 'index' );
    }

    public function add() {
        $up = input( 'up' );
        if ( $up ) {
            $user = Db::name( 'user' )->where( 'id', $up )->find();
            $this->assign( 'user', $user );
            $this->assign( 'id', $up );
        }
        return $this->fetch( 'save' );
    }

    //跟新和插入

    public function edit() {
        $id = input( 'id' );
        //id信息，用这个来判断我们的操作是编辑还是增加
        $data['username'] = input( 'username' );
        //用户信息
        $data['mailbox'] = input( 'mailbox' );
        //邮箱信息
        $data['password'] = input( 'password' );
        //密码信息
        if ( $id ) {
            //更细信息开始
            $data['id'] = $id;
            $update = Db::name( 'user' )->update( $data );
            if ( $update ) {
                $this->success( '更新成功', 'admin/user/index' );
            } else {
                $this->error( '更新失败' );
            }
            //更新结束
        } else {
            //我是插入/插入开始
            $add = Db::name( 'user' )->insert( $data );
            if ( $add ) {
                $this->success( '增加成功', 'admin/user/index' );
            } else {
                $this->error( '增加失败' );
            }
        }
        //插入结束

    }
    
    //删除数据
    public function del() {
        if ( $this->request->isPost() ) {
            if ( $this->delete( 'user', $this->request->param() ) === true ) {
                insert_admin_log( '删除了用户' );
                $this->success( '删除成功' );
            } else {
                $this->error( $this->errorMsg );
            }
        }
    }


}
