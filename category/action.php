<?php

	include '../init.php';
	$a=$_GET['a'];
	$model=new Model('category');

	switch($a){
		case 'add':

			//判断是否为空
			if(empty($_POST['name']))
			{
				error('大爷你想干啥');
				return false;
			}

			$data['name'] = $_POST['name'];
			$data['pid']  = $_POST['pid'];
			$data['path'] = $_POST['path'];
			$data['addtime'] = time();
			//插入：


			$res= $model->add($data);
			if($res)
			{
				success('插入成功',ADMIN_URL.'/category/miaosha.php',2);
				return false;
			}
			break;
			case 'up':
			$where['id']=$_GET['id'];
			$stues = $model->select($where);
			/*var_dump($stues);
			exit;*/

			/*if($stues[0]['status']==0){
				$data['status']=1;
			}else
			{
				$data['status']=0;
			}*/

			$data['status']= $stues[0]['status']==0?1:0;
			$pid=$stues[0]['pid'];

			$res = $model->update($data,$where);
			if($res){
				header('location:'.ADMIN_URL.'/category/miaosha.php?pid='.$pid);
			}
			break;

			case 'del':
				$id=$_GET['id'];
				$sql="select * from `category` where pid=$id";

				$res=$model->find($sql);
			
				if(!empty($res))
				{
					error('你想让他断子绝孙码?');
					return false;
				}else
				{
					$res1=$model->del($id);
					success('删除成功',ADMIN_URL.'/category/miaosha.php',1);
					return false; 
				}
	}