<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use think\Db;
//我是歌曲类控制器

class Song extends AdminBase {

    //公共部分
    protected function _initialize() {
        parent::_initialize();
    }
    //用户首页

    public function index() {

        $all = Db::name( 'song' )->select();
        $this->assign( 'all', $all );
        return $this->fetch( 'index' );
    }

    public function add() {
        $up = input( 'up' );
        if ( $up ) {
            $all = Db::name( 'song' )->where( 'id', $up )->find();
            $this->assign( 'all', $all );
            $this->assign( 'id', $up );
        }
        return $this->fetch( 'add' );
    }

    //跟新和插入

    public function edit() {
        $id = input( 'id' );
        //id信息，用这个来判断我们的操作是编辑还是增加
        $data['song_name'] = input( 'song_name' );
        //类曲名字
        $data['introduce'] = input( 'introduce' );
        //类曲介绍


        //判断我们的类名是否存在
        $song_name = Db::name('song')->where('song_name',$data['song_name'])->find();
        if ($song_name) {
            $this->error( '类名已存在' );exit;
        }


        if ( $id ) {
            //更细信息开始
            $data['id'] = $id;
            $update = Db::name( 'song' )->update( $data );
            if ( $update ) {
                $this->success( '更新成功', 'admin/Song/index' );
            } else {
                $this->error( '更新失败' );
            }
            //更新结束
        } else {
            //我是插入/插入开始
            $add = Db::name( 'song' )->insert( $data );
            if ( $add ) {
                $this->success( '增加成功', 'admin/Song/index' );
            } else {
                $this->error( '增加失败' );
            }
        }
        //插入结束

    }

    //删除数据

    public function del() {
        $id = input( 'id' );
        $del = Db::name( 'song' )->delete( $id );
        if ( $del ) {
            $this->success( '删除成功', 'admin/Song/index' );
        } else {
            $this->error( '删除失败' );
        }
    }

}
