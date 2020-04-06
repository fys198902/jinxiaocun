<?php /*a:1:{s:71:"C:\wamp64\www\jinxiaocun\application\index\view\Xiaos\xiaos_update.html";i:1553126400;}*/ ?>
<div id="xiaos_update_zhut">
	<ul class='biaod_ul'>
		<li style="text-align: right;">
			<span>
				<button class="btn btn-primary" id="xiaos_update_baoc">修改</button>
				<button class="btn btn-warning" id="xiaos_update_dayin">打印</button>
			</span>
		</li>
		<li>
			<span>单据编号：<span id='xiaos_update_xtid'><?php echo htmlentities($row[0]['xiaos_xt_id']); ?></span></span>
			<input type="hidden" id='xiaos_update_id' value="<?php echo htmlentities($row[0]['id']); ?>">
			<span style="margin-left: 200px">单据日期：<input type="text" id='xiaos_update_date' style="width: 150px" value="<?php echo htmlentities($row[0]['xiaos_date']); ?>"></span>
		</li>
		<li>
			<span>
				客户：<input id="xiaos_update_kehu" type="text" style="width: 270px" value="<?php echo htmlentities($row[0]['kehu_name']); ?>-<?php echo htmlentities($row[0]['kehu_dizhi']); ?>">
				<input type="hidden" id='xiaos_update_kehuid' value="<?php echo htmlentities($row[0]['kehuid']); ?>">
			</span>
			<span id='xiaos_update_yue' style="margin-left: 10px">账户欠款：<span id='xiaos_update_qiank'>0</span></span> </li>
		<li>
			<span>摘要 <input type="text" id="xiaos_update_zhaiy" style="width: 420px" value="<?php echo htmlentities($row[0]['xiaos_zhaiy']); ?>"></span>

			<span style="margin-left: 5px">仓库： <select id="xiaos_update_cangk_id" style="width: 100px; border: 1px solid #ccc">
				<option value="<?php echo htmlentities($row[0]['xiaos_cangk_id']); ?>"><?php echo htmlentities($row[0]['cangk_name']); ?></option>
				<?php if(is_array($cangku) || $cangku instanceof \think\Collection || $cangku instanceof \think\Paginator): $i = 0; $__LIST__ = $cangku;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['cangk_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select></span>


			<b>当前库存：</b><span id='xiaos_update_kucun'></span>
		</li>
		<li>
			<div class="xiaos_update biaod_biaog">
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
			<span>合计：<span id='xiaos_update_qiuhe'>0</span></span>
			<span style="float: right">大写：<span id='xiaos_update_daxie'>壹仟元整</span></span>
		</li>
		<li>
			<!-- <span>经手人：<input type="text" id="xiaos_update_jingsr" value="<?php echo htmlentities($row[0]['yuang']); ?>"> <input type="hidden" id="xiaos_update_jingsr_id" value="<?php echo htmlentities($row[0]['yuang_id']); ?>"></span> -->
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
	datelist('xiaos_update_date');
	tablehangshul(21);

	$('#xiaos_update_zhut input:text').keypress(function(event){  
		var inputs = $('#xiaos_update_zhut').find('input:text');
	    var keynum = (event.keyCode ? event.keyCode : event.which);  
	    if(keynum == '13'){
	        var idx = inputs.index(this); 
            inputs[idx + 1].focus();
            inputs[idx + 1].select();
	    }
	});

	
	$('.xiaos_update input').focus(function(event) {
		$(this).select();
	});

	$('#xiaos_update_kehu').focusout(function(event) {
		if($(this).val() == ''){
			$('#xiaos_update_kehuid').val('');
		}
	});



	var objmap_gys={};
	$("#xiaos_update_kehu").typeahead({
	    source: function (query, process) {
	        return $.ajax({
	            url: '<?php echo url("Getval/getkehu"); ?>',
	            type: 'post',
	            data: {kehu: query},
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
	    showHintOnFocus: true,
	    afterSelect: function (item) {
		    $('#xiaos_update_kehuid').val(objmap_gys[item]);
		},
	    delay: 400,
	});


	// var objmap_jingsr={};
	// $("#xiaos_update_jingsr").typeahead({
	//     source: function (query, process) {
	//         return $.ajax({
	//             url: '<?php echo url("Getval/getyuang"); ?>',
	//             type: 'post',
	//             data: {yuang: query},
	//             success: function (fdata) {
	//         	    var names = [];
	//                 $.each(fdata,function(index,ele){
	//                 	objmap_jingsr[ele.name]=ele.id;
	//                     names.push(ele.name);
	//                 });
	//                 process(names);
	//             }
	//         });
	//     },
	//     items: 5,
	//     showHintOnFocus: true,
	//     afterSelect: function (item) {
	// 	    $('#xiaos_update_jingsr_id').val(objmap_jingsr[item]);
	// 	},
	//     delay: 400,
	// });



	var objmap={};
	$(".xiaos_update .wuliao_id").typeahead({
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

	$('.xiaos_update .wuliao_id').focusout(function(event) {
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
				cangkuid: $('#xiaos_update_cangk_id').val()
			},
			success: function(data){
				$('#xiaos_update_kucun').text(data.wuliao_name + " 基本：" + data.jiben + '；常用：' + data.changyong);
			}
		});
	});



	$('.xiaos_update .danj').focusout(function(event) {
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

		var xiaos_update_qiuhe=0;
		$('.jine').each(function(item){
			var val = parseFloat($(this).val());
			if(!isNaN(val)){
				xiaos_update_qiuhe = xiaos_update_qiuhe + val;
			}
		})
		$('#xiaos_update_qiuhe').text(xiaos_update_qiuhe.toFixed(2));
		$('#xiaos_update_daxie').text(renminbixiaos_update_daxie(xiaos_update_qiuhe.toFixed(2)));
	});
	
	$('#xiaos_update_baoc').click(function(event) {

		if(isempty(['xiaos_update_date','xiaos_update_kehu'])){
			$(this).attr('disabled','disabled');
			$.ajax({
				type: "post",
				url: '<?php echo url("xiaos/xiaos_update_do"); ?>',
				data: {
					id: $('#xiaos_update_id').val(),
					xiaos_xt_id: $('#xiaos_update_xtid').text(),
					xiaos_date: $('#xiaos_update_date').val(),
					kehuid: $('#xiaos_update_kehuid').val(),
					xiaos_cangk_id: $('#xiaos_update_cangk_id').val(),
					xiaos_jingsr_id: '',
					xiaos_zhaiy: $('#xiaos_update_zhaiy').val(),
					xiaos_wuliao_id: getclassval('.xiaos_update .wuliao_id'),
					xiaos_danw_id: getclassval('.xiaos_update .danw'),
					xiaos_shul: getclassval('.xiaos_update .shul'),
					xiaos_danj: getclassval('.xiaos_update .danj'),
					xiaos_jine: getclassval('.xiaos_update .jine'),
					xiaos_beizhu: getclassval('.xiaos_update .beizhu'),
				},
				success: function(msg){
					if(typeof(msg) == 'string'){
						$('#xiaos_update_baoc').removeAttr('disabled');
						showtz(msg,'');
						return false;
					}

					if(msg['status'] == 0){
						showtz(msg['msg'],'');
					}else{
						showtz(msg['msg'] + '-修改成功','');
					}
				}
			})
		}else{
			showtz('表单信息不全，请补充输入','');
		}
	});


	$('#xiaos_update_dayin').click(function(event) {
		window.open('<?php echo url("xiaos/xiaos_print"); ?>?id=' + <?php echo htmlentities($row[0]['id']); ?>,"销售单打印");
	});

	$('#xiaos_update_kehu').focusout(function(event) {
		$.ajax({
			type: 'post',
			url: '<?php echo url("getval/getqiank"); ?>',
			data:{
				kehuid: $('#xiaos_update_kehuid').val()
			},
			success: function(msg){
				$('#xiaos_update_qiank').text(msg);
			}
		})
	});
</script>