<?php defined('API') or exit('http://gwalker.cn');?>
<!--欢迎页-->
<!--info start-->
<style type="text/css">
    .p_show{
        margin-top:20px
    }
    .p_show li{
        margin-top: 10px;
    }
</style>
<div style="font-size:18px;">
    <div class="info" style="font-size:14px;">
        <span style="font-size:30px;" class="glyphicon glyphicon-grain" aria-hidden="true"></span> <span style="font-size:16px;">欢迎使用接口管理工具 <?php echo C('version->no').'版';?></span><br>
        <div class="p_show">
            <li><a href="/" target="_blank">这里填写文档说明MinPHP/run/hello.php</a></li>
            <li><a href="/" target="_blank">也可以填写团队常用的文档地址</a></li>
        </div>
    </div>
    <br><br>
    <div style="width: 50%;margin: 0 auto">
        <div class="form-group">
            <input type="text" class="form-control" id="searchcate" onkeyup="search('cate',this)" placeholder="全局搜索:支持接口名称，接口URL">
        </div>
    </div>
</div>
<script>
    function search(type,obj){
        window.onkeydown = function(e){
            if(e.keyCode == 13){
                var $find = $.trim($(obj).val());//得到搜索内容
                window.location.href="/index.php?act=search&keyWord="+$find;
            }

        }

    }
</script>
<!--欢迎页 end-->
