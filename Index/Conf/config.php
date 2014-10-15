<?php
return array(
	//'配置项'=>'配置值'
	
	'__PUBLIC__'    =>  __ROOT__ . '/' . APP_NAME . '/Tpl/Public',
			
	'DB_TYPE' => 'mysql',
		'DB_HOST' => '172.21.12.58',
		'DB_NAME' => 'test_repo',
		'DB_USER' => 'root',
		'DB_PWD' => 'root',
		'DB_PREFIX' => '',
		'DB_PORT' => 3306,
		
	'TMPL_EXCEPTION_FILE' => __ROOT__ . '/' . APP_NAME . '/Tpl/error.html',
	'ERROR_PAGE' =>  __ROOT__ . '/' . APP_NAME . '/Tpl/error.html'
	
);
?>