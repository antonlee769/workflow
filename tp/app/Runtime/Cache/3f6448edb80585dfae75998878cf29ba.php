<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="zh-cn">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta charset="UTF-8">
	<title>test</title>
</head>
<body>
	<!DOCTYPE HTML>
 <html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title>Insert title here</title>
 <!--样式-->
 <style type="text/css">
body {margin:40px auto; width:800px; font-size:12px; color:#666;}
 .item{
    border: 1px solid #D4D4D4;
    color: red;
    margin: 0 10px 10px 0;
    padding: 10px;
    position: relative;
    width: 200px;
 }
 .loading-wrap{
    bottom: 50px;
    width: 100%;
    height: 52px;
    text-align: center;
    display: none;
 }
 .loading {
    padding: 10px 10px 10px 52px;
    height: 32px;
    line-height: 28px;
    color: #FFF;
    font-size: 20px;
    border-radius: 5px;
    background: 10px center rgba(0,0,0,.7);
 }
 .footer{
    border: 2px solid #D4D4D4;
 }
 </style>
 <!--样式-->
 </head>
 <body>
 <!--引入所需要的jquery和插件-->
 <script type="text/javascript" src="__ROOT__/statics/js/jquery/jquery-1.7.2.min.js"></script>
 <script type="text/javascript" src="__ROOT__/statics/js/jquery.masonry.min.js"></script>
 <!--引入所需要的jquery和插件-->
 <!--瀑布流-->
 <div id="container" class=" container">
 <!--这里通过设置每个div不同的高度，来凸显布局的效果-->
 <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item"  ><img src="data/news/<?php echo ($vo["img"]); ?>" width="200px"/><br/>瀑布流下来了</div><?php endforeach; endif; else: echo "" ;endif; ?>
 </div>
 <!--瀑布流-->
 <!--加载中-->
 <div id="loading" class="loading-wrap">
    <span class="loading">加载中，请稍后...</span>
 </div>
 <!--加载中-->
 <!--尾部-->
 <div class="footer"><center>我是页脚</center></div>
 <!--尾部-->
 <script type="text/javascript">
$(function(){
    //页面初始化时执行瀑布流
    var $container = $('#container');
     $container.masonry({
        itemSelector : '.item',
        isAnimated: true
     });
	 
	 var page = 1;
     //用户拖动滚动条，达到底部时ajax加载一次数据
    var loading = $("#loading").data("on", false);//通过给loading这个div增加属性on，来判断执行一次ajax请求
    $(window).scroll(function(){
        if(loading.data("on")) return;
        if($(document).scrollTop() > $(document).height()-$(window).height()-$('.footer').height()){ //页面拖到底部了
            //加载更多数据
            loading.data("on", true).fadeIn();         //在这里将on设为true来阻止继续的ajax请求
            $.get(
                "index.php/Index/getMore/page/"+page, 
                function(data){
                   //获取到了数据data,后面用JS将数据新增到页面上
				    page++;
                    var html = "";
                    if($.isArray(data)){
                        for(i in data){
                            html += "<div class=\"item\"><img src=\"data/news/"+data[i].img+"\" width=\"200px\">"+data[i].title+"</div>";
                        }
                        var $newElems = $(html).css({ opacity: 0 }).appendTo($container);
                        $newElems.imagesLoaded(function(){
                            $newElems.animate({ opacity: 1 });
                            $container.masonry( 'appended', $newElems, true ); 
                              });
                      //一次请求完成，将on设为false，可以进行下一次的请求
                        loading.data("on", false);
                    }
                    loading.fadeOut();
                },
                "json"
            );
        }
    });
 });
 </script>
 </body>
 </html>
</body>
</html>