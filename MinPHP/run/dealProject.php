<?php defined('API') or exit('http://gwalker.cn');?>
<!--接口分类管理-->
<?php
echo 'dealProject';
if(!is_supper()){die('只有超级管理员才可对分类进行操作');}
//操作类型{add,delete,edit}
$op = I($_POST['op']);
//是否执行操作(如果为do的话,则为执行添加,删除,编辑操作)
$type = I($_GET['type']);
$pid = I($_GET['pid']);
var_dump('PID:'.$pid);
switch($op){
    //添加
    case 'add':
        if($type  == 'do'){
            $_VAL = I($_POST);
            $project_name = $_VAL['cname'];
            $cdesc = $_VAL['cdesc'];
            $time = time();
            if(!empty($project_name) && !empty($cdesc)){
                $sql = "insert into project (project_name,cdesc,addtime) values('{$project_name}','{$cdesc}','{$time}')";
                $re = insert($sql);
                if($re){
                    go(U());
                }else{
                    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 项目添加失败</div>';
                }
            }else{
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 项目名与描述不能为空</div>';
            }
        }
    break;
    //删除
    case 'delete':
        $aid = I($_POST['aid']);
        $sql = "update project set isdel=1 where id='{$aid}'";
        $re = update($sql);
        if($re){
            go(U());
        }else{
            echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 项目删除失败</div>';
        }
    break;
    //编辑
    case 'edit';
        $_VAL = I($_POST);
        if($type == 'do'){
            $sql = "update project set project_name='{$_VAL['cname']}',cdesc='{$_VAL['cdesc']}' where id='{$_VAL['aid']}'";
            $re = update($sql);
            if($re !== false){
                go(U());
            }else{
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 项目修改失败</div>';
            }
        }else{
            echo 445;
            $aid = $_VAL['aid'];
            $sql = "select * from project where id='{$aid}'";
            $info = find($sql);
        }
    break;
}
?>
<?php if($op == 'add'){ ?>
    <div style="border:1px solid #ddd">
        <div style="background:#f5f5f5;padding:20px;position:relative">
            <h4>添加项目</h4>
            <div>
                <form action="?act=project&type=do" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="cname" placeholder="项目名">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="cdesc" placeholder="描述">
                    </div>
                    <button class="btn btn-success" name="op" value="add">提交</button>
                </form>
            </div>
        </div>
    </div>
<?php }if($op == 'edit'){ ?>
    <div style="border:1px solid #ddd">
        <div style="background:#f5f5f5;padding:20px;position:relative">
            <h4>编辑项目</h4>
            <div>
                <form action="?act=project&type=do" method="post">
                    <div class="form-group">
                        <input type="hidden" name="aid" value="<?php echo $info['id'] ?>">
                        <input type="text" class="form-control" name="cname" placeholder="项目名" value="<?php echo $info['project_name'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="cdesc" placeholder="描述" value="<?php echo $info['cdesc'] ?>">
                    </div>
                    <button class="btn btn-success" name="op" value="edit">提交</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>