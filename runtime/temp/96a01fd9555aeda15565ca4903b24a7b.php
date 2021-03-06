<?php /*a:1:{s:69:"C:\wamp64\www\jinxiaocun\application\index\view\Caig\caig_update.html";i:1553126400;}*/ ?>
<div id="caig_update_zhuti">
	<ul class='biaod_ul'>
		<li style="text-align: right;">
			<span>
				<button class="btn btn-success" id="caig_update_baoc">保存</button>
			</span>
		</li>
		<li>
			<span>单据编号：<span id='caig_update_xt_id'><?php echo htmlentities($row[0]['caig_xt_id']); ?></span>
			<span style="margin-left: 200px">单据日期：<input type="text" id='caig_update_date' style="width: 150px" value="<?php echo htmlentities($row[0]['caig_date']); ?>"><input id="caig_update_id" type="hidden" value="<?php echo htmlentities($row[0]['id']); ?>"></span>
		</li>
		<li>
			<span>
				供应商：<input id="caig_update_gongys" type="text" value="<?php echo htmlentities($row[0]['gongys_name']); ?>-<?php echo htmlentities($row[0]['gongys_dizhi']); ?>" style="width: 210px">
				<input type="hidden" id='caig_update_gongysid' value="<?php echo htmlentities($row[0]['gongysid']); ?>">
			</span>
			<span id='caig_update_yue' style="margin-left: 10px"></span> </li>
		<li>
			<span>摘要 <input type="text" id="caig_update_zhaiy" style="width: 420px" value="<?php echo htmlentities($row[0]['caig_zhaiy']); ?>"></span>
			<span style="margin-left: 5px">仓库： <select id="caig_update_cangk_id" style="width: 100px; border: 1px solid #ccc">
				<option value="<?php echo htmlentities($row[0]['caig_cangk_id']); ?>"><?php echo htmlentities($row[0]['cangk_name']); ?></option>
				<?php if(is_array($cangku) || $cangku instanceof \think\Collection || $cangku instanceof \think\Paginator): $i = 0; $__LIST__ = $cangku;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['cangk_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select></span>
			<b>当前库存：</b><span id='caig_update_kucun'></span>
		</li>
		<li>
			<div class="caig_update biaod_biaog">
				<table style="width: 99%">
					<th style="width: 40px">ID</th>
					<th style="width: 80px">物料ID</th>
					<th style="width: 210px">物料名称</th>
					<th style="width: 80px">单位</th>
					<th style="width: 80px">数量</th>
					<th style="width: 80px">单价</th>
					<th style="width: 80px">金额</th>
					<th>备注</th>
					<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<tr>
							<td><?php echo htmlentities($i); ?></td>
							<td><input type="text" class="wuliao_id" value="<?php echo htmlentities($vo['wuliaoid']); ?>"></td>
							<td><input type="text" class="wuliao" value="<?php echo htmlentities($vo['wuliao_name']); ?>"></td>
							<td><select class="danw">
								<option value="<?php echo htmlentities($vo['danwid']); ?>"><?php echo htmlentities($vo['danw_name']); ?></option>
							</select></td>
							<td><input type="text" class="shul" value="<?php echo htmlentities($vo['shul']); ?>"></td>
							<td><input type="text" class="danj" min="0" step="0.01" value="<?php echo htmlentities($vo['danj']); ?>"></td>
							<td><input type="text" class="jine" step="0.01" value="<?php echo htmlentities($vo['jine']); ?>"></td>
							<td><input type="text" class="beizhu" value="<?php echo htmlentities($vo['beizhu']); ?>"></td>
						</tr>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					
				</table>
			</div>
		</li>
		<li>
			<span>合计：<span id="caig_update_qiuhe">0</span></span>
			<span style="float: right">大写：<span id='caig_update_daxie'>零元整</span>
		</li>
	</ul>
</div>
<style type="text/css">
	.fselect{
		height: 99%;
		width: 99%;
	}
</style>

<script type="text/javascript">
	datelist('caig_update_date');
	tablehangshul(21);

	$('#caig_update_zhuti input:text').keypress(function(event){  
		var inputs = $('#caig_update_zhuti').find('input:text');
	    var keynum = (event.keyCode ? event.keyCode : event.which);  
	    if(keynum == '13'){
	        var idx = inputs.index(this); 
            inputs[idx + 1].focus();
            inputs[idx + 1].select();
	    }
	});

	$('.caig_update input').focus(function(event) {
		$(this).select();
	});

	$('#caig_update_gongys').focusout(function(event) {
		if($(this).val() == ''){
			$('#caig_update_gongysid').val('');
		}
	});

	
	var objmap_gys={};
	$("#caig_update_gongys").typeahead({
	    source: function (query, process) {
	        return $.ajax({
	            url: '<?php echo url("Getval/getgongys"); ?>',
	            type: 'post',
	            data: {gongys: query},
	            success: function (fdata) {
	        	    var names = [];
	                $.each(fdata,function(index,ele){
	                	objmap_gys[ele.name]=ele.id;
	                    names.push(ele.name);
	                });
	                process(names);
	            }
	        });
	    },
	    items: 5,
	    showHintOnFocus: true,
	    afterSelect: function (item) {
		    $('#caig_update_gongysid').val(objmap_gys[item]);
		},
	    delay: 400,
	});



	var objmap={};
	$(".caig_update .wuliao_id").typeahead({
	    source: function (query, process) {
	        return $.ajax({
	            url: '<?php echo url("Getval/getwuliao"); ?>',
	            type: 'post',
	            data: {wuliao: query},
	            success: function (fdata) {
	        	    var names = [];
	                $.each(fdata,function(index,ele){
	                	objmap[ele.wuliao_name]=ele.id;
	                    names.push(ele.wuliao_name);
	                });
	                process(names);
	            }
	        });
	    },
	    items: 3,
	    showHintOnFocus: true,
	    updater: function (item) {
	        return objmap[item];
	    },
	    delay: 400,
	});

	$('.caig_update .wuliao_id').focusout(function(event) {
		var wuliao_id=$(this).parent().parent().find('.wuliao_id').val();
		if(!wuliao_id > 0){
			return false;
		}
		
		var frow=$(this);
		$.ajax({
			type: 'post',
			url: '<?php echo url("Getval/getwuliaoentry"); ?>',
			data: {
				wuliaoid : wuliao_id
			},
			success: function(data){
				frow.parent().parent().find('.wuliao').val(data.wuliao_name);
			}
		});

		$.ajax({
			type: 'post',
			url: '<?php echo url("Getval/getdanwentry"); ?>',
			data: {
				wuliaoid : wuliao_id
			},
			success: function(data){
				var fdanw =frow.parent().parent().find('.danw');
				fdanw.find("option").not(":eq(0)").remove();
				data.map(function(index, elem) {
					fdanw.append('<option value="' + index.id + '">' + index.danw_name + '</option>');
				})
			}
		});


		$.ajax({
			type: 'post',
			url: '<?php echo url("Getval/getkucun"); ?>',
			data: {
				wuliaoid : wuliao_id,
				cangkuid: $('#caig_update_cangk_id').val()
			},
			success: function(data){
				$('#caig_update_kucun').text(data.wuliao_name + " 基本：" + data.jiben + '；常用：' + data.changyong);
			}
		});
	});



	$('.caig_update .danj').focusout(function(event) {
		var fuji=$(this).parent().parent();
		var shul = parseFloat(fuji.find('.shul').val());
		var danj = parseFloat($(this).val());
		if(isNaN(danj)){
			$(this).val(0);
			danj=0;
		}	
		var reg = new RegExp("^-?[0-9]+(.[0-9]{1,2})?$");
		if(!reg.test(shul) || !reg.test(danj)){
			showtz('请检查输入是否正确','');
		}
		fuji.find('.jine').val(checknumber(shul*danj));

		var qiuhe=0;
		$('.caig_update .jine').each(function(item){
			var val = parseFloat($(this).val());
			if(!isNaN(val)){
				qiuhe = qiuhe + val;
			}
		})
		$('#caig_update_qiuhe').text(qiuhe.toFixed(2));
		$('#caig_update_daxie').text(renminbidaxie(qiuhe.toFixed(2)));
	});


	
	$('#caig_update_baoc').click(function(event) {
		$(this).attr('disabled',"disabled");
		$.ajax({
			type: "post",
			url: '<?php echo url("Caig/caig_update_do"); ?>',
			data: {
				id: $('#caig_update_id').val(),
				caig_xt_id: $('#caig_update_xt_id').text(), 
				caig_date: $('#caig_update_date').val(),
				gongysid: $('#caig_update_gongysid').val(),
				caig_cangk_id: $('#caig_update_cangk_id').val(),
				caig_zhaiy: $('#caig_update_zhaiy').val(),
				caig_wuliao_id: getclassval('.caig_update .wuliao_id'),
				caig_danw_id: getclassval('.caig_update .danw'),
				caig_shul: getclassval('.caig_update .shul'),
				caig_danj: getclassval('.caig_update .danj'),
				caig_jine: getclassval('.caig_update .jine'),
				caig_beizhu: getclassval('.caig_update .beizhu'),
			},
			success: function(msg){
				if(typeof(msg) == 'string'){
					$('#caig_update_baoc').removeAttr('disabled');
					showtz(msg,'');
					return false;
				}

				if(msg['status'] == 0){
					showtz(msg['msg'],'');
				}else{
					showtz(msg['msg'] + '--修改成功','');
				}
			}
		})
	});
</script>