<?php /*a:1:{s:64:"C:\wamp64\www\jinxiaocun\application\index\view\Hout\wuliao.html";i:1553385600;}*/ ?>
<style type="text/css">
	.table{
		border: 1px solid #ccc;
	}

	.table th,tr,td{
		border: 1px solid #ccc;
		text-align: center;
	}

	.glyphicon:hover{
		color: red;
		cursor: pointer;
	}	
</style>

<div id="hout_wuliao_zhut">
	<div style="width: 200px; height: 200px;position: relative;left: 10px; top: 5px">
		<div class="form-group">
		    <label for="hout_wuliaozu">物料组</label>
		    <input type="email" class="form-control" id="hout_wuliaozu" placeholder="组名">
		    <input type="hidden" id='hout_wuliaozuid'>
		</div>
		<button class="btn btn-primary" style="width: 98%" id="hout_wuliaozu_insert">新增</button>
	</div>



	<div style="width: 200px; height: 200px; position: relative; left: 350px; top: -195px">
		<div class="form-group">
		    <label for="hout_wuliao_zu">物料组</label>
		    <input type="text" class="form-control" id="hout_wuliao_zu" placeholder="组名">
		    <input type="hidden" id='hout_wuliao_zuid'>
		</div>

		<div class="form-group">
		    <label for="hout_wuliao_name">物料名称</label>
		    <input type="text" class="form-control" id="hout_wuliao_name" placeholder="物料及规格">
		    <input type="hidden" id='hout_wuliaoid'>
		</div>
	</div>

	<div style="width: 200px; height: 200px; position: relative; left: 570px; top: -395px">
		<div class="form-group">
		    <label for="hout_wuliao_danwzu">单位组</label>
		    <select id="hout_wuliao_danwzuid" class="form-control" >
		    	<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            　　		<option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['danw_zu']); ?></option>
            	<?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
		</div>


		<button class="btn btn-primary" style="width: 98%; position: relative; top: 24px" id='hout_wuliao_insert'>新增</button>
	</div>


	<div style=" position: relative; top: -400px; left: 5px;display: flex;flex-direction: row">
		<table class="table" style="width: 200px">
			<th>ID</th>
			<th>单位组名</th>
			<th>操作</th>
			<tbody id="hout_wuliaozulist">
				<?php if(is_array($wuliaozu) || $wuliaozu instanceof \think\Collection || $wuliaozu instanceof \think\Paginator): $i = 0; $__LIST__ = $wuliaozu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo htmlentities($i); ?></td>
						<td class="hout_wuliaozu"><?php echo htmlentities($vo['wuliao_zu']); ?></td>
						<td>
							<span class="glyphicon glyphicon-pencil wuliaozu" id="<?php echo htmlentities($vo['id']); ?>"></span>
							<span class="glyphicon glyphicon-remove wuliaozudel" style="margin-left: 5px" id="<?php echo htmlentities($vo['id']); ?>">
						</td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>

		<table class="table" style="margin-left: 140px;width: 500px">
			<th>ID</th>
			<th>组名</th>
			<th>物料名</th>
			<th>单位组名</th>
			<th>操作</th>
			<tbody id='hout_wuliaoentrylist'>
				<?php if(is_array($wuliaolist) || $wuliaolist instanceof \think\Collection || $wuliaolist instanceof \think\Paginator): $i = 0; $__LIST__ = $wuliaolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo htmlentities($i); ?></td>
						<td><?php echo htmlentities($vo['wuliao_zu']); ?></td>
						<td style="text-align: left"><?php echo htmlentities($vo['wuliao_name']); ?></td>
						<td><?php echo htmlentities($vo['danw_zu']); ?></td>
						<td>
							<span class="glyphicon glyphicon-pencil wuliaolist" id="<?php echo htmlentities($vo['id']); ?>"></span>
							<span class="glyphicon glyphicon-remove wuliaodel" style="margin-left: 5px" id="<?php echo htmlentities($vo['id']); ?>"></span>
						</td>
					</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>	
</div>

<script type="text/javascript">
	$('#hout_wuliaozulist').on('click','.wuliaozu',function(event) {
		$('#hout_wuliaozuid').val($(this).attr('id'));
		$('#hout_wuliaozu').val($(this).parent().parent().find('.hout_wuliaozu').text());
		$('#hout_wuliaozu_insert').text('修改');
	})

	$('#hout_wuliaozulist').on('click','.wuliaozudel',function(event) {
		var id = $(this).attr('id');
		$.ajax({
			type: 'post',
			url: '<?php echo url("Hout/wuliaozu_del"); ?>',
			data: {
				wuliaozuid : id
			},
			success: function(msg){
				showtz(msg['msg'],'');
				var zhuti = $('#hout_wuliao_zhut').parent();
				zhuti.empty();
				zhuti.load('<?php echo url("Hout/wuliao"); ?>')
			}
		})
	})

	$('#hout_wuliaoentrylist').on('click','.wuliaodel',function(event) {
		var id = $(this).attr('id');
		$.ajax({
			type: 'post',
			url: '<?php echo url("Hout/wuliao_del"); ?>',
			data: {
				wuliaoid : id
			},
			success: function(msg){
				showtz(msg['msg'],'');
				var zhuti = $('#hout_wuliao_zhut').parent();
				zhuti.empty();
				zhuti.load('<?php echo url("Hout/wuliao"); ?>')
			}
		})
	})


	$('#hout_wuliaoentrylist').on('click','.wuliaolist',function(event) {
		var id = $(this).attr('id');
		$.ajax({
			type: 'post',
			url: '<?php echo url("Hout/getwuliao"); ?>',
			data: {
				wuliaoid : id
			},
			success: function(msg){
				$('#hout_wuliao_zu').val(msg[0]['wuliao_zu']);
				$('#hout_wuliao_zuid').val(msg[0]['zuid']);
				$('#hout_wuliao_name').val(msg[0]['wuliao_name']);
				$('#hout_wuliao_danwzu').prepend('<option value="' + msg[0]['danwzuid'] + '">' + msg[0]['danw_zu'] + '</option>')
				$('#hout_wuliao_danwzu').prop('selectedIndex', 0);
				$('#hout_wuliaoid').val(msg[0]['id']);
				$('#hout_wuliao_insert').text('修改');

			}
		})

	})


	$('#hout_wuliaozu_insert').click(function(event) {
		$(this).attr('disabled', 'disabled');
		if($(this).text()=='新增'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/wuliaozu_do"); ?>',
				data:{
					id: 0,
					wuliaozu: $('#hout_wuliaozu').val()
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_wuliao_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/wuliao"); ?>')
				}
			})
		}else{
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/wuliaozu_do"); ?>',
				data:{
					id: $('#hout_wuliaozuid').val(),
					wuliaozu: $('#hout_wuliaozu').val()
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_wuliao_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/wuliao"); ?>')
				}
			})
		}
	});


	var objmap_zuid={};
	$("#hout_wuliao_zu").typeahead({
	    source: function (query, process) {
	        return $.ajax({
	            url: '<?php echo url("Getval/getwuliaozu"); ?>',
	            type: 'post',
	            data: {zuming: query},
	            success: function (fdata) {
	        	    var names = [];
	                $.each(fdata,function(index,ele){
	                	objmap_zuid[ele.wuliao_zu]=ele.id;
	                    names.push(ele.wuliao_zu);
	                });
	                process(names);
	            }
	        });
	    },
	    items: 3,
	    showHintOnFocus: true,
	    afterSelect: function (item) {
		    $('#hout_wuliao_zuid').val(objmap_zuid[item]);
		},
	    delay: 400,
	});


	$('#hout_wuliao_insert').click(function(event) {
		$(this).attr('disabled', 'disabled');
		if($(this).text()=='新增'){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/wuliao_do"); ?>',
				data: {
					zuid: $('#hout_wuliao_zuid').val(),
					wuliao: $('#hout_wuliao_name').val(),
					danwzuid: $('#hout_wuliao_danwzuid').val(),
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_wuliao_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/wuliao"); ?>')
				}
			})
		}else{
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/wuliao_update_do"); ?>',
				data: {
					id: $('#hout_wuliaoid').val(),
					zuid: $('#hout_wuliao_zuid').val(),
					wuliao: $('#hout_wuliao_name').val(),
					danwzuid: $('#hout_wuliao_danwzuid').val(),
				},
				success: function(msg){
					showtz(msg['msg'],'');
					var zhuti = $('#hout_wuliao_zhut').parent();
					zhuti.empty();
					zhuti.load('<?php echo url("Hout/wuliao"); ?>')
				}
			})
		}
	});
</script>