<?php /*a:1:{s:64:"C:\wamp64\www\jinxiaocun\application\index\view\Hout\cangku.html";i:1553299200;}*/ ?>
<style>
	.beijing:hover{
		color: red;
	}
</style>
<div id="hout_cangku_zhuti">
	<div style="width: 200px; height: 200px;position: relative;left: 10px; top: 5px">
		<div class="form-group">
		    <label >仓库名称</label>
		    <input type="text" class="form-control" id="hout_cangku_name" placeholder="仓库名称">
		</div>

		<div class="form-group">
		    <label >仓库地址</label>
		    <input type="text" class="form-control" id="hout_cangku_dizhi" placeholder="地址">
		</div>

		<div class="form-group">
		    <label >联系方式</label>
		    <input type="text" class="form-control" id="hout_cangku_lianxfs" placeholder="联系方式">
		</div>

		<button class="btn btn-primary" style="width: 98%" id="hout_cangku_insert" >新增</button>
		<input type="hidden" id="hout_cangku_id">
	</div>


	<div style="position: relative; top: -190px; left: 250px; width: 60%;">
		<table class="table table-bordered">
			<tr>
				<th>ID</th>
				<th>仓库名称</th>
				<th>地址</th>
				<th>联系方式</th>
				<th>操作</th>
			</tr>
			<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr>
					<td><?php echo htmlentities($i); ?></td>
					<td><?php echo htmlentities($vo['cangk_name']); ?></td>
					<td><?php echo htmlentities($vo['cangk_dizhi']); ?></td>
					<td><?php echo htmlentities($vo['cangk_lianxfs']); ?></td>
					<td>
						<span class="beijing cangk_del glyphicon glyphicon-remove" data-id="<?php echo htmlentities($vo['id']); ?>"></span>
						<span class="beijing cangk_xiug glyphicon glyphicon-pencil" data-id="<?php echo htmlentities($vo['id']); ?>" data-name="<?php echo htmlentities($vo['cangk_name']); ?>" data-dizhi="<?php echo htmlentities($vo['cangk_dizhi']); ?>" data-lianxfs="<?php echo htmlentities($vo['cangk_lianxfs']); ?>" style="margin-left: 10px"></span>

					</td>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</div>

<script type="text/javascript">
	$('#hout_cangku_insert').click(function(event) {
		$(this).attr('disabled', 'disabled');
		if($(this).text() != '修改'){
			$.ajax({
				type: 'post',
				url:'<?php echo url("Hout/cangku_do"); ?>',
				data:{
					cangku_name: $('#hout_cangku_name').val(),
					cangku_dizhi: $('#hout_cangku_dizhi').val(),
					cangku_lianxfs: $('#hout_cangku_lianxfs').val()
				},
				success: function(msg){
					showtz(msg['msg'],'');
					$('#hout_cangku_name').val('');
					$('#hout_cangku_dizhi').val('');
					$('#hout_cangku_lianxfs').val('');
					var zhuti = $('#hout_cangku_zhuti').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/cangku"); ?>');

				}
			})
		}else{
			$.ajax({
				type: 'post',
				url:'<?php echo url("Hout/cangku_update"); ?>',
				data:{
					cangku_name: $('#hout_cangku_name').val(),
					cangku_dizhi: $('#hout_cangku_dizhi').val(),
					cangku_lianxfs: $('#hout_cangku_lianxfs').val(),
					id: $('#hout_cangku_id').val()
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_cangku_zhuti').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/cangku"); ?>');
				}
			})
		}
		
	});


	$('.cangk_del').click(function(event) {
		var id = $(this).attr('data-id');
		if(confirm('确认要删除吗？')){
			$.ajax({
				type: 'post',
				url:'<?php echo url("Hout/cangku_del"); ?>',
				data:{
					id: id
				},
				success: function(msg){
					showtz(msg['msg'],'');
				}
			})
			var zhuti = $('#hout_cangku_zhuti').parent();
			zhuti.empty();
			zhuti.load('<?php echo url("Hout/cangku"); ?>');
		}
	});


	$('.cangk_xiug').click(function(event) {
		var id = $(this).attr('data-id');
		$('#hout_cangku_id').val(id);
		$('#hout_cangku_name').val($(this).attr('data-name'));
		$('#hout_cangku_dizhi').val($(this).attr('data-dizhi'));
		$('#hout_cangku_lianxfs').val($(this).attr('data-lianxfs'));
		$('#hout_cangku_insert').text('修改');
	});
</script>