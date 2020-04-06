<?php /*a:1:{s:62:"C:\wamp64\www\jinxiaocun\application\index\view\Hout\kehu.html";i:1553126400;}*/ ?>

<style>
	.form-group{
		margin-left: 15px
	}

	.glyphicon:hover{
		color: red;
		cursor: pointer;
	}
</style>
<div id="hout_kehu_zhut" style="margin-top: 10px;">
	<div style="display: flex;flex-direction: row;">
		<div class="form-group" >
		    <label for="hout_kehu_name">客户</label>
		    <input type="text" class="form-control" id="hout_kehu_name" placeholder="客户" value="<?php echo htmlentities($kehu); ?>">
		    <input type="hidden" id='hout_kehuid'>
		</div>

		<div class="form-group" >
		    <label for="hout_kehu_dizhi">地址</label>
		    <input type="text" class="form-control" id="hout_kehu_dizhi" placeholder="地址" value="<?php echo htmlentities($dizhi); ?>">
		</div>

		<div class="form-group" >
		    <label for="hout_kehu_lianxr">联系人</label>
		    <input type="text" class="form-control" id="hout_kehu_lianxr" placeholder="联系人" value="<?php echo htmlentities($lianxr); ?>">
		</div>
	
		<div class="form-group">
		    <label for="hout_kehu_lianxfs">联系方式</label>
		    <input type="text" class="form-control" id="hout_kehu_lianxfs" placeholder="联系方式" value="<?php echo htmlentities($lianxfs); ?>">
		</div>

		<button class="btn btn-primary" id="hout_kehu_insert" style="height: 35px; margin-top: 23px; width: 72px; margin-left: 10px">新增</button>

		<button class="btn btn-info" id="hout_kehu_chaxun" style="height: 35px; margin-top: 23px; width: 72px; margin-left: 10px">查询</button>

		<button class="btn btn-success" id="hout_kehu_daochu" style="height: 35px; margin-top: 23px; width: 72px; margin-left: 10px">导出</button>
		<button class="btn btn-info" id="hout_kehu_daoru" data-toggle="modal" data-target="#hout_kehu_daoru_modal" style="height: 35px; margin-top: 23px; width: 72px; margin-left: 10px">导入</button>
	</div>


	<div class="modal fade" id="hout_kehu_daoru_modal" tabindex="100" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myModalLabel">客户导入</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="kehu_upload" enctype="multipart/form-data" method="post">
		            	<div class="form-group">
		            		<label for="exampleInputFile">导入文件</label>
		            		<input type="file" name="excel" id="kehuuploadfile"> 
		            		<p><a href="public/daoru/kehu.xls">下载模板文件</a></p>
		            	</div>
	            	</form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary" id="kehu_daoru_do" data-dismiss="modal">上传</button>
	            </div>
	        </div>
	    </div>
	</div>




	<div style="margin-left: 10px" id='hout_kehu_table'>
		<table class="table table-bordered">
			<tr>
				<th>客户</th>
				<th>地址</th>
				<th>联系人</th>
				<th>联系方式</th>
				<th>操作</th>
			</tr>
			<tbody>
				<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td style="text-align: left;"><?php echo htmlentities($vo['kehu_name']); ?></td>
						<td style="text-align: left;"><?php echo htmlentities($vo['kehu_dizhi']); ?></td>
						<td><?php echo htmlentities($vo['kehu_lianxr']); ?></td>
						<td><?php echo htmlentities($vo['kehu_lianxfs']); ?></td>
						<td>
							<span class="glyphicon glyphicon-pencil kehulist" id="<?php echo htmlentities($vo['id']); ?>"></span>
							<span class="glyphicon glyphicon-remove kehulist" id="<?php echo htmlentities($vo['id']); ?>" style="margin-left: 10px"></span>
						</td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>

				<tr class="hout_kehu_page" style="text-align: center;border: none">
					<td colspan="10">
						<ul class="pagination" style="margin: 0px;padding: 0px">
						<li><a href="#" id="<?php echo htmlentities($shangyiye); ?>">&laquo;</a></li>
						<?php $__FOR_START_248034357__=$qishiye;$__FOR_END_248034357__=$jieshuye;for($i=$__FOR_START_248034357__;$i < $__FOR_END_248034357__;$i+=1){ ?>
							<li <?php if($i+1==$dangqianye): ?> class="active" <?php endif; ?>><a href="#" id="<?php echo htmlentities($i+1); ?>"><?php echo htmlentities($i+1); ?></a></li>
						<?php } ?>
						<li><a href="#" id="<?php echo htmlentities($xiayiye); ?>"><span>&raquo;</span></a></li>
					</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>



	
<script type="text/javascript">
	$('.glyphicon').click(function(event) {
		if($(this).hasClass('kehulist')){
			if($(this).hasClass('glyphicon-pencil')){
				//修改
				var zhuti = $(this).parent().parent().children('td');
				$('#hout_kehuid').val($(this).attr('id'));
				$('#hout_kehu_name').val(zhuti.eq(0).text());
				$('#hout_kehu_dizhi').val(zhuti.eq(1).text());
				$('#hout_kehu_lianxr').val(zhuti.eq(2).text());
				$('#hout_kehu_lianxfs').val(zhuti.eq(3).text())
				$('#hout_kehu_insert').text('修改');
			}else{
				//删除
				if(confirm('确定删除？？')){
					$.ajax({
						type: 'post',
						url: '<?php echo url("Hout/kehu_del"); ?>',
						data:{
							id: $(this).attr('id'),
						},
						success: function(msg){
							showtz(msg['msg'],'');
							var zhuti = $('#hout_kehu_zhut').parent();
							zhuti.empty();
							zhuti.load('<?php echo url("Hout/kehu"); ?>');
						}
					})
				}
			}
		}
	});


	$('#hout_kehu_table .table tr').click(function(event) {
		$('#hout_kehu_table .bgcolor').removeClass('bgcolor');
		$(this).toggleClass('bgcolor');
	});


	$('#hout_kehu_insert').click(function(event) {
		$(this).attr('disabled', 'disabled');
		if($(this).text()=='新增'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/kehu_do"); ?>',
				data:{
					name: $('#hout_kehu_name').val(),
					dizhi: $('#hout_kehu_dizhi').val(),
					lianxr: $('#hout_kehu_lianxr').val(),
					lianxfs: $('#hout_kehu_lianxfs').val()
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_kehu_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/kehu"); ?>');
				}
			})
		}else{
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/kehu_update_do"); ?>',
				data:{
					id: $('#hout_kehuid').val(),
					name: $('#hout_kehu_name').val(),
					dizhi: $('#hout_kehu_dizhi').val(),
					lianxr: $('#hout_kehu_lianxr').val(),
					lianxfs: $('#hout_kehu_lianxfs').val()
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_kehu_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/kehu"); ?>');
				}
			})
		}
	});


	$('.hout_kehu_page .pagination a').click(function(event) {
		var id = $(this).attr('id');
		var zhuti = $('#hout_kehu_zhut').parent();
		var kehu = $('#hout_kehu_name').val();
		var dizhi = $('#hout_kehu_dizhi').val();
		var lianxr = $('#hout_kehu_lianxr').val();
		var lianxfs = $('#hout_kehu_lianxfs').val();

		zhuti.empty();

		zhuti.load("<?php echo url('Hout/kehu'); ?>?page=" + id + '&kehu=' + kehu + '&dizhi=' + dizhi + '&lianxr=' + lianxr + '&lianxfs=' + lianxfs);
	});


	$('#hout_kehu_chaxun').click(function(event) {
		var zhuti = $('#hout_kehu_zhut').parent();
		var kehu = $('#hout_kehu_name').val();
		var dizhi = $('#hout_kehu_dizhi').val();
		var lianxr = $('#hout_kehu_lianxr').val();
		var lianxfs = $('#hout_kehu_lianxfs').val();

		zhuti.empty();

		zhuti.load("<?php echo url('Hout/kehu'); ?>?kehu=" + kehu + '&dizhi=' + dizhi + '&lianxr=' + lianxr + '&lianxfs=' + lianxfs);
	});


	$('#hout_kehu_daochu').click(function(event) {
		var kehu = $('#hout_kehu_name').val();
		var dizhi = $('#hout_kehu_dizhi').val();
		var lianxr = $('#hout_kehu_lianxr').val();
		var lianxfs = $('#hout_kehu_lianxfs').val();

		window.open("<?php echo url('Hout/kehudaochu'); ?>?kehu=" + kehu + '&dizhi=' + dizhi + '&lianxr=' + lianxr + '&lianxfs=' + lianxfs);
	});

	$('#kehu_daoru_do').click(function(event) {
		uoloadfile('kehu_upload');
	});

	function uoloadfile(fid){  
        var data = new FormData($('#' + fid)[0]);  
        $.ajax({  
            url: '<?php echo url("Hout/kehudaoru"); ?>',  
            type: 'POST',  
            data: data,  
            dataType: 'JSON',  
            cache: false,  
            processData: false,  //不处理发送的数据，因为data值是FormData对象，不需要对数据做处理 
            contentType: false,
            success: function(msg){
            	$('#hout_kehu_daoru_modal').modal('hide');
				var zhuti = $('#hout_kehu_zhut').parent();
				zhuti.empty();
				zhuti.load("<?php echo url('Hout/kehu'); ?>");
				showtz(msg['msg'],'');
            }
        });  
        return false;  
    }
</script>
	
</div>
