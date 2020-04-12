<?php

namespace app\index\controller;

use app\common\controller\IndexBase;
use think\Db;
use think\Session;

class Index extends IndexBase {

    //前端 / 首页

    public function index() {

        $username = $this->usernames();
        $this->assign( 'username', $username );
        return $this->fetch( 'index' );
    }

    //2曲艺曲种

    public function skill() {
        $song_id = input( 'song_id' );
        if ( $song_id ) {
            //选择了某一个类
            $song_id = $song_id;
        } else {
            //没有选择那么我就默认为1
            $song_id = 1;
        }
        $play = Db::name( 'play' )->where( 'song_id', $song_id )->select();
        $empty = '0';
        if ( !$play ) {
            $empty = '1';
        }
        $this->assign( 'empty', $empty );
        $all = Db::name( 'song' )->order( 'id' )->select();
        $this->assign( 'all', $all );
        $this->assign( 'play', $play );
        $username = $this->usernames();
        $this->assign( 'username', $username );
        return $this->fetch( 'skill' );
    }

    //3曲艺赏析

    public function appreciate() {
        $username = $this->usernames();
        $this->assign( 'username', $username );
        return $this->fetch( 'appreciate' );
    }

    //4曲艺历史

    public function history() {
        $username = $this->usernames();
        $this->assign( 'username', $username );
        return $this->fetch( 'history' );
    }

    //5登录注册

    public function register() {
        $username = $this->usernames();
        $this->assign( 'username', $username );
        return $this->fetch( 'register' );
    }
    //《穆桂英挂帅》详细页面

    public function particular() {
        $play_id = input( 'play_id' );
        $all = Db::name( 'play' )->where( 'id', $play_id )->find();
        $play = Db::name( 'play' )->where( 'song_id', $all['song_id'] )->select();
        $empty = '0';
        if ( !$play ) {
            $empty = '1';
        }
        $discuss = Db::name('discuss')->whehre('play_id',$play_id)->select();
        $username = $this->usernames();
        $this->assign( 'username', $username );
        $this->assign( 'play_id', $play_id );
        $this->assign( 'discuss', $discuss );
        $this->assign( 'empty', $empty );
        $this->assign( 'play', $play );
        $this->assign( 'all', $all );
        return $this->fetch( 'particular' );
    }

    // discuss  /评论

    public function discuss() {
        $username = session('user_name');
        if (!$username) {
            return 0;
        }else{
            $data['user_id'] = session( 'user_id' );
            $data['content'] = input('content');
            $data['play_id'] = input('play_id');
            $in = Db::name( 'discuss' )->insert( $data );
            if ( $in ) {
                return 1;
                //评论成功
            } else {
                return 2;
                //失败
            }
        }
    }

    public function login() {
        //当status为0的时候是登录，为1的时候是注册
        $status = input( 'status' );
        $data['password'] = input( 'password' );
        $data['mailbox'] = input( 'mailbox' );
        $data['username'] = input( 'user' );
        if ( $status == 0 ) {
            $name = Db::name( 'user' )->where( 'mailbox', $data['mailbox'] )->find();
            if ( $name['password'] == $data['password'] ) {
                session( 'user_name', $name['username'] );
                session( 'user_id', $name['id'] );
                return 0;
                //登录成功
            } else {
                return 1;
                //账号或密码错误
            }
        } else {
            $in = Db::name( 'user' )->insert( $data );
            if ( $in ) {
                return 2;
                //注册成功
            } else {
                return 3;
                //注册失败
            }
        }
    }


    //获取用户session
    public function usernames()
    {
       $username = session('user_name');
       return $username;
    }
}
