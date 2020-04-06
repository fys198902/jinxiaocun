<?php /*a:1:{s:70:"C:\wamp64\www\jinxiaocun\application\index\view\Xiaos\xiaos_print.html";i:1553126400;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>销售单打印</title>

	<style>
		.table{
			width: 960px;
			border-collapse: collapse;
		}

		.table th,td{
			border: 1px solid black;
			padding: 3px;
		}

		span{
			padding: 1px;
		}
	    
	</style>


	<style media="print">
		@page {
	      size: auto;  /* auto is the initial value */
	      margin: 0mm; /* this affects the margin in the printer settings */
	    }
	</style>
</head>
<body style="text-align: center;">
	<div style="width: 960px;margin:0 auto; padding-left: 40px; padding-right: 40px">
		<h3 style="text-align: center; font-size: 26px; margin: 20px 0 0 0"><?php echo htmlentities(app('session')->get('zhangtao_name')); ?>销售出库单</h3>
		<span style="display: flex;justify-content: space-between; font-size: 20px">
			<span>客户名称：<?php echo htmlentities($row[0]['kehu_name']); ?>-<?php echo htmlentities($row[0]['kehu_dizhi']); ?></span>
			<span>联系方式：<?php echo htmlentities($row[0]['kehu_lianxfs']); ?></span>
		</span>
		
		<span style="display: flex;justify-content: space-between; font-size: 20px">
			<span>仓库：<?php echo htmlentities($row[0]['cangk_name']); ?></span>
			<span>日期：<?php echo htmlentities($row[0]['xiaos_date']); ?></span>
			<span>单据ID：<?php echo htmlentities($row[0]['xiaos_xt_id']); ?></span>
		</span>
		<span style="float: left; margin-bottom: 10px">摘要：<?php echo htmlentities($row[0]['xiaos_zhaiy']); ?></span>
		<table class="table" style="font-size: 20px">
			<tr>
				<th style="width: 50px">ID</th>
				<th style="width: 200px">物料名称</th>
				<th style="width: 50px">单位</th>
				<th style="width: 80px">数量</th>
				<th style="width: 80px">单价</th>
				<th style="width: 80px">金额</th>
				<th>备注</th>
			</tr>

			<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;$jineheji = $jineheji + $vo['jine']; $shulheji = $shulheji + $vo['shul']; ?>

				<tr>
					<td><?php echo htmlentities($i); ?></td>
					<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
					<td><?php echo htmlentities($vo['danw_name']); ?></td>
					<td><?php echo htmlentities($vo['shul']); ?></td>
					<td><?php echo htmlentities($vo['danj']); ?></td>
					<td><?php echo htmlentities($vo['jine']); ?></td>
					<td><?php echo htmlentities($vo['beizhu']); ?></td>

				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>

			<tr>
				<td>合计</td>
				<td></td>
				<td></td>
				<td><?php echo htmlentities($shulheji); ?></td>
				<td></td>
				<td><?php echo htmlentities($jineheji); ?></td>
				<td></td>
			</tr>
		</table>

		<span style="display: flex;justify-content: space-between;margin-top: 10px">
			<span style="margin-left: 100px">客户签字：</span>
			<?php if($row[0]['cangk_lianxfs'] != ''): ?>
				<span style="margin-left: 200px">送货人：</span>
				<span style="font-size: 22px;position: relative;top: -5px">送货电话：<b><?php echo htmlentities($row[0]['cangk_lianxfs']); ?></b></span>
			<?php else: ?>
				<span style="margin-right: 100px">送货人：</span>
			<?php endif; ?>
		</span>
	</div>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>