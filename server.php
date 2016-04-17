<?php
/*!
 *@name     server.php
 *@project  jquery.barrager.js
 *@des      弹幕插件服务端演示
 *@author   yaseng@uauc.net
 *@url      https://github.com/yaseng/jquery.barrager.js
 */

//mode=1 实时模式 mode=2 一次性获取模式
$mode=intval($_GET['mode']);
//数组里面可以自定义弹幕的所有属性。
$barrages=
array(
	array(
		'info'   => '第一条弹幕',
		'img'    => 'static/img/heisenberg.png',
		'href'   => 'http://www.yaseng.org',

		),
	array(
		'info'   => '第二条弹幕',
		'img'    => 'static/img/yaseng.png',
		'href'   => 'http://www.yaseng.org',
		'color'  =>  '#ff6600'

		),
	array(
		'info'   => '第三条弹幕',
		'img'    => 'static/img/mj.gif',
		'href'   => 'http://www.yaseng.org',
		'bottom' => 70 ,

		),
	array(
		'info'   => '第四条弹幕',
		'href'   => 'http://www.yaseng.org',
		'close'  =>false,

		),

	);

if($mode === 1 ){

    echo  json_encode($barrages[array_rand($barrages)]);


}elseif($mode === 2){

	echo   json_encode($barrages);

}
