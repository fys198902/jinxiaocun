<?php /*a:1:{s:64:"D:\www\jinxiaocun\application\index\view\Xiaos\xiaos_insert.html";i:1586145697;}*/ ?>
<div id="xiaos_insert_zhuti">
	<ul class='biaod_ul'>
		<li style="text-align: right;">
			<span>
				<button class="btn btn-primary" id="xiaos_insert_baoc">保存</button>
				<button class="btn btn-success" id="xiaos_insert_new" data-name="" disabled="disabled">新增</button>
				<button class="btn btn-primary" id="xiaos_insert_dayin" disabled="disabled">打印</button>
			</span>
		</li>
		<li>
			<span>单据编号：<span id='xiaos_insert_id'><?php echo htmlentities($xsid); ?><input type="hidden" id="xiaos_insert_print_id"></span></span>
			<span style="margin-left: 200px">单据日期：<input type="text" id='xiaos_insert_date' style="width: 150px" value="<?php echo htmlentities($fdate); ?>"></span>
		</li>
		<li>
			<span>
				客户：<input id="xiaos_insert_kehu" type="text" style="width: 270px">
				<input type="hidden" id='xiaos_insert_kehuid'>
			</span>
			<span id='xiaos_insert_yue' style="margin-left: 10px">账户欠款：<span id='xiaos_insert_qiank'></span></span> </li>
		<li>
			<span>摘要 <input type="text" id="xiaos_insert_zhaiy" style="width: 420px"></span>
			<span style="margin-left: 5px">仓库： <select id="xiaos_insert_cangk_id" style="width: 100px; border: 1px solid #ccc">
				<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['cangk_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select></span>
			<b>当前库存：</b><span id='xiaos_insert_kucun'></span>
		</li>
		<li>
			<div class="xiaos_insert biaod_biaog">
				<table style="width: 99%">
					<th style="width: 40px">ID</th>
					<th style="width: 80px">物料ID</th>
					<th style="width: 210px">物料名称</th>
					<th style="width: 80px">单位</th>
					<th style="width: 80px">数量</th>
					<th style="width: 80px">单价</th>
					<th style="width: 80px">金额</th>
					<th>备注</th>
		
				</table>
			</div>
		</li>
		<li>
			<span>合计：<span id='xiaos_insert_qiuhe'>0</span></span>
			<span style="float: right">大写：<span id='xiaos_insert_daxie'>壹仟元整</span></span>
		</li>
		<li>
			<span>收款类别：<select id="xiaos_insert_shoukleibie" style="width: 120px; border: 1px solid #ccc">
					<option value="0"><--请选择--></option>
				<?php if(is_array($leibie) || $leibie instanceof \think\Collection || $leibie instanceof \think\Paginator): $i = 0; $__LIST__ = $leibie;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['shoukleibie']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select></span>
			<span style="margin-left: 30px">收款金额：<input type="text" id="xiaoshou_insert_shoukuan_jine" style="width: 100px;"><span></span></span>
			<span style="margin-left: 10px">折扣金额：<input type="text" id="xiaoshou_insert_shoukuan_zhekou" style="width: 100px;"><span></span></span>
			<span>收款摘要：<input type="text" id="xiaoshou_insert_shoukuan_zhaiyao" style="width: 270px" placeholder="必填"></span>
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
	datelist('xiaos_insert_date');
	tablehangshul(21);

	$('#xiaos_insert_zhuti input:text').keypress(function(event){  
		var inputs = $('#xiaos_insert_zhuti').find('input:text');
	    var keynum = (event.keyCode ? event.keyCode : event.which);  
	    if(keynum == '13'){
	        var idx = inputs.index(this); 
            inputs[idx + 1].focus();
            inputs[idx + 1].select();
	    }
	});

	$('.xiaos_insert input').focus(function(event) {
		$(this).select();
	});


	$('#xiaos_insert_kehu').focusout(function(event) {
		if($(this).val() == ''){
			$('#xiaos_insert_kehuid').val('');
		}
	});


	var objmap_gys={};
	$("#xiaos_insert_kehu").typeahead({
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
	    items: 5,
	    showHintOnFocus: true,
	    afterSelect: function (item) {
		    $('#xiaos_insert_kehuid').val(objmap_gys[item]);
		},
	    delay: 400,
	});


	var objmap={};
	$(".xiaos_insert .wuliao_id").typeahead({
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

	$('.xiaos_insert .wuliao_id').focusout(function(event) {
		var wuliao_id=$(this).parent().parent().find('.wuliao_id').val();
		var frow=$(this);
		if(!wuliao_id > 0){
			return false;
		}
		
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
				fdanw.empty();
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
				cangkuid: $('#xiaos_insert_cangk_id').val()
			},
			success: function(data){
				$('#xiaos_insert_kucun').text(data.wuliao_name + " 基本：" + data.jiben + '；常用：' + data.changyong);
			}
		});
	});



	$('.xiaos_insert .danj').focusout(function(event) {
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
		$('.jine').each(function(item){
			var val = parseFloat($(this).val());
			if(!isNaN(val)){
				qiuhe = qiuhe + val;
			}
		})
		$('#xiaos_insert_qiuhe').text(qiuhe.toFixed(2));
		$('#xiaos_insert_daxie').text(renminbidaxie(qiuhe.toFixed(2)));
	});
	
	$('#xiaos_insert_baoc').click(function(event) {
		if(parseFloat($('#xiaoshou_insert_shoukuan_jine').val()) > 0){
			if($('#xiaos_insert_shoukleibie').val() == 0){
				showtz('请选择收款类别','');
				return false;
			}

			if($('#xiaoshou_insert_shoukuan_zhaiyao').val() == ''){
				showtz('收款摘要不得为空');
				return false;
			}
		}


		$(this).attr('disabled', 'disabled');
		if(isempty(['xiaos_insert_date','xiaos_insert_kehu'])){
			$.ajax({
				type: "post",
				url: '<?php echo url("xiaos/xiaos_insert_do"); ?>',
				data: {
					xiaos_date: $('#xiaos_insert_date').val(),
					kehuid: $('#xiaos_insert_kehuid').val(),
					xiaos_zhaiy: $('#xiaos_insert_zhaiy').val(),
					xiaos_cangk_id: $('#xiaos_insert_cangk_id').val(),
					xiaos_shoukleibie_id: $('#xiaos_insert_shoukleibie').val(),
					xiaos_wuliao_id: getclassval('.xiaos_insert .wuliao_id'),
					xiaos_danw_id: getclassval('.xiaos_insert .danw'),
					xiaos_shul: getclassval('.xiaos_insert .shul'),
					xiaos_danj: getclassval('.xiaos_insert .danj'),
					xiaos_jine: getclassval('.xiaos_insert .jine'),
					xiaos_beizhu: getclassval('.xiaos_insert .beizhu'),
					xiaoshou_shoukuan_jine: $('#xiaoshou_insert_shoukuan_jine').val(),
					xiaoshou_shoukuan_zhaiyao: $('#xiaoshou_insert_shoukuan_zhaiyao').val(),
					xiaoshou_shoukuan_zhekou: $('#xiaoshou_insert_shoukuan_zhekou').val(),
				},
				success: function(msg){
					if(typeof(msg) == 'string'){
						$('#xiaos_insert_baoc').removeAttr('disabled');
						showtz(msg,'');
						return false;
					}

					if(msg['status'] == 0){
						$('#xiaos_insert_baoc').removeAttr('disabled');
						showtz(msg['msg'],'');
					}else{
						$('#xiaos_insert_print_id').val(msg['id']);
						$('#xiaos_insert_new').attr('data-name', msg['xiaosnextid']);
						$('#xiaos_insert_new').removeAttr('disabled');
						$('#xiaos_insert_dayin').removeAttr('disabled');
						$('#xiaos_insert_zhuti input').attr('disabled', 'disabled');

						if(msg['shouk_xt_id'] != ''){
							showtz(msg['xiaosid'] + '-保存成功;' + msg['shouk_xt_id'] + '-保存成功',"<img src='<?php echo url('getval/erweima'); ?>?neirong=" + msg['shouk_xt_id'] + "' class='center-block' />");
						}else{
							showtz(msg['xiaosid'] + '-保存成功','');
						}
						
					}
					
				}
			})
		}else{
			$('#xiaos_insert_baoc').removeAttr('disabled');
			showtz('表单信息不全，请补充输入', '');
		}
	});


	$('#xiaos_insert_new').click(function(event) {
		var zhut = $('#xiaos_insert_zhuti').parent();
		zhut.empty();
		zhut.load('<?php echo url("xiaos/xiaos_insert"); ?>');
	});

	$('#xiaos_insert_dayin').click(function(event) {
		window.open('<?php echo url("xiaos/xiaos_print"); ?>?id=' + $('#xiaos_insert_print_id').val() ,"销售单打印");
	});


	$('#xiaos_insert_kehu').focusout(function(event) {
		$.ajax({
			type: 'post',
			url: '<?php echo url("getval/getqiank"); ?>',
			data:{
				kehuid: $('#xiaos_insert_kehuid').val()
			},
			success: function(msg){
				$('#xiaos_insert_qiank').text(msg);
			}
		})
	});

	$('#xiaoshou_insert_shoukuan_jine').focusout(function(event) {
		if(parseFloat($(this).val())>0){
			var cha = parseFloat($('#xiaos_insert_qiuhe').text())- parseFloat($(this).val());
			$('#xiaoshou_insert_shoukuan_zhekou').val(cha);
		}
	});
</script>