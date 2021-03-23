<?php
// +----------------------------------------------------------------------
// | PHP version 5.4+                
// +----------------------------------------------------------------------
// | Copyright (c) 2014-2016 http://www.123.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author:Andy
// +----------------------------------------------------------------------

// 检测环境是否支持可写
define('IS_WRITE', true);

/**
 * 系统环境检测
 * @return array 系统环境数据
 */
function check_env(){
	$items = [
		'os'      => ['OS', 'unlimited', 'Unix', PHP_OS, 'success'],
		'php'     => ['PHP Version', '5.4.0', '5.4+', PHP_VERSION, 'success'],
		'upload'  => ['Upload', 'unlimited', '2M+', '-', 'success'],
		'gd'      => ['GD Lib', '2.0', '2.0+', '-', 'success'],
        'curl'      => ['CURL Lib', '7.1', '7.1+', '-', 'success'],
		'disk'    => ['Disk', '100M', 'unlimited', '-', 'success'],
	];

	//PHP环境检测
	if($items['php'][3] < $items['php'][1]){
		$items['php'][4] = 'danger';
		session('error', true);
	}

	//附件上传检测
	if(@ini_get('file_uploads'))
		$items['upload'][3] = ini_get('upload_max_filesize');

	//GD库检测
	$tmp = function_exists('gd_info') ? gd_info() : array();
	if(empty($tmp['GD Version'])){
		$items['gd'][3] = 'not_installed';
		$items['gd'][4] = 'danger';
		session('error', true);
	} else {
		$items['gd'][3] = $tmp['GD Version'];
	}
	unset($tmp);

    //curl库检测
    $tmp = function_exists('curl_version') ? curl_version() : array();
    if(empty($tmp['version'])){
        $items['curl'][3] = 'not_installed';
        $items['curl'][4] = 'danger';
        session('error', true);
    } else {
        $items['curl'][3] = $tmp['version'];
    }
    unset($tmp);

	//磁盘空间检测
	if(function_exists('disk_free_space')) {
		$items['disk'][3] = floor(disk_free_space(ROOT_PATH) / (1024*1024)).'M';
	}

	return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 */
function check_dirfile(){
	$items = [
        ['dir',  'write', 'success', 'app/'],
		['dir',  'write', 'success', 'data/'],
		['dir',  'write', 'success', 'runtime/'],
	];

	foreach ($items as &$val) {
		$item =	ROOT_PATH.$val[3];
		if('dir' == $val[0]){
			if (!is_dir($item)) {
				@mkdirs($item);
			}
			if(!is_writable($item)) {
				if(is_dir($item)) {
					$val[1] = 'read';
					$val[2] = 'danger';
					session('error', true);
				} else {
					$val[1] = 'non_existent';
					$val[2] = 'danger';
					session('error', true);
				}
			}
		} else {
			if(file_exists($item)) {
				if(!is_writable($item)) {
					$val[1] = 'not_write';
					$val[2] = 'danger';
					session('error', true);
				}
			} else {
				if(!is_writable(dirname($item))) {
					$val[1] = 'non_existent';
					$val[2] = 'danger';
					session('error', true);
				}
			}
		}
	}

	return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 */
function check_func(){
	$items = array(
		array('pdo','supported','success','class'),
		array('pdo_mysql','supported','success','lib'),
		array('file_get_contents', 'supported', 'success','fun'),
		array('mb_strlen',		   'supported', 'success','fun'),
        array('curl_init',		   'supported', 'success','fun'),
	);

	foreach ($items as &$val) {
		if(('class'==$val[3] && !class_exists($val[0]))
			|| ('lib'==$val[3] && !extension_loaded($val[0]))
			|| ('fun'==$val[3] && !function_exists($val[0]))
			){
			$val[1] = 'not_supported';
			$val[2] = 'danger';
			session('error', true);
		}
	}

	return $items;
}

/**
 * 写入配置文件
 * @param  array $config 配置信息
 */
function write_config($config){
	if(is_array($config)){
		//读取配置内容
		$conf = file_get_contents(APP_PATH . 'install/data/database.tpl');
		//替换配置项
		foreach ($config as $name => $value) {
			$conf = str_replace("[{$name}]", $value, $conf);
		}
		//安装信息
		file_put_contents(ROOT_PATH . 'data/install.lock', 'ok');

		//写入应用配置文件
		if(file_put_contents(APP_PATH . 'database.php', $conf)){
			show_msg('SUCCESS');
		} else {
			show_msg('FAIL！', 'error');
			session('error', true);
		}
		return '';
	}
}

/**
 * 创建数据表
 * @param  resource $db 数据库连接资源
 */
function create_tables($db, $prefix = ''){
	//读取SQL文件
	$sql = file_get_contents(APP_PATH . 'install/data/install.sql');
	$sql = str_replace("\r", "\n", $sql);
	$sql = explode(";\n", $sql);

	//替换表前缀
	$orginal = 'cloud_';
	$sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

	//开始安装
	show_msg('Start installation ...');
	foreach ($sql as $value) {
		$value = trim($value);
		if(empty($value)) continue;
		if(substr($value, 0, 12) == 'CREATE TABLE') {
			$name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
			$msg  = "Create table {$name}";
			if(false !== $db->execute($value)){
				show_msg($msg . '...success');
			} else {
				show_msg($msg . '...fail！', 'error');
				session('error', true);
			}
		} else {
			$db->execute($value);
		}

	}
}



/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false) {
    $type      = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) {
        return $ip[$type];
    }

    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }

            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

//创建创始人管理员
function register_administrator($db, $prefix, $admin){
	show_msg('Start registering founder account...');

	$password = passwordencrypt($admin['password']);

	$sql = "INSERT INTO `[PREFIX]users` (`uid`,`username`,`password`,`nickname`,`email`, `avatar`,`sex`,`birthday`,`score`,`allow_admin`,`reg_time`,`last_login_ip`,`last_login_time`,`status`,`user_type`,`create_time`) VALUES ".
		   "('1', '[NAME]', '[PASS]', 'Founder', '[EMAIL]','/img/default-avatar.svg', '0', '0', '0', '1', '[TIME]', '[IP]','[TIME]', '1', '3','[TIME]');";
	$sql = str_replace(
		['[PREFIX]', '[NAME]','[PASS]','[EMAIL]','[TIME]', '[IP]'],
		[$prefix, $admin['username'],$password, $admin['email'], time(), get_client_ip(1)],
		$sql);

	$db->execute($sql);
	show_msg('Founder account registered successfully！');
}

/**
 * 加密密码
 * @param string    $data   待加密字符串
 * @return string 返回加密后的字符串
 */
function encrypt($data) {
    return md5(md5(config('data_auth_key').md5($data)));
}

/**
 * 更新网站信息
 * @param  [type] $db        [description]
 * @param  [type] $prefix    [description]
 * @param  [type] $webconfig [description]
 * @return [type]            [description]
 */
function update_webconfig($db, $prefix, $webconfig)
{
	show_msg('Start updating site configuration...');

	$sql = "UPDATE `{$prefix}sys_conf` 
		    SET value = CASE name 
		        WHEN 'web_site_title' THEN '{$webconfig['web_site_title']}'
		        WHEN 'index_url' THEN '{$webconfig['index_url']}'
		        WHEN 'web_site_description' THEN '{$webconfig['web_site_description']}'
		        WHEN 'web_site_keyword' THEN '{$webconfig['web_site_keyword']}'
		    END
		WHERE name IN ('web_site_title','index_url','web_site_description','web_site_keyword')";
	$db->execute($sql);
	show_msg('Update site configuration complete！');
}

/**
 * 更新数据表
 * @param  resource $db 数据库连接资源
 */
function update_tables($db, $prefix = ''){
	//读取SQL文件
	$sql = file_get_contents(APP_PATH . 'install/data/update.sql');
	$sql = str_replace("\r", "\n", $sql);
	$sql = explode(";\n", $sql);

	//替换表前缀
	$sql = str_replace(" `cloud_", " `{$prefix}", $sql);

	//开始安装
	show_msg('Start upgrading database...');
	foreach ($sql as $value) {
		$value = trim($value);
		if(empty($value)) continue;
		if(substr($value, 0, 12) == 'CREATE TABLE') {
			$name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
			$msg  = "Create table {$name}";
			if(false !== $db->execute($value)){
				show_msg($msg . '...success');
			} else {
				show_msg($msg . '...fail！', 'error');
				session('error', true);
			}
		} else {
			if(substr($value, 0, 8) == 'UPDATE `') {
				$name = preg_replace("/^UPDATE `(\w+)` .*/s", "\\1", $value);
				$msg  = "Update table {$name}";
			} else if(substr($value, 0, 11) == 'ALTER TABLE'){
				$name = preg_replace("/^ALTER TABLE `(\w+)` .*/s", "\\1", $value);
				$msg  = "Alter table {$name}";
			} else if(substr($value, 0, 11) == 'INSERT INTO'){
				$name = preg_replace("/^INSERT INTO `(\w+)` .*/s", "\\1", $value);
				$msg  = "Insert table {$name}";
			}
			if(($db->execute($value)) !== false){
				show_msg($msg . '...success');
			} else{
				show_msg($msg . '...fail！', 'error');
				session('error', true);
			}
		}
	}
}

/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 */
function show_msg($msg, $class = 'primary'){
	echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
	ob_flush();
	flush();
}

/**
 * 生成系统AUTH_KEY
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function build_auth_key(){
	$chars  = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars .= '`~!@#$%^&*()_+-=[]{};:"|,.<>/?';
	$chars  = str_shuffle($chars);
	return substr($chars, 0, 40);
}


/**
 * 创建多级目录
 * @param  [type] $dir 路径
 * @return [type] [description]
 */
function mkdirs($dir) {
    if (! is_dir ( $dir )) {
        if (! mkdirs ( dirname ( $dir ) )) {
            return false;
        }
        if (! mkdir ( $dir, 0755 )) {
            return false;
        }
    }
    return true;
}