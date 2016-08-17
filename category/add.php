<?php 
	include '../init.php';
	include ADMIN_PATH.'/header.php';
	if($_GET['id'])
	{
		$id=$_GET['id'];
		$sql="select `path` from `category` where id=$id";
		$model =new Model('category');
		$cate_path=$model->find($sql)[0]['path'].$id.',';
		$pid=$id;
	}else
	{

		echo '1';
		$pid=0;
		$cate_path='0,';
	}


 ?>
<div class="cate_add">
	<form action="<?php echo ADMIN_URL;?>/category/action.php?a=add" method="post">
		分类名:
			<input type="text" name="name" placeholder="分类名"/>
		<br/>

		PID:
			<input type="text" value="<?php echo $pid; ?>" name="pid" readonly />
		<br/>
		PATH:
			<input type="text" value="<?php echo $cate_path; ?>" name="path" readonly />
		<br/>
		<input type="submit" value="添加" />
	</form>
</div>

<?php include ADMIN_PATH.'/footer.html'; ?>