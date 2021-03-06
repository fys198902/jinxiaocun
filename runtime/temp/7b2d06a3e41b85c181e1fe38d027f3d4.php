<?php /*a:1:{s:62:"C:\wamp64\www\jinxiaocun\application\index\view\Hout\danw.html";i:1553385600;}*/ ?>
<style type="text/css">
	.glyphicon:hover{
		color: red;
		cursor: pointer;
	}	
</style>

<div id="hout_danw_zhut">
	<div style="width: 200px; height: 200px;position: relative;left: 10px; top: 5px">
		<div class="form-group">
		    <label >单位组</label>
		    <input type="email" class="form-control" id="hout_danw_zuname" placeholder="例：件-12">
		</div>
		<button class="btn btn-primary" style="width: 98%" id="hout_danwzu_insert">新增</button>
	</div>

	<div style="width: 200px; height: 200px; position: relative; left: 350px; top: -195px">
		<div class="form-group">
		    <label for="hout_danw_zuname_auto">单位组</label>
		    <input type="email" class="form-control" id="hout_danw_zuname_auto" placeholder="组名">
		    <input type="hidden" id="hout_danw_zuid">
		</div>

		<div class="form-group">
		    <label for="hout_danw_danwname">单位名</label>
		    <input type="email" class="form-control" id="hout_danw_danwname" placeholder="单位名称">
		</div>
	</div>

	<div style="width: 200px; height: 200px; position: relative; left: 570px; top: -395px">
		<div class="form-group">
		    <label for="hout_danw_huansuan">换算</label>
		    <input type="email" class="form-control" id="hout_danw_huansuan" placeholder="基本单位填 1">
		</div>

		<div class="checkbox">
		    <label><input type="checkbox" id='hout_danw_jiben'> 基本单位</label>
		</div>
		<button class="btn btn-primary" style="width: 98%; position: relative; top: -4px" id='hout_danwentry_insert'>新增</button>
	</div>


	<div style=" position: relative; top: -400px; left: 5px;display: flex;flex-direction: row">
		<table class="table table-bordered" style="width: 200px">
			<tr>
				<th>ID</th>
				<th>单位组名</th>
				<th>操作</th>
			</tr>
			<tbody id="hout_danw_zulist">
				<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo htmlentities($i); ?></td>
						<td><?php echo htmlentities($vo['danw_zu']); ?></td>
						<td>
							<span class="glyphicon glyphicon-remove hout_danwzu_del" data-id="<?php echo htmlentities($vo['id']); ?>"></span>
							<span class="glyphicon glyphicon-pencil hout_danwzu_update" data-id="<?php echo htmlentities($vo['id']); ?>" data-name="<?php echo htmlentities($vo['danw_zu']); ?>" style="margin-left: 10px"></span>
						</td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>

		<table class="table table-bordered" style="margin-left: 140px;width: 500px">
			<tr>
				<th>ID</th>
				<th>组名</th>
				<th>单位名</th>
				<th>换算率</th>
				<th>操作</th>
			</tr>
			
			<tbody id='hout_danwentrylist'>
				<?php if(is_array($rowentry) || $rowentry instanceof \think\Collection || $rowentry instanceof \think\Paginator): $i = 0; $__LIST__ = $rowentry;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo htmlentities($i); ?></td>
						<td><?php echo htmlentities($vo['danw_zu']); ?></td>
						<td><?php echo htmlentities($vo['danw_name']); ?></td>
						<td><?php echo htmlentities($vo['danw_huans']); ?></td>
						<td>
							<span class="glyphicon glyphicon-remove hout_danwentry" data-id="<?php echo htmlentities($vo['danwid']); ?>"></span>
							<span class="glyphicon glyphicon-pencil hout_danwentry_update" data-id="<?php echo htmlentities($vo['danwid']); ?>" data-zuid="<?php echo htmlentities($vo['zuid']); ?>" data-zuming="<?php echo htmlentities($vo['danw_zu']); ?>" data-danwname="<?php echo htmlentities($vo['danw_name']); ?>" data-danwhuans="<?php echo htmlentities($vo['danw_huans']); ?>" style="margin-left: 10px"></span>
						</td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>	
</div>

<script type="text/javascript">

	$('#hout_danwzu_insert').click(function(event) {
		$(this).attr('disabled', 'disabled');
		if($(this).text() == '新增'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/danw_zu_do"); ?>',
				data:{
					zuming: $('#hout_danw_zuname').val()
				},
				success: function(msg){
					var zhuti = $('#hout_danw_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/danw"); ?>');
					showtz(msg['msg'],'');
				}
			})
		}

		if($(this).text() == '修改'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/danw_zu_update_do"); ?>',
				data:{
					zuid: $(this).attr('data-id'),
					zuming: $('#hout_danw_zuname').val()
				},
				success: function(msg){
					var zhuti = $('#hout_danw_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/danw"); ?>');
					showtz(msg['msg'],'');
				}
			})
		}

		
	});


	var objmap_zuid={};
	$("#hout_danw_zuname_auto").typeahead({
	    source: function (query, process) {
	        return $.ajax({
	            url: '<?php echo url("Getval/getdanwzu"); ?>',
	            type: 'post',
	            data: {gongys: query},
	            success: function (fdata) {
	        	    var names = [];
	                $.each(fdata,function(index,ele){
	                	objmap_zuid[ele.danw_zu]=ele.id;
	                    names.push(ele.danw_zu);
	                });
	                process(names);
	            }
	        });
	    },
	    items: 3,
	    showHintOnFocus: true,
	    afterSelect: function (item) {
		    $('#hout_danw_zuid').val(objmap_zuid[item]);
		},
	    delay: 400,
	});


	$('.hout_danwzu_del').click(function(event) {
		var zuid = $(this).attr('data-id');
		if(confirm('确定要删除吗')==true){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/danwzu_del"); ?>',
				data: {
					id: zuid
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_danw_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/danw"); ?>');
				}
			})
		}
	});


	$('.hout_danwzu_update').click(function(event) {
		var zuid = $(this).attr('data-id');
		var zuname = $(this).attr('data-name');
		$('#hout_danw_zuname').val(zuname);
		$('#hout_danwzu_insert').attr('data-id', zuid);
		$('#hout_danwzu_insert').text('修改');
	});	




	$('.hout_danwentry').click(function(event) {
		var zuid = $(this).attr('data-id');
		if(confirm('确定要删除吗')==true){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/danwentry_del"); ?>',
				data: {
					id: zuid
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_danw_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/danw"); ?>');
				}
			})
		}
	});


	$('.hout_danwentry_update').click(function(event) {
		var danwid = $(this).attr('data-id');
		var zuid = $(this).attr('data-zuid');
		var zuming = $(this).attr('data-zuming');
		var danwming = $(this).attr('data-danwname');
		var danwhuans = $(this).attr('data-danwhuans');

		$('#hout_danw_zuid').val(zuid);
		$('#hout_danw_zuname_auto').val(zuming);
		$('#hout_danw_danwname').val(danwming);
		$('#hout_danw_huansuan').val(danwhuans);
		$('#hout_danwentry_insert').text('修改');
		$('#hout_danwentry_insert').attr('data-id', danwid);

	});




	$('#hout_danwentry_insert').click(function(event) {
		$(this).attr('disabled', 'disabled');
		if($(this).text() == '新增'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/danwentry_do"); ?>',
				data:{
					zuid: $('#hout_danw_zuid').val(),
					danw_name: $('#hout_danw_danwname').val(),
					huansuan: $('#hout_danw_huansuan').val(),
					jiben: $('#hout_danw_jiben').prop("checked")
				},
				success: function(msg){
					var zhuti = $('#hout_danw_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/danw"); ?>');
					showtz(msg['msg'],'');
				}
			})
		}

		if($(this).text() == '修改'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/danwentry_update_do"); ?>',
				data:{
					id: $(this).attr('data-id'),
					zuid: $('#hout_danw_zuid').val(),
					danw_name: $('#hout_danw_danwname').val(),
					huansuan: $('#hout_danw_huansuan').val(),
					jiben: $('#hout_danw_jiben').prop("checked")
				},
				success: function(msg){
					var zhuti = $('#hout_danw_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/danw"); ?>');
					showtz(msg[msg],'');
				}
			})
		}		
		
	});
</script>