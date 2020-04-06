<?php /*a:1:{s:66:"C:\wamp64\www\jinxiaocun\application\index\view\Cangchu\jishi.html";i:1553126400;}*/ ?>
<div id="cangchu_jishi" style="margin-left: 10px; margin-top: 10px">
	<div class="navbar-form navbar-right">
		<div class="form-group">
			<input type="text" id="jishi_date" style="width: 150px" class="form-control" value="<?php echo htmlentities($fdate); ?>" placeholder="截止日期">
		</div>

		<button id="jishi_search" class="btn btn-primary" style="margin-left: 8px">查询</button>
		<button id="jishi_pand_print" class="btn btn-warning" style="margin-left: 8px">盘点表打印</button>

	</div>


	<div>
		<table class="table table-bordered table-striped">
			<tr>
				<th>仓库名称</th>
				<th>物料名称</th>
				<th>基本数量</th>
				<th>常用数量</th>
			</tr>

			<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr>
					<td><?php echo htmlentities($vo['cangk_name']); ?></td>
					<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
					<td><?php echo htmlentities($vo['jiben']); ?></td>
					<td><?php echo htmlentities(round($vo['jiben']/$vo['huansuan'],2)); ?></td>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</div>


<script type="text/javascript">
	datelist('jishi_date');
	
	$('#jishi_search').click(function(event) {
		var zhuti = $('#cangchu_jishi').parent();
		var fdate = $('#jishi_date').val();
		zhuti.empty();
		zhuti.load('<?php echo url("Cangchu/jishi"); ?>?fdate=' + fdate);
	});

	$('#jishi_pand_print').click(function(event) {
		window.open('<?php echo url("Cangchu/jishi"); ?>?print=1');
	});
</script>