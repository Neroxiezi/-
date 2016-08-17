<?php
	include '../common.php';
	include APATH.'/header.php';

	//开始做分页操作
	$num = 2;


	//开始遍历
	$pid=@$_GET['id']?$_GET['id']:0;
	$p  =@$_GET['p']?$_GET['p']:1;


	//得到总条数
	$sql1 = "select count(*) from `category` where pid=$pid";
	$total = db()->queryScalar($sql1);
	//总页数
	$pages = ceil($total/$num);
	$p  =min($p,$pages);
	$p  =max($p,1);

	$start = ($p-1)*$num;

	$next=$p+1;
	$prev=$p-1;


	$sql = "select * from `category` where pid=$pid limit $start,$num";
	$catelist =db()->query($sql);

	//查询父亲的pid 
	$sql2 = "select `pid` from `category` where id=$pid";
	@$ppid=db()->query($sql2)[0]['pid'];
	$ppid=$ppid?$ppid:0;

	$str="
	<a href='".AURL."/Category/index.php?p=1&id=$pid'>首页</a>
	<a href='".AURL."/Category/index.php?p=$prev&id=$pid'>上一页</a>
	<a href='".AURL."/Category/index.php?p=$next&id=$pid'>下一页</a>
	<a href='".AURL."/Category/index.php?p=$pages&id=$pid'>尾页</a>
"

?>
	<div class="m_right fl">
		<h1>分类管理</h1>
		<a href="<?php echo AURL?>/Category/add.php"><button style="height:50px;width:200px;background:#DB5424;font-size:20px;color:#fff;border:none;">添加一级分类</button></a>
		<table class="table table-bordered" >
		<a href="<?php echo AURL?>/Category/index.php?id=<?php echo $ppid;?>"><button style="height:50px;width:200px;background:#DB5424;font-size:20px;color:#fff;border:none;">返回上级分类</button></a>
		<table class="table table-bordered" >
 			<tr>
 				<th>ID</th>
 				<th>类名</th>
 				<th>PID</th>
 				<th>PATH</th>
 				<th>添加时间</th>
 				<th>状态</th>
 				<th>操作</th>
 			</tr>
			<?php if(!empty($catelist)):?>


	 			<?php foreach ($catelist as $key => $value): ?>
	 				<tr>
	 					<td><?php echo $value['id']; ?></td>
	 					<td><?php echo $value['name']; ?></td>
	 					<td><?php echo $value['pid']; ?></td>
	 					<td><?php echo $value['path']; ?></td>
	 					<td><?php echo date('Y年m月d日',$value['addtime']); ?></td>
	 					<td><?php echo $value['status']?'<a href="'.AURL.'/Category/action.php?a=up&id='.$value['id'].'"><img src="'.URL.'/Public/img/x.png" style="display: block;border-radius:30px;" /></a>':'<a href="'.AURL.'/Category/action.php?a=up&id='.$value['id'].'"><img src="'.URL.'/Public/img/dui.png" style="display: block;border-radius:30px;"></a>' ;?></td>
	 					<th><a href="<?php echo AURL?>/Category/add.php?id=<?php echo $value['id']?>"><button style="height:40px;width:100px;background:#00A5A5;font-size:20px;color:#fff;border:none;">添加子类</button></a>
						<a href="<?php echo AURL?>/Category/index.php?id=<?php echo $value['id']?>"><button style="height:40px;width:100px;background:#00A5A5;font-size:20px;color:#fff;border:none;">查看子类</button></a>

	 					</th>
	 				</tr>
	 			<?php endforeach ?>
	 		<?php else: ?>
			<tr>
 				<td colspan="8" align="center"><span style="color:red;font-size:20px;"> 没有分类</span> </td>
 			</tr>
	 		<?php endif;?>

 			<tr>
 				<td colspan="8" align="center"><?php echo $str; ?></td>
 			</tr>
		</table>
		
	</div>
<?php APATH.'/footer.php';?>