<?php /*a:1:{s:64:"C:\wamp64\www\jinxiaocun\application\index\view\Hout\gongys.html";i:1553299200;}*/ ?>

<style>
	.form-group{
		margin-left: 15px
	}

	.glyphicon:hover{
		color: red;
		cursor: pointer;
	}
</style>
<div id="hout_gongys_zhut" style="margin-top: 10px;">
	<div style="display: flex;flex-direction: row;">
		<div class="form-group" >
		    <label for="hout_gongys_name">供应商</label>
		    <input type="text" class="form-control" id="hout_gongys_name" placeholder="供应商">
		    <input type="hidden" id='hout_gongys_id'>
		</div>

		<div class="form-group">
		    <label for="hout_gongys_dizhi">地址</label>
		    <input type="text" class="form-control" id="hout_gongys_dizhi" placeholder="地址">
		</div>

		<div class="form-group">
		    <label for="hout_gongys_lianxr">联系人</label>
		    <input type="text" class="form-control" id="hout_gongys_lianxr" placeholder="联系人">
		</div>
	
		<div class="form-group">
		    <label for="hout_gongys_lianxfs">联系方式</label>
		    <input type="text" class="form-control" id="hout_gongys_lianxfs" placeholder="联系方式">
		</div>

		<button class="btn btn-primary" id="hout_gongys_insert" style="height: 35px; margin-top: 23px; width: 72px; margin-left: 10px">新增</button>

		<button class="btn btn-info" id="hout_gongys_daoru" data-toggle="modal" data-target="#hout_gongys_daoru_modal" style="height: 35px; margin-top: 23px; width: 72px; margin-left: 10px">导入</button>

	</div>


	<div class="modal fade" id="hout_gongys_daoru_modal" tabindex="100" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myModalLabel">供应商导入</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="gongys_upload" enctype="multipart/form-data" method="post">
		            	<div class="form-group">
		            		<label for="exampleInputFile">导入文件</label>
		            		<input type="file" name="excel" id="gongysuploadfile"> 
		            		<p><a href="public/daoru/gongys.xls">下载模板文件</a></p>
		            	</div>
	            	</form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary" id="gongys_daoru_do" data-dismiss="modal">上传</button>
	            </div>
	        </div>
	    </div>
	</div>




	<div style="margin-left: 10px">
		<table class="table table-bordered">
			<tr>
				<th>ID</th>
				<th>供应商</th>
				<th>地址</th>
				<th>联系人</th>
				<th>联系方式</th>
				<th>操作</th>
			</tr>
			<tbody>
				<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td style="width: 60px"><?php echo htmlentities($i); ?></td>
						<td style="text-align: left"><?php echo htmlentities($vo['gongys_name']); ?></td>
						<td style="text-align: left"><?php echo htmlentities($vo['gongys_dizhi']); ?></td>
						<td><?php echo htmlentities($vo['gongys_lianxr']); ?></td>
						<td><?php echo htmlentities($vo['gongys_lianxfs']); ?></td>
						<td>
							<span class="glyphicon glyphicon-pencil gongyslist" id="<?php echo htmlentities($vo['id']); ?>"></span>
							<span class="glyphicon glyphicon-remove gongyslist" id="<?php echo htmlentities($vo['id']); ?>" style="margin-left: 10px"></span>
						</td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
	
	<script type="text/javascript">
		$('.glyphicon').click(function(event) {
			if($(this).hasClass('gongyslist')){
				if($(this).hasClass('glyphicon-pencil')){
					//修改
					var zhuti = $(this).parent().parent().children('td');
					$('#hout_gongys_id').val($(this).attr('id'));
					$('#hout_gongys_name').val(zhuti.eq(1).text());
					$('#hout_gongys_dizhi').val(zhuti.eq(2).text());
					$('#hout_gongys_lianxr').val(zhuti.eq(3).text());
					$('#hout_gongys_lianxfs').val(zhuti.eq(4).text())
					$('#hout_gongys_insert').text('修改');
				}else{
					//删除
					if(confirm('确定删除？？')){
						$.ajax({
							type: 'post',
							url: '<?php echo url("Hout/gongys_del"); ?>',
							data:{
								id: $(this).attr('id'),
							},
							success: function(msg){
								showtz(msg['msg'],'');
								var zhuti = $('#hout_gongys_zhut').parent();
									zhuti.empty();
									zhuti.load('<?php echo url("Hout/gongys"); ?>');
							}
						})
					}
				}
			}
		});


		$('#hout_gongys_insert').click(function(event) {
			$(this).attr('disabled', 'disabled');
			if($(this).text()=='新增'){
				$.ajax({
					type: 'post',
					url: '<?php echo url("Hout/gongys_do"); ?>',
					data:{
						name: $('#hout_gongys_name').val(),
						dizhi: $('#hout_gongys_dizhi').val(),
						lianxr: $('#hout_gongys_lianxr').val(),
						lianxfs: $('#hout_gongys_lianxfs').val()
					},
					success: function(msg){
						showtz(msg['msg'],'');
						var zhuti = $('#hout_gongys_zhut').parent();
						zhuti.empty();
						zhuti.load('<?php echo url("Hout/gongys"); ?>');
					}
				})
			}else{
				$.ajax({
					type: 'post',
					url: '<?php echo url("Hout/gongys_update_do"); ?>',
					data:{
						id: $('#hout_gongys_id').val(),
						name: $('#hout_gongys_name').val(),
						dizhi: $('#hout_gongys_dizhi').val(),
						lianxr: $('#hout_gongys_lianxr').val(),
						lianxfs: $('#hout_gongys_lianxfs').val()
					},
					success: function(msg){
						showtz(msg['msg'],'');
						var zhuti = $('#hout_gongys_zhut').parent();
						zhuti.empty();
						zhuti.load('<?php echo url("Hout/gongys"); ?>');
					}
				})
			}
		});


		$('#gongys_daoru_do').click(function(event) {
			uploadfile('gongys_upload');
		});


		function uploadfile(fid){  
	        var data = new FormData($('#' + fid)[0]);  
	        $.ajax({  
	            url: '<?php echo url("Hout/gongysdaoru"); ?>',  
	            type: 'POST',  
	            data: data,  
	            dataType: 'JSON',  
	            cache: false,  
	            processData: false,  //不处理发送的数据，因为data值是FormData对象，不需要对数据做处理 
	            contentType: false,
	            success: function(msg){
	            	$('#hout_gongys_daoru_modal').modal('hide');
					var zhuti = $('#hout_gongys_zhut').parent();
					zhuti.empty();
					zhuti.load("<?php echo url('Hout/gongys'); ?>");
					showtz(msg['msg'],'');
	            }
	        });  
	        return false;  
	    }
	</script>
	
</div>
