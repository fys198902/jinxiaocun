<?php /*a:1:{s:69:"C:\wamp64\www\jinxiaocun\application\index\view\Xiaos\xiaos_list.html";i:1585900347;}*/ ?>
<style>
	.navbar-form{
		display: flex;
		justify-content: space-between;
	}

	.form-group{
		margin-left: 8px;
	}
</style>

<div id="xiaoshou_list_zhut" style="width: 99%; text-align: right">
	<div class="navbar-form navbar-right" role="search">
		<div class="form-group">
			<input type="text" id="xiaos_list_search_ksrq" style="width: 150px" class="form-control" value="<?php echo htmlentities($ksrq); ?>" placeholder="开始日期">
		</div>
		<div class="form-group">
			<input type="text" id="xiaos_list_search_jsrq" style="width: 150px" class="form-control" value="<?php echo htmlentities($jsrq); ?>" placeholder="结束日期">
		</div>
		<div class="form-group">
			<input type="text" id="xiaos_list_search_kehu" style="width: 150px" class="form-control" value="<?php echo htmlentities($kehu); ?>" placeholder="客户/单据ID">
		</div>
		<div class="form-group">
			<input type="text" id="xiaos_list_search_pinzhong" style="width: 150px" class="form-control" value="<?php echo htmlentities($pinzhong); ?>" placeholder="品种/备注">
		</div>

		<button id="xiaos_list_search" class="btn btn-primary" style="margin-left: 8px">查询</button>
		<button class="btn btn-warning" style="margin-left: 10px" id='xiaos_list_del'>删除</button>
		<button class="btn btn-info" style="margin-left: 10px" id='xiaos_list_daoc'>导出</button>
	</div>
	
</div>




<div id="xiaoslistdiv" style="width: 99%;overflow: auto;">
	<table class="table table-bordered table-condensed" style="min-width:1360px;">
		<th style="width: 60px">ID</th>
		<th style="width: 136px">单据ID</th>
		<th style="width: 100px">日期</th>
		<th style="width: 210px">客户</th>
		<th style="width: 180px">物料名称</th>
		<th style="width: 60px">单位</th>
		<th style="width: 80px">数量</th>
		<th style="width: 80px">单价</th>
		<th style="width: 80px">金额</th>
		<th>备注</th>
		<th style="width: 80px">制单人</th>

		<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<tr class="xiaos_list_table">
				<td><?php echo htmlentities($i); ?></td>
				<td class="xiaos_list_xtid"><?php echo htmlentities($vo['xiaos_xt_id']); ?> <input type="hidden" class="xiaos_list_id" value="<?php echo htmlentities($vo['id']); ?>"></td>
				<td><?php echo htmlentities($vo['xiaos_date']); ?></td>
				<td style="text-align: left;"><?php echo htmlentities($vo['kehu_name']); ?>-<?php echo htmlentities($vo['kehu_dizhi']); ?></td>
				<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
				<td><?php echo htmlentities($vo['danw_name']); ?></td>
				<td><?php echo htmlentities($vo['shul']); ?></td>
				<td><?php echo htmlentities($vo['danj']); ?></td>
				<td><?php echo htmlentities($vo['jine']); ?></td>
				<td><?php echo htmlentities($vo['beizhu']); ?></td>
				<td><?php echo htmlentities($vo['username']); ?></td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; if(is_array($row_juhe) || $row_juhe instanceof \think\Collection || $row_juhe instanceof \think\Paginator): $i = 0; $__LIST__ = $row_juhe;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<tr>
				<td>合计</td>
				<td colspan="4"></td>
				<td><?php echo htmlentities($vo['danw_name']); ?></td>
				<td><?php echo htmlentities($vo['xiaolheji']); ?></td>
				<td></td>
				<td><?php echo htmlentities($vo['jineheji']); ?></td>
				<td></td>
				<td></td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</table>

</div>

<script type="text/javascript">
	datelist('xiaos_list_search_ksrq');
	datelist('xiaos_list_search_jsrq');

	$('#xiaoslistdiv .table tr').click(function(event) {
		$('.bgcolor').removeClass('bgcolor');
		$(this).toggleClass('bgcolor');
	});

	$('#xiaoslistdiv').css('height',parseFloat($(window).height())-195);


	$('#xiaoslistdiv .table tr').dblclick(function(event) {
		var xiaosid = $(this).find('.xiaos_list_id').val();
		var xiaosxtid = $(this).find('.xiaos_list_xtid').text();
		addtabs('list' + (parseInt($('.nav-tabs').children('li').length)+1),xiaosxtid + '修改','xiaos/xiaos_update?id=' + xiaosid);

	});

	$('.xiaoshou_list .pagination a').click(function(event) {
		var id = $(this).attr('id');
		var zhuti = $('#xiaoslistdiv').parent();
		var ksrq = $('#xiaos_list_search_ksrq').val();
		var jsrq = $('#xiaos_list_search_jsrq').val();
		var kehu = $('#xiaos_list_search_kehu').val();
		var pinzhong = $('#xiaos_list_search_pinzhong').val();
		zhuti.empty();
		zhuti.load("<?php echo url('xiaos/xiaos_list'); ?>?page=" + id + '&ksrq=' + ksrq + '&jsrq=' + jsrq + '&kehu=' + kehu + '&pinzhong=' + pinzhong);
	});


	$('#xiaos_list_del').click(function(event) {
		var liid = $(this).parent().parent().attr('id');
		$('#xiaoslistdiv .bgcolor').each(function(index, el) {
			var xtid=$(this).find('.xiaos_list_xtid').text();
			var id=$(this).find('.xiaos_list_id').val();
			if(confirm(xtid + "确定要删除吗？")){
				$.ajax({
					url: '<?php echo url("xiaos/xiaos_del"); ?>',
					type: 'post',
					data: {
						xiaos_id: id,
						xiaos_xtid: xtid,
					},
					success: function(msg){
						showtz(msg,'');
						$('#' + liid).load('<?php echo url("xiaos/xiaos_list"); ?>');
					}
				})				
			}
		});
	});


	$('#xiaos_list_search').click(function(event) {
		var zhuti = $('#xiaoshou_list_zhut').parent();
		var ksrq = $('#xiaos_list_search_ksrq').val();
		var jsrq = $('#xiaos_list_search_jsrq').val();
		var kehu = $('#xiaos_list_search_kehu').val();
		var pinzhong = $('#xiaos_list_search_pinzhong').val();
		zhuti.empty();
		zhuti.append('<div class="loading"></div>');

		zhuti.load('<?php echo url("Xiaos/xiaos_list"); ?>?ksrq=' + ksrq + '&jsrq=' + jsrq + '&kehu=' + kehu + '&pinzhong=' + pinzhong, function(){
			$('.loading').hide();
		});
	});


	$('#xiaos_list_daoc').click(function(event) {
		var ksrq = $('#xiaos_list_search_ksrq').val();
		var jsrq = $('#xiaos_list_search_jsrq').val();
		var kehu = $('#xiaos_list_search_kehu').val();
		var pinzhong = $('#xiaos_list_search_pinzhong').val();

		window.open('<?php echo url("Xiaos/xiaosdaochu"); ?>?ksrq=' + ksrq + '&jsrq=' + jsrq + '&kehu=' + kehu + '&pinzhong=' + pinzhong);
	});
</script>
