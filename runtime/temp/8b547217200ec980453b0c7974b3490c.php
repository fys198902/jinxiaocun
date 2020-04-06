<?php /*a:1:{s:67:"C:\wamp64\www\jinxiaocun\application\index\view\Caig\caig_list.html";i:1585900466;}*/ ?>
<style>
	.navbar-form{
		display: flex;
		justify-content: space-between;
	}

	.form-group{
		margin-left: 8px;
	}


</style>


<div id="caigou_list_zhuti" style="width: 99%; text-align: right">
	<div class="navbar-form navbar-right">
		<div class="form-group">
			<input type="text" id="caig_list_search_ksrq" style="width: 150px" class="form-control" value="<?php echo htmlentities($ksrq); ?>" placeholder="开始日期">
		</div>
		<div class="form-group">
			<input type="text" id="caig_list_search_jsrq" style="width: 150px" class="form-control" value="<?php echo htmlentities($jsrq); ?>" placeholder="结束日期">
		</div>
		<div class="form-group">
			<input type="text" id="caig_list_search_gongys" style="width: 150px" class="form-control" value="<?php echo htmlentities($gongys); ?>" placeholder="供应商/单据ID">
		</div>
		<div class="form-group">
			<input type="text" id="caig_list_search_pinzhong" style="width: 150px" class="form-control" value="<?php echo htmlentities($pinzhong); ?>" placeholder="品种">
		</div>
		<div class="form-group">
			<input type="text" id="caig_list_search_beizhu" style="width: 150px" class="form-control" value="<?php echo htmlentities($beizhu); ?>" placeholder="备注">
		</div>
		<button id="caig_list_search" class="btn btn-primary" style="margin-left: 8px">查询</button>
		<button id='caig_list_del' class="btn btn-warning" style="margin-left: 10px">删除</button>
		<button  id='caig_list__daoc' class="btn btn-info" style="margin-left: 10px">导出</button>

	</div>
	
</div>



<div id="caiglistdiv" style="width: 99%;overflow-x: auto;">
	<table class="table table-bordered table-condensed" style="min-width:1280px;">
		<th style="width: 60px">ID</th>
		<th style="width: 136px">单据ID</th>
		<th style="width: 100px">日期</th>
		<th style="width: 210px">供应商</th>
		<th style="width: 180px">物料名称</th>
		<th style="width: 60px">单位</th>
		<th style="width: 80px">数量</th>
		<th style="width: 80px">单价</th>
		<th style="width: 80px">金额</th>
		<th>备注</th>
		<th style="width: 80px">制单人</th>
		<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<tr>
				<td><?php echo htmlentities($i + ($dangqianye-1)*20); ?></td>
				<td class="caigouxtid"><?php echo htmlentities($vo['caig_xt_id']); ?> <input type="hidden" class="caigouid" value="<?php echo htmlentities($vo['id']); ?>"></td>
				<td><?php echo htmlentities($vo['caig_date']); ?></td>
				<td style="text-align: left"><?php echo htmlentities($vo['gongys_name']); ?>-<?php echo htmlentities($vo['gongys_dizhi']); ?></td>
				<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
				<td><?php echo htmlentities($vo['danw_name']); ?></td>
				<td><?php echo htmlentities($vo['shul']); ?></td>
				<td><?php echo htmlentities($vo['danj']); ?></td>
				<td><?php echo htmlentities($vo['jine']); ?></td>
				<td><?php echo htmlentities($vo['beizhu']); ?></td>
				<td><?php echo htmlentities($vo['username']); ?></td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>

		<tr class="caigou_list" style="text-align: center;border: none">
			<td colspan="11">
				<ul class="pagination" style="margin: 0px;padding: 0px">
				<li><a href="#" id="<?php echo htmlentities($shangyiye); ?>">&laquo;</a></li>
				<?php $__FOR_START_1571128977__=$qishiye;$__FOR_END_1571128977__=$jieshuye;for($i=$__FOR_START_1571128977__;$i < $__FOR_END_1571128977__;$i+=1){ ?>
					<li <?php if($i+1==$dangqianye): ?> class="active" <?php endif; ?>><a href="#" id="<?php echo htmlentities($i+1); ?>"><?php echo htmlentities($i+1); ?></a></li>
				<?php } ?>
				<li><a href="#" id="<?php echo htmlentities($xiayiye); ?>"><span>&raquo;</span></a></li>
			</ul>
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	datelist('caig_list_search_ksrq');
	datelist('caig_list_search_jsrq');

	$('#caiglistdiv').css('height',parseFloat($(window).height())-175);

	$('#caiglistdiv .table tr').click(function(event) {
		$('#caiglistdiv .bgcolor').removeClass('bgcolor');
		$(this).toggleClass('bgcolor');
	});


	$('#caiglistdiv .table tr').dblclick(function(event) {
		var caigid = $(this).find('.caigouid').val();
		var caigxtid = $(this).find('.caigouxtid').text();
		addtabs('list' + (parseInt($('.nav-tabs').children('li').length)+1),caigxtid + '修改','caig/caig_update?id=' + caigid);

	});

	$('.caigou_list .pagination a').click(function(event) {
		var id = $(this).attr('id');
		var zhuti = $('#caiglistdiv').parent();
		var ksrq = $('#caig_list_search_ksrq').val();
		var jsrq = $('#caig_list_search_jsrq').val();
		var gongys = $('#caig_list_search_gongys').val();
		var pinzhong = $('#caig_list_search_pinzhong').val();
		var beizhu = $('#caig_list_search_beizhu').val();

		zhuti.empty();
		zhuti.append('<div class="loading"></div>');

		zhuti.load("<?php echo url('Caig/caig_list'); ?>?page=" + id + '&ksrq=' + ksrq + '&jsrq=' + jsrq + '&gongys=' + gongys + '&pinzhong=' + pinzhong + '&beizhu=' + beizhu, function(){
			$('.loading').hide();
		});
	});


	$('#caig_list_del').click(function(event) {
		var liid = $(this).parent().parent().attr('id');
		$('#caiglistdiv .bgcolor').each(function(index, el) {
			var xtid=$(this).find('.caigouxtid').text();
			var id=$(this).find('.caigouid').val();
			if(confirm(xtid + "确定要删除吗？")){
				$.ajax({
					url: '<?php echo url("Caig/caig_del"); ?>',
					type: 'post',
					data: {
						caig_id: id,
						caig_xtid: xtid,
					},
					success: function(msg){
						showtz(msg['msg'],'');
						$('#' + liid).load('<?php echo url("Caig/caig_list"); ?>');
					}
				})				
			}
		});
	});

	$('#caig_list_search').click(function(event) {
		var zhuti = $('#caigou_list_zhuti').parent();
		var ksrq = $('#caig_list_search_ksrq').val();
		var jsrq = $('#caig_list_search_jsrq').val();
		var gongys = $('#caig_list_search_gongys').val();
		var pinzhong = $('#caig_list_search_pinzhong').val();
		var beizhu = $('#caig_list_search_beizhu').val();
		zhuti.empty();


		zhuti.load('<?php echo url("Caig/caig_list"); ?>?ksrq=' + ksrq + '&jsrq=' + jsrq + '&gongys=' + gongys + '&pinzhong=' + pinzhong + '&beizhu=' + beizhu);
	});


	$('#caig_list__daoc').click(function(event) {
		var ksrq = $('#caig_list_search_ksrq').val();
		var jsrq = $('#caig_list_search_jsrq').val();
		var gongys = $('#caig_list_search_gongys').val();
		var pinzhong = $('#caig_list_search_pinzhong').val();
		var beizhu = $('#caig_list_search_beizhu').val();

		window.open('<?php echo url("Caig/caigoudaochu"); ?>?ksrq=' + ksrq + '&jsrq=' + jsrq + '&gongys=' + gongys + '&pinzhong=' + pinzhong + '&beizhu=' + beizhu);
	});
</script>
