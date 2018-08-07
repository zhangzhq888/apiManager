<?php defined('API') or exit('http://gwalker112.cn');?>
<!--导航-->
<?php if($act != 'api' && $act != 'sort'){
    $list = select("select * from api where isdel=0 and (name like '%".$_GET['keyWord']."%' or url like '%".$_GET['keyWord']."%') order by lasttime desc");
    //var_dump($list);
    ?>
    <div class="form-group">
        <input type="text" class="form-control" id="searchcate" onkeyup="search('cate',this)" placeholder="全局搜索:支持接口名称，接口URL">
    </div>
    <div class="list">
        <ul class="list-unstyled">
            <?php foreach($list as $v){?>
            <form action="?act=cate" method="post">
            <li class="menu" id="info_<?php echo $v['aid'];?>">
                <a href="<?php echo U(array('act'=>'api','tag'=>$v['aid'])).'#info_api_'.md5($v['id'])?>" target="_blank">
                    <?php echo $v['name']?>
                </a>
                <br>
                <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$v['des'] .'    前端调用地址：'.$v['url'];echo "<input type='hidden' name='aid' value='{$v['aid']}'>";?>
                <br>
                <?php if(is_supper()){?>
                <!--只有超级管理员才可以对分类进行操作-->
                <div style="float:right;margin-right:16px;">
                    &nbsp;<button class="btn btn-danger btn-xs" name="op" value="delete" onclick="javascript:return confirm('您确认要删除吗?')">删除</button>
                    &nbsp;<button class="btn btn-info btn-xs" name="op" value="edit">编辑</button>
                </div>
                <br>
                <?php } ?>
                <hr>
            </li>
            <!--接口分类关键字(js通过此关健字进行模糊查找)start-->
            <span class="keyword" id="<?php echo $v['aid'];?>"><?php echo $v['cdesc'].'<|-|>'.$v['cname'];?></span>
                <!--接口关键字(js通过此关健字进行模糊查找)end-->
            </form>
            <?php } ?>
        </ul>
    </div>

<?php } else{
    $sql = "select * from api where aid = '{$_GET['tag']}' and isdel='0' order by ord desc,id desc";
    $list = select($sql);?>
    <div class="form-group">
        <input type="text" class="form-control" id="searchapi" placeholder="search here" onkeyup="search('api',this)">
    </div>
    <div class="list">
        <ul class="list-unstyled" style="padding:10px">
            <?php foreach($list as $v){ ?>
            <li class="menu" id="api_<?php echo md5($v['id']);?>" >
                <a href="<?php echo U(array('act'=>'api','tag'=>$_GET['tag'])); ?>#info_api_<?php echo md5($v['id']) ?>" id="<?php echo 'menu_'.md5($v['id'])?>">
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    <?php echo $v['name'] ?>
                </a>
            </li>
            <!--接口关键字(js通过此关健字进行模糊查找)start-->
            <span class="keyword" id="<?php echo md5($v['id'])?>"><?php echo $v['name'].'<|-|>'.$v['num'].'<|-|>'.$v['des'].'<|-|>'.$v['memo'].'<|-|>'.$v['parameter'].'<|-|>'.$v['url'].'<|-|>'.$v['type'].'<|-|>'.strtolower($v['type']);?></span>
            <!--接口关键字(js通过此关健字进行模糊查找)end-->
            <?php } ?>
        </ul>
    </div>

<?php } ?>
<!--jquery模糊查询start-->
<script>
    var $COOKIE_KEY = "<?php echo C('cookie->navbar')?>"; //记录左侧菜单栏的开打与关闭状态的cookie的值
    function search(type,obj){
        window.onkeydown = function(e){
            if(e.keyCode == 13){
                var $find = $.trim($(obj).val());//得到搜索内容
                window.location.href="/index.php?act=search&keyWord="+$find;
            }

        }

    }

    window.onload=function(){
        //添加关闭,打开左侧菜单的功能
        <?php if($_COOKIE[C('cookie->navbar')]==1){
            echo 'var status_flg="&gt";var cursor="e-resize";';
        }else{
            echo 'var status_flg="&lt";var cursor="w-resize"';
        }?>

        var navbarButton = '<div onclick="navbar(this)" ' +
            'style="text-align:center;line-height:120px;border-bottom-right-radius:5px;cursor:'+cursor+';border-top-right-radius:5px;width:14px;height:120px;background: rgba(91,192,222, 0.8);position:fixed;left:0;top:260px;color:#fff;box-shadow: 0px 0px 0px 1px #cccccc;">' +
            status_flg +
            '</div>'
        $('body').append(navbarButton);
    }
    // 全屏和normal
    function navbar(obj){
        if($('#mainwindow').hasClass('col-md-9')){
            $(obj).html('&gt;');
            $(obj).css("cursor","e-resize");
            $('#mainwindow').removeClass('col-md-9').addClass('col-md-12');
            $('#navbar').hide();
            $.cookie($COOKIE_KEY, '1');
        }else{
            $(obj).html('&lt;');
            $(obj).css("cursor","w-resize");
            $('#mainwindow').removeClass('col-md-12').addClass('col-md-9');
            $('#navbar').show();
            $.cookie($COOKIE_KEY, '0');
        }
    }
</script>
<!--jquery模糊查询end-->
<!--end-->
