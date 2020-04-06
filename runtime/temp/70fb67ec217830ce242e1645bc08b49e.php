<?php /*a:1:{s:69:"C:\wamp64\www\jinxiaocun\application\index\view\Cangchu\taizhang.html";i:1585900240;}*/ ?>
<div id="taizhang_list" style="margin-left: 10px; margin-top: 10px">

	<div class="navbar-form navbar-right">
		<div class="form-group">
			<input type="text" id="taizhang_ksrq" style="width: 150px" class="form-control" value="<?php echo htmlentities($ksrq); ?>" placeholder="开始日期">
		</div>
		<div class="form-group">
			<input type="text" id="taizhang_jsrq" style="width: 150px" class="form-control" value="<?php echo htmlentities($jsrq); ?>" placeholder="结束日期">
		</div>

		<div class="form-group">
			<select id="taizhang_pinz" class="form-control">
				<option value="<?php echo htmlentities($pinz_val); ?>"><?php echo htmlentities($pinz_val); ?></option>
				<?php if(is_array($pinzhong) || $pinzhong instanceof \think\Collection || $pinzhong instanceof \think\Paginator): $i = 0; $__LIST__ = $pinzhong;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['wuliao_name']); ?>"><?php echo htmlentities($vo['wuliao_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>

		<div class="form-group">
			<select id="taizhang_cangk" class="form-control">
				<option value="<?php echo htmlentities($cangk_val); ?>"><?php echo htmlentities($cangk_val); ?></option>
				<?php if(is_array($cangk) || $cangk instanceof \think\Collection || $cangk instanceof \think\Paginator): $i = 0; $__LIST__ = $cangk;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['cangk_name']); ?>"><?php echo htmlentities($vo['cangk_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>


		<button id="taizhang_search" class="btn btn-primary" style="margin-left: 8px">查询</button>
	</div>




	<div style="overflow-x: auto; width: 99%" id="cangchu_taizhang">
		<table class="table table-bordered" style="min-width: 1000px">
			<tr>
				<th style="width: 120px">单据日期</th>
				<th style="width: 70px">类别</th>
				<th style="width: 120px">单据编号</th>	
				<th>核算项目</th>	
				<th>物料名称</th>	
				<th>基本数量</th>	
				<th>常用数量</th>
				<th>库存基本</th>
				<th>库存常用</th>
				<th>制单人</th>
			</tr>

			<tr>
				<td>期初库存</td>
				<td colspan="5"></td>
				<td></td>
				<td><?php echo htmlentities($qichu); ?></td>
				<td><?php echo htmlentities($qichu_cy); ?></td>
			</tr>
			<?php 
				$kucun=$qichu;
				$kucun_cy = $qichu_cy;
			 if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;$kucun = $vo['shul'] + $kucun; $kucun_cy = $vo['changyong'] + $kucun_cy; ?>
				
				<tr>
					<td><?php echo htmlentities($vo['fdate']); ?></td>
					<td><?php echo htmlentities($vo['leibie']); ?></td>
					<td><?php echo htmlentities($vo['bianhao']); ?></td>
					<td style="text-align: left"><?php echo htmlentities($vo['xiangmu']); ?></td>
					<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
					<td><?php echo htmlentities($vo['shul']); ?></td>
					<td><?php echo htmlentities($vo['changyong']); ?></td>
					<td><?php echo htmlentities($kucun); ?></td>
					<td><?php echo htmlentities($kucun_cy); ?></td>
					<td><?php echo htmlentities($vo['username']); ?></td>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>

			<tr>
				<td>期末库存</td>
				<td colspan="6"></td>
				<td><?php echo htmlentities($qimo); ?></td>
				<td><?php echo htmlentities($qimo_cy); ?></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>

<script type="text/javascript">
	datelist('taizhang_ksrq');
	datelist('taizhang_jsrq');


	$('#cangchu_taizhang .table tr').click(function(event) {
		$('#cangchu_taizhang .bgcolor').removeClass('bgcolor');
		$(this).toggleClass('bgcolor');
	});


	$('#taizhang_search').click(function(event) {
		var zhuti = $('#taizhang_list').parent();
		var ksrq = $('#taizhang_ksrq').val();
		var jsrq = $('#taizhang_jsrq').val();
		var pinzhong = $('#taizhang_pinz').val();
		var cangk = $('#taizhang_cangk').val();
		zhuti.empty();
		zhuti.append('<div class="loading"></div>');

		zhuti.load('<?php echo url("Cangchu/taizhang"); ?>?ksrq=' + ksrq + '&jsrq=' + jsrq + '&pinzhong=' + pinzhong + '&cangk=' + cangk, function(){
			$('.loading').hide();
		});
	});

</script>