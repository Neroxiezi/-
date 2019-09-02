<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/2
	 * Time: 上午11:06
	 * ----------------------------------------
	 *
	 */

	require_once __DIR__.'/redis_link.php';
	/**
	 *  设置消息点赞
	 */
	$member_id = $_GET['member_id'] ?? 1;
	$msg_id = 1;
	// 判断用户是否点过赞
	if ($redis->sIsMember('like:'.$msg_id, $member_id)) {
		// 如果过赞 则取消点赞
		$redis->sRem('like:'.$msg_id, $member_id);
		echo '用户:'.$member_id." 取消点赞\n";
	} else {
		$redis->sAdd('like:'.$msg_id, $member_id);
		echo '用户:'.$member_id." 点赞成功\n";
	}

	echo '<pre>';
	echo '消息'.$msg_id."点赞列表:\n";
	print_r($redis->sMembers("like:".$msg_id));