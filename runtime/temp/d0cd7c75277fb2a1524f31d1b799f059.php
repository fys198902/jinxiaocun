<?php /*a:1:{s:71:"C:\wamp64\www\jinxiaocun\application\index\view\Caiwu\yuemojiesuan.html";i:1553299200;}*/ ?>
<div id='yuemo' style="margin-left: 10px">
	<div style="display: flex; justify-content: flex-end; margin-top: 10px">
		<span style="line-height: 32px; margin-right: 20px"><b>已结账期间：</b><?php echo htmlentities($lastyue); ?></span>
		<input type="text" class="form-control" style="width: 150px; margin-right: 5px;text-align: center;" id="jiesuanyue" placeholder="结算期间" value="<?php echo htmlentities($yuefen); ?>">
		<button class="btn btn-success" id='chengb_jisuan'>计算</button>
	</div>

	<div style="margin-top: 10px">
		<h4>一、上期单位成本</h4>
			<table class="table">
				<tr>
					<td style="width: 60px">ID</td>
					<td>物料</td>
					<td style="width: 160px">初期数量-基本</td>
					<td style="width: 160px">期初金额-基本</td>
					<td style="width: 160px">期初成本</td>
				</tr>
				
				<?php if(is_array($shangqi) || $shangqi instanceof \think\Collection || $shangqi instanceof \think\Paginator): $i = 0; $__LIST__ = $shangqi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo htmlentities($i); ?></td>
						<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
						<td><?php echo htmlentities($vo['shul']); ?></td>
						<td><?php echo htmlentities($vo['jine']); ?></td>
						<?php if($vo['shul']>0): ?>
							<td><?php echo htmlentities(round($vo['jine']/$vo['shul'],2)); ?></td>
						<?php else: ?>
							<td>-</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>

			</table>
		<h4>二、本期购入及单位成本</h4>
		<table class="table">
			<tr>
				<td style="width: 60px">ID</td>
				<td>物料</td>
				<td style="width: 160px">本期购入数量-基本</td>
				<td style="width: 160px">本期购入金额-基本</td>
				<td style="width: 160px">本期购入-成本价</td>
			</tr>

			<?php if(is_array($benqi) || $benqi instanceof \think\Collection || $benqi instanceof \think\Paginator): $i = 0; $__LIST__ = $benqi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr>
					<td><?php echo htmlentities($i); ?></td>
					<td><?php echo htmlentities($vo['wuliao_name']); ?></td>
					<td><?php echo htmlentities($vo['gourushul']); ?></td>
					<td><?php echo htmlentities($vo['gourujine']); ?></td>
					<?php if($vo['gourushul']>0): ?>
						<td><?php echo htmlentities(round($vo['gourujine']/$vo['gourushul'],2)); ?></td>
					<?php else: ?>
						<td>-</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</table>

		<h4>三、本期加权后平均单位成本</h4>
		<table class="table caiwu_jiezhang">
			<tr>
				<td style="width: 60px">ID</td>
				<td>物料</td>
				<td style="width: 160px">合计数量-基本</td>
				<td style="width: 160px">合计金额-基本</td>
				<td style="width: 160px">加权成本</td>
			</tr>

			<?php if(is_array($quanbu) || $quanbu instanceof \think\Collection || $quanbu instanceof \think\Paginator): $i = 0; $__LIST__ = $quanbu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr>
					<td><?php echo htmlentities($i); ?> <input type="hidden" class="chengb_wuliaoid" value="<?php echo htmlentities($vo['id']); ?>"></td>
					<td><?php echo htmlentities($vo['wuliao']); ?>  <input type="hidden" value="<?php echo htmlentities($vo['wuliao']); ?>"></td>
					<td><?php echo htmlentities($vo['shul']); ?> <input type="hidden" class="chengb_shul" value="<?php echo htmlentities($vo['shul']); ?>"></td>
					<td><?php echo htmlentities($vo['jine']); ?> <input type="hidden" class="chengb_jine" value="<?php echo htmlentities($vo['jine']); ?>"></td>
					<?php if($vo['shul']>0): ?>
						<td><?php echo htmlentities(round($vo['jine']/$vo['shul'],2)); ?></td>
					<?php else: ?>
						<td>-</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</table>


		<h4>四、本月实际成本收入及毛利</h4>
		<table class="table">
			<tr>
				<td style="width: 60px">ID</td>
				<td>物料</td>
				<td style="width: 100px">单位换算</td>
				<td>基本数量</td>
				<td>单位成本</td>
				<td>成本合计</td>
				<td>收入合计</td>
				<td>毛利金额</td>
			</tr>
			<?php if(is_array($chengben) || $chengben instanceof \think\Collection || $chengben instanceof \think\Paginator): $i = 0; $__LIST__ = $chengben;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;$zongchengben = $zongchengben + $vo['chengbenjia']; $zongshouru = $zongshouru + $vo['shouru']; ?>

				<tr>
					<td><?php echo htmlentities($i); ?></td>
					<td><?php echo htmlentities($vo['wuliao']); ?></td>
					<td><?php echo htmlentities($vo['huansuan']); ?></td>
					<td><?php echo htmlentities($vo['jibenshul']); ?></td>
					<td><?php echo htmlentities($vo['danwchengb']); ?></td>
					<td><?php echo htmlentities($vo['chengbenjia']); ?></td>
					<td><?php echo htmlentities(round($vo['shouru'],2)); ?></td>
					<td><?php echo htmlentities(round($vo['shouru'] - $vo['chengbenjia'],2)); ?></td>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			<tr>
				<td>合计</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo htmlentities($zongchengben); ?></td>
				<td><?php echo htmlentities(round($zongshouru,2)); ?></td>
				<td><?php echo htmlentities(round($zongshouru - $zongchengben,2)); ?></td>
			</tr>
		</table>

		<h4>五、其他收支及本月折扣</h4>
		<table class="table">
			<tr>
				<td>项目</td>
				<td>金额</td>
			</tr>

			<tr>
				<td>本月毛利</td>
				<td><?php echo htmlentities(round($zongshouru - $zongchengben,2)); ?></td>
			</tr>
			<tr>
				<td>本月折扣</td>
				<td><?php echo htmlentities(round($zhekou*-1,2)); ?></td>
			</tr>
			<tr>
				<td>其他收支</td>
				<td><?php echo htmlentities(round($qitashouzhi[0]['jine'],2)); ?></td>
			</tr>
			<tr>
				<td>本月净利</td>
				<td><?php echo htmlentities($zongshouru - $zongchengben - $zhekou + $qitashouzhi[0]['jine']); ?></td>
			</tr>
		</table>
	</div>

	<div style="text-align: center; margin-bottom: 20px">
		<?php if($statue): ?>
			<button class="btn btn-success" style="width: 120px; margin-right: 20px" id="jiezhang">结账</button>
		<?php else: ?>
			<button class="btn btn-warning" style="width: 120px" id="fanjiezhang">反结账</button>
		<?php endif; ?>
		<button class="btn btn-info" style="width: 120px; margin-right: 20px" id="yuemo_dayin">打印</button>
	</div>
</div>


<script type="text/javascript">
	$('#jiesuanyue').datetimepicker({
		language: "zh-CN",
		format: 'yyyy-mm',
		startView: 3,
		minView: 3,
		autoclose: true//选择后自动关闭
	});

	$('#chengb_jisuan').click(function(event) {
		var zhu = $('#yuemo').parent();
		var yuefen = $('#jiesuanyue').val();
		zhu.empty();

		zhu.load('<?php echo url("caiwu/yuemojiesuan"); ?>?yuefen=' + yuefen);

	});


	$('#jiezhang').click(function(event) {
		if($('#jiesuanyue').val() != ''){
			$('#jiezhang').attr('disabled', 'disabled');
			$.ajax({
				url: '<?php echo url("caiwu/jiezhang_do"); ?>',
				type: 'post',
				data: {
					qijian: $('#jiesuanyue').val(),
					id: getclassval('.caiwu_jiezhang .chengb_wuliaoid'),
					shul: getclassval('.caiwu_jiezhang .chengb_shul'),
					jine: getclassval('.caiwu_jiezhang .chengb_jine')
				},
				success: function(msg){
					if(typeof(msg) == 'string'){
						$('#jiezhang').removeAttr('disabled');
						showtz(msg,'');
						return false;
					}

					if(msg['status'] == 0){
						showtz(msg['msg'],'');
					}else{
						showtz(msg['msg'],'');
						var zhu = $('#yuemo').parent();
						var yuefen = $('#jiesuanyue').val();
						zhu.empty();
						zhu.load('<?php echo url("caiwu/yuemojiesuan"); ?>?yuefen=' + yuefen);
					}
				}
			})
		}else{
			showtz('期间不得为空','');
		}
		
	});


	$('#fanjiezhang').click(function(event) {
		if($('#jiesuanyue').val() != ''){
			$('#fanjiezhang').attr('disabled', 'disabled');
			$.ajax({
				url: '<?php echo url("caiwu/fanjiezhang_do"); ?>',
				type: 'post',
				data: {
					qijian: $('#jiesuanyue').val(),
				},
				success: function(msg){
					if(typeof(msg) == 'string'){
						$('#fanjiezhang').removeAttr('disabled');
						showtz(msg,'');
						return false;
					}

					if(msg['status'] == 0){
						showtz(msg['msg'],'');
					}else{
						showtz(msg['msg'],'');
						var zhu = $('#yuemo').parent();
						var yuefen = $('#jiesuanyue').val();
						zhu.empty();

						zhu.load('<?php echo url("caiwu/yuemojiesuan"); ?>?yuefen=' + yuefen);
					}
				}
			})
		}else{
			showtz('期间不得为空','');
		}
	});

	$('#yuemo_dayin').click(function(event) {
		var yuefen = $('#jiesuanyue').val();
		window.open('<?php echo url("caiwu/yuemojiesuan"); ?>?dayin=1&yuefen=' + yuefen);
	});
</script>