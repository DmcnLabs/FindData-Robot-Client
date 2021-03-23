<?php
/*
 +----------------------------------------------------------------------
 | Copyright (c) 2017  All rights reserved.
 +----------------------------------------------------------------------
 | Author: Andy
 +----------------------------------------------------------------------
 | CreateDate:  18/01/15 下午1:42
 +----------------------------------------------------------------------
 +----------------------------------------------------------------------
*/
// 安装配置验证
namespace app\install\validate;

use think\Validate;

class InstallConfig extends Validate
{
    // 验证规则
    protected $rule = [
        //管理员信息验证规则
        'admin_username'       => 'require|length:1,32|regex:^(?!_)(?!\d)(?!.*?_$)[\w]+$',
        'admin_password'       => 'require|length:6,30',
        'admin_repassword'     => 'require|confirm:admin_password',
        'admin_email'          => 'require|email',
        //网站信息验证规则
        'web_site_title'       => 'require',
        'index_url'            => 'require',
        'web_site_description' => 'require',
        'web_site_keyword'     => 'require',
        //数据库验证规则
        'type'                 => 'require',
        'hostname'             => 'require',
        'database'             => 'require',
        'username'             => 'require',
        'password'             => 'require|length:6,30',
        'hostport'             => 'require|number|gt:0',
        'prefix'               => 'require',
    ];

    protected $message = [
        'admin_username.require'   => 'please fill in the user name',
        'admin_username.length'    => 'the length of user name is 1-32 characters',
        'admin_username.regex'     => 'user name can only contain numbers, letters and underscores, and does not start and end with underscores, and does not start with numbers!',
        'admin_password.require'   => 'please fill in the password',
        'admin_password.length'    => 'password length is 6-30 bits',
        'admin_repassword.require' => 'please fill in the duplicate password',
        'admin_repassword.confirm' => 'the passwords entered twice are inconsistent',
        'admin_email.require'      => 'please fill in the email',
        'admin_email.email'        => 'email format is incorrect',

        'web_site_title.require'   => 'please fill in the full site client name',
        'index_url.require'        => 'please fill in the full site client domain name',
        'web_site_description.require'   => 'please fill in the full description of the client',
        'web_site_keyword.require'       => 'please fill in the complete site client keywords',

        'type.require'     => 'please fill in the correct database type',
        'hostname.require' => 'please fill in the correct database host',
        'database.require' => 'please fill in the correct database instance',
        'username.require' => 'please fill in the correct database username',
        'password.require' => 'please fill in the correct database password',
        'password.length'    => 'the length of database password is 6-30 bits',
        'hostport.require' => 'please fill in the correct database port',
        'prefix.require'   => 'please fill in the correct database table prefix',

    ];

    protected $scene=[
        'admin_info' => ['admin_username','admin_password','admin_repassword','admin_email'],
        'web_config' => ['web_site_title','index_url','web_site_description','web_site_keyword'],
        'db_config' => ['type','hostname','database','username','hostport','prefix'],
    ];
}