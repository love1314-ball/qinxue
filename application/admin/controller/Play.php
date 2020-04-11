<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use think\Db;
use think\Request;
//我是戏曲列表控制器

class Play extends AdminBase {

    //公共部分
    protected function _initialize() {
        parent::_initialize();
    }
    //用户首页

    public function index() {

        $all = Db::name( 'play' )->select();
        $this->assign( 'all', $all );
        return $this->fetch( 'index' );
    }

    public function add() {
        $up = input( 'up' );
        if ( $up ) {
            $all = Db::name( 'play' )->where( 'id', $up )->find();
            //所选中的戏曲信息
            $song = Db::name( 'song' )->where( 'id', $all['song_id'] )->find();
            $this->assign( 'song', $song );
            $this->assign( 'all', $all );
            $this->assign( 'id', $up );
        }
        $date = Db::name( 'song' )->select();
        $this->assign( 'date', $date );
        return $this->fetch( 'add' );
    }

    //跟新和插入

    public function edit() {
        $id = input( 'id' );
        //id信息，用这个来判断我们的操作是编辑还是增加
        $data['song_id'] = input( 'song_id' );
        //获取戏曲类id
        $data['play_name'] = input( 'play_name' );
        //戏曲名字
        $data['particular'] = input( 'particular' );
        //文字描述

        // 图片上传
        $picture = '';
        if ( $_FILES['picture']['name'] == '' ) {
            $data['picture'] = input( 'worn_picture' );
        } else {
            $file = request()->file( 'picture' );
            //tp5写法获取图片信息
            $info = $file->move( ROOT_PATH . '/public/static/upimg/' );
            if ( $info ) {
                $Nmae = $info->getSaveName();
                //获取临时名字
                $site = str_replace( '\\', '/', $Nmae );
                $data['picture'] = '/static/upimg/' . $site;
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

        //视频上传
        $video = '';
        if ( $_FILES['video']['name'] == '' ) {
            //未上传图片默认图片
            $data['video'] = input( 'worn_video' );
        } else {
            $files = request()->file( 'video' );
            //tp5写法获取图片信息
            $infos = $files->move( ROOT_PATH . '/public/static/upimg/' );
            if ( $infos ) {
                $Nmaes = $infos->getSaveName();
                //获取临时名字
                $sites = str_replace( '\\', '/', $Nmaes );
                $data['video'] = '/static/upimg/' . $sites;
            } else {
                // 上传失败获取错误信息
                echo $files->getError();
            }
        }

        if ( $id ) {
            //更细信息开始
            $data['id'] = $id;
            $update = Db::name( 'play' )->update( $data );
            if ( $update ) {
                $this->success( '更新成功', 'admin/play/index' );
            } else {
                $this->error( '更新失败' );
            }
            //更新结束
        } else {
            //我是插入/插入开始
            $add = Db::name( 'play' )->insert( $data );
            if ( $add ) {
                $this->success( '增加成功', 'admin/play/index' );
            } else {
                $this->error( '增加失败' );
            }
        }
        //插入结束

    }

    //删除数据

    public function del() {
        $id = input( 'id' );
        $del = Db::name( 'play' )->delete( $id );
        if ( $del ) {
            $this->success( '删除成功', 'admin/Play/index' );
        } else {
            $this->error( '删除失败' );
        }
    }

}
