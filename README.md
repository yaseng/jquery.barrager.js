jquery.barrager.js 专业的网页弹幕插件
=================
  * [基本信息](#基本信息)
  * [使用](#使用)
      * [发布弹幕](#发布弹幕)
      * [清除所有弹幕](#清除所有弹幕)
      * [兼容低版本ie](#兼容低版本ie)
  * [集成](#集成)
      * [通用后端](#通用后端)
      * [Discuz](#discuz)
      * [WordPress](#wordpress)
      * [hexo](#hexo)
  * [版本更新](#版本更新) 
      * [1.0](#1.0)
      * [1.1](#1.1)

基本信息
========


| 名称 | jquery.barrager.js |
| -----|----|
|版本|1.1|
|项目主页|http://yaseng.github.io/jquery.barrager.js|
|下载|https://github.com/yaseng/jquery.barrager.js|
|github|https://github.com/yaseng/jquery.barrager.js|

![demo_1](https://raw.githubusercontent.com/yaseng/jquery.barrager.js/master/screenshot/demo_1.gif)

 Jquery.barrager.js 是一款优雅的网页弹幕插件,支持显示图片,文字以及超链接。支持速度、高度、颜色、数量等自定义。能轻松集成到论坛,博客等网站中。
 

使用
========

发布弹幕
--------
弹幕文字必选,图片,链接为空则不显示,其他的可选项有默认值,弹幕具体配置如下代码。

```JavaScript
var item={
   img:'static/heisenberg.png', //图片 
   info:'弹幕文字信息', //文字 
   href:'http://www.yaseng.org', //链接 
   close:true, //显示关闭按钮 
   speed:8, //延迟,单位秒,默认8
   bottom:70, //距离底部高度,单位px,默认随机 
   color:'#fff', //颜色,默认白色 
   old_ie_color:'#000000', //ie低版兼容色,不能与网页背景相同,默认黑色 
 }
$('body').barrager(item);
```

清除所有弹幕
------------

```JavaScript
 $.fn.barrager.removeAll();
```
兼容低版本ie
------------
ie 浏览器小于9不兼容css 圆角,采用兼容样式,可单独设置弹幕的颜色,属性为old_ie_color,建议不要与网页主背景色相同。
兼容模式效果图

![ie](https://raw.githubusercontent.com/yaseng/jquery.barrager.js/master/screenshot/ie.png)￼


集成
====
通用后端
--------
读取服务端有两种模式,适应于不同的场景

1. 实时读取,隔x秒请求一次接口,获取一条弹幕,发送。
2. 一次读取完毕,隔x秒发送一条弹幕。

*注意:json数据需要HTML 实体化以防止xss攻击。*


第一种模式示范代码
server 端(php)

```php
<?php 
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
	
//随机输出一个 
echo  json_encode($barrages[array_rand($barrages)]);
```
浏览器端获取json 弹幕数据,setInterval 调用,如有弹幕,就显示。
代码如下

```JavaScript
//每条弹幕发送间隔
var looper_time=3*1000;
//是否首次执行
var run_once=true;
do_barrager();

function do_barrager(){
  if(run_once){
      //如果是首次执行,则设置一个定时器,并且把首次执行置为false
      looper=setInterval(do_barrager,looper_time);                
      run_once=false;
  }
  //获取
  $.getJSON('server.php?mode=1',function(data){
      //是否有数据
      if(data.info){

           $('body').barrager(data);
      }

  });
}
```
效果如图
![demo_3](https://raw.githubusercontent.com/yaseng/jquery.barrager.js/master/screenshot/demo_3.gif)￼

第二种模式示范代码。
server 端 (php)

```php
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


echo   json_encode($barrages);
```

浏览器端

```JavaScript
$.ajaxSettings.async = false;
$.getJSON('server.php?mode=2',function(data){

//每条弹幕发送间隔
var looper_time=3*1000;
var items=data;
//弹幕总数
var total=data.length;
//是否首次执行
var run_once=true;
//弹幕索引
var index=0;
//先执行一次
barrager();
function  barrager(){

 
  if(run_once){
      //如果是首次执行,则设置一个定时器,并且把首次执行置为false
      looper=setInterval(barrager,looper_time);                
      run_once=false;
  }
  //发布一个弹幕
  $('body').barrager(items[index]);
  //索引自增
  index++;
  //所有弹幕发布完毕，清除计时器。
  if(index == total){

      clearInterval(looper);
      return false;
  }

  


}


});
```
效果如图
![demo_2](https://raw.githubusercontent.com/yaseng/jquery.barrager.js/master/screenshot/demo_2.gif)￼



Discuz
------
discuz 弹幕插件是一款基于discuz 论坛专业的弹幕插件,使用弹幕显示帖子,回复,指定内容等,为论坛带来更多的趣味和互动性。支持速度、高度、颜色、数量等自定义,兼容各种主流浏览器 。
插件地址: http://addon.discuz.com/?@uauc_barrager.plugin


WordPress
---------
jquery.barrager.js WordPress集成
http://yaseng.org/jquery-barrager-js-for-wordpress.html

hexo
---------
jquery.barrager.js hexo 集成
http://yaseng.org/jquery-barrager-js-for-hexo.html


版本更新
========

1.0
---
实现弹幕功能
 

1.1
----
1.更改弹幕动画方案,再多弹幕也不会卡了。

2.修正弹幕运行范围。
