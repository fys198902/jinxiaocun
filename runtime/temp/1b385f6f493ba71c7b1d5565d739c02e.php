<?php /*a:1:{s:62:"D:\www\jinxiaocun\application\index\view\Caig\caig_insert.html";i:1553126400;}*/ ?>
<div id="caigou_insert_zhuti">
	<ul class="biaod_ul">
		<li style="text-align: right;">
			<span>
				<button class="btn btn-primary" id="caig_insert_baoc">保存</button>
				<button class="btn btn-success" id="caig_insert_new">新增</button>
			</span>
		</li>
		<li>
			<span>单据编号：<span id='caig_insert_id'><?php echo htmlentities($xtid); ?></span></span>
			<span style="margin-left: 200px">单据日期：<input type="text" id='caig_insert_date' style="width: 150px" value="<?php echo htmlentities($fdate); ?>"></span>
		</li>
		<li>
			<span>
				供应商：<input id="caig_insert_gongys" type="text" style="width: 270px">
				<input type="hidden" id='caig_insert_gongysid'>
			</span>
			<span id='caig_insert_yue' style="margin-left: 10px"></span></li>
		<li>
			<span>摘要 <input type="text" id="caig_insert_zhaiy" style="width: 420px"></span>
			<span style="margin-left: 5px">仓库： <select id="caig_insert_cangk_id" style="width: 100px; border: 1px solid #ccc">
				<?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['cangk_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select></span>
			<b>当前库存：</b><span id='caig_kucun'></span>
		</li>
		<li>
			<div class="caigou_insert biaod_biaog">
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
			<span>合计：<span id='caig_insert_qiuhe'>0</span></span>
			<span style="float: right">大写：<span id='caig_insert_daxie'>壹仟元整</span></span>
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
	datelist('caig_insert_date');
	tablehangshul(21);

	$('#caigou_insert_zhuti input:text').keypress(function(event){  
		var inputs = $('#caigou_insert_zhuti').find('input:text');
	    var keynum = (event.keyCode ? event.keyCode : event.which);  
	    if(keynum == '13'){
	        var idx = inputs.index(this); 
            inputs[idx + 1].focus();
            inputs[idx + 1].select();
	    }
	});

	$('.caigou_insert input').focus(function(event) {
		$(this).select();
	});

	
	$('#caig_insert_gongys').focusout(function(event) {
		if($(this).val() == ''){
			$('#caig_insert_gongysid').val('');
		}
	});

	var objmap_gys={};
	$("#caig_insert_gongys").typeahead({
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
	    afterSelect: function (item) {
	    	$('#caig_insert_gongysid').val(objmap_gys[item]);
		},
		showHintOnFocus: true,
	    delay: 400,
	});



	var objmap={};
	$(".caigou_insert .wuliao_id").typeahead({
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
	    showHintOnFocus: true,
	    items: 3,
	    updater: function (item) {
	        return objmap[item];
	    },
	    delay: 400,
	});

	$('.caigou_insert .wuliao_id').focusout(function(event) {
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
				cangkuid: $('#caig_insert_cangk_id').val()
			},
			success: function(data){
				$('#caig_kucun').text(data.wuliao_name + " 基本：" + data.jiben + '；常用：' + data.changyong);
			}
		});

	});



	$('.caigou_insert .danj').focusout(function(event) {
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
		$('.caigou_insert .jine').each(function(item){
			var val = parseFloat($(this).val());
			if(!isNaN(val)){
				qiuhe = qiuhe + val;
			}
		})
		$('#caig_insert_qiuhe').text(qiuhe.toFixed(2));
		$('#caig_insert_daxie').text(renminbidaxie(qiuhe.toFixed(2)));
	});
	
	$('#caig_insert_baoc').click(function(event) {
		if(isempty(['caig_insert_date','caig_insert_gongysid'])){
			$(this).attr('disabled', 'disabled');
			$.ajax({
				type: "post",
				url: '<?php echo url("Caig/caig_insert_do"); ?>',
				data: {
					caig_date: $('#caig_insert_date').val(),
					gongysid: $('#caig_insert_gongysid').val(),
					caig_zhaiy: $('#caig_insert_zhaiy').val(),
					caig_cangk_id: $('#caig_insert_cangk_id').val(),
					caig_wuliao_id: getclassval('.caigou_insert .wuliao_id'),
					caig_danw_id: getclassval('.caigou_insert .danw'),
					caig_shul: getclassval('.caigou_insert .shul'),
					caig_danj: getclassval('.caigou_insert .danj'),
					caig_jine: getclassval('.caigou_insert .jine'),
					caig_beizhu: getclassval('.caigou_insert .beizhu'),
				},
				success: function(msg){
					if(typeof(msg) == 'string'){
						$('#caig_insert_baoc').removeAttr('disabled');
						showtz(msg,'');
						return false;
					}
					
					if(msg['status'] == 0){
						showtz(msg['msg'],'');
						$('#caig_insert_baoc').removeAttr('disabled');
					}else{
						showtz(msg['msg'] + '-保存成功', '');
						$('#caigou_insert_zhuti input').attr('disabled','disabled');
					}
				}
			})
		}else{
			showtz('表单信息不全，请补充输入','');
		}
	});


	$('#caig_insert_new').click(function(event) {
		$('#caig_insert_baoc').removeAttr('disabled');
		$('#caig_insert_gongysid').val('');
		$('#caigou_insert_zhuti input').removeAttr('disabled');
		$('#caigou_insert_zhuti input').not('#caig_insert_date').val('');
	});
</script>