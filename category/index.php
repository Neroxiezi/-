<?php 
	include '../init.php';
	include ADMIN_PATH.'/header.php';
	$model = new Model('category');

	$num=3;

	$pid =empty($_GET['pid'])?0:$_GET['pid'];

	//查询总条数	
	$sql1= "select count(*) from `category` where pid=$pid";

	//总条数
	$total = $model->find($sql1)[0]['count(*)'];

	//总页数
	$pages = ceil($total/$num);

	//当前页数
	$p=$_GET['p']?$_GET['p']:1;

	$p=min($p,$pages);
	$p=max($p,1);

	$start = ($p-1)*$num;

	$offset=$num;

	$next=$p+1;

	$prev=$p-1;

	$sql="select * from `category` where pid=$pid limit $start,$offset";
	
	$list=$model->find($sql);

	$str="
	<a href=".ADMIN_URL."/category/index.php?pid=$pid>首页</a>
	<a href=".ADMIN_URL."/category/index.php?pid=$pid&p=$prev>上一页</a>
	<a href=".ADMIN_URL."/category/index.php?pid=$pid&p=$next>下一页</a>
	<a href=".ADMIN_URL."/category/index.php?pid=$pid&p=$pages>尾页</a>
	";
 ?>
 <div class="main_right fr">
	<div class="main_m">
		<h1>这是分类页面</h1>
		<a href="<?php echo ADMIN_URL?>/category/add.php"><button style="width:100px;height:40px;border:none;background:#00A5A5;">添加一级分类</button></a>

		<?php 
			$sql2 = "select `pid` from `category` where id=$pid";
			$ppid = $model->find($sql2)[0]['pid'];
		 ?>
		 <a href="<?php echo ADMIN_URL; ?>/category/index.php?pid=<?php echo $ppid;?>"><button style="width:100px;height:40px;border:none;background:#00A5A5;">返回上级</button></a>
		<!-- 好看的表格 -->
		<table class="table" border="1" cellspacing="0" cellpadding="5" align="center">
			<tr>
				<th colspan="7">
				 	<input type="text" /><button>搜索</button>
				</th>
			</tr>
			<tr bgcolor="#ccc">
				<th>编号</th>
				<th>类名</th>
				<th>PID</th>
				<th>PATH</th>
				<th>状态</th>
				<th>时间</th>
				<th>操作</th>
			</tr>
			<?php foreach ($list as $key => $value): ?>
				<tr>
					<td><?php echo $value['id']; ?></td>
					<td><?php echo $value['name']; ?></td>
					<td><?php echo $value['pid'] ?></td>
					<td><?php echo $value['path'] ?></td>
					<td>
						<?php 
							echo $value['status']?'<a href="'.ADMIN_URL.'/category/action.php?a=up&id='.$value['id'].'"><img style="display:block;border-radius:60px;" src="'.URL.'/public/img/dui.png"></a>':'<a href="'.ADMIN_URL.'/category/action.php?a=up&id='.$value['id'].'"><img style="display:block;border-radius:60px;" src="'.URL.'/public/img/x.png"></a>';
						?>

					</td>
					<td><?php echo date('Y年m月d日',$value['addtime']); ?></td>
					<td>
						<a href="<?php echo ADMIN_URL;?>/category/add.php?id=<?php echo $value['id']; ?>">添加子分类</a>
						| <a href="<?php echo ADMIN_URL?>/category/index.php?pid=<?php echo $value['id']; ?>">查看子类</a>
						| <a href="<?php echo ADMIN_URL; ?>/category/action.php?a=del&id=<?php echo $value['id']; ?>">删除</a>	
					</td>
				</tr>
				
			<?php endforeach ?>
			<tr>
				<td colspan="7">
				<br>
					<?php echo $str; ?>
				<br>
				</td>
			</tr>
		</table>


	</div>	
</div>
<?php include ADMIN_PATH.'/footer.html'; ?>
