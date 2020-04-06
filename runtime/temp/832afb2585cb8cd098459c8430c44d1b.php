<?php /*a:1:{s:62:"C:\wamp64\www\jinxiaocun\application\index\view\Index\zhu.html";i:1586145339;}*/ ?>
<style>
	.bg-muted{
		text-decoration: none;
  		background-color: #eee;
	}

	.firstmenu>li{
		font-weight:bold;
	}

	.ermenu{
		margin-top: 5px;
	}

	.nav-tabs li a{
	    line-height:1
	}

	.nav-tabs .active a{
	    border-top: solid 2px #3498db !important;
	}

	.glyphicon-remove-sign:hover{
		color: red;
	}
	
.navbar-nav>li>a {padding-top:10px;padding-bottom:10px;}
.navbar-brand {height:40px;padding-top:10px;}
.navbar {min-height:40px;}
.navbar-toggle {margin-top:4px;margin-bottom:4px;}


</style>

<div style="width: 100%;height: 80px;margin-top: 25px">
	<img src="public/static/img/logo1.jpg" style="height: 60px;margin-left: 20px">
	<span style="float: right;margin-right: 5px; position: relative;z-index: 100">欢迎登陆：
		<a href="#" data-toggle="modal" data-target="#update_userpwd"><?php echo session('username'); ?></a>
		<a href="<?php echo url('index/logout'); ?>" style="margin-left: 5px;">退出</a></span>
	<span style="position: absolute; right: 5px; top: 48px; z-index: 1"><?php echo session('zhangtao_name'); ?></span>
	<span style="position: absolute; right: 5px; top: 70px; z-index: 1">截止日期：<?php echo session('closingdate'); if(session('shengyutianshu') >= 15): ?>
			<span class="glyphicon glyphicon-exclamation-sign admin_info" style="color: #3498db"></span>
		<?php else: ?>
			<span class="glyphicon glyphicon-exclamation-sign admin_info" style="color: red"></span>

		<?php endif; ?>
	</span>
</div>
<div style="width: 100%;border-bottom: 1px solid #ccc">
	<div style="width: 210px;position: absolute;border-right: 1px solid #ddd" id='mingli'>
		<ul class="nav nav-pills nav-stacked firstmenu">
			<li><a href="#">首页</a></li>
			<li id='caigou'><a href="#">采购管理</a></li>
				<ul id='caigoulist' class="nav nav-pills nav-stacked ermenu hidden" style="width: 80%; margin-left: 15px">
					<li id='Caig/caig_insert'><a href="#">采购入库单-新增</a></li>
					<li id='Caig/caig_list'><a href="#">采购入库单-维护</a></li>
				</ul>
			<li id='xiaos'><a href="#">销售管理</a></li>
				<ul id='xiaoslist' class="nav nav-pills nav-stacked ermenu hidden" style="width: 80%; margin-left: 15px">
					<li id='Xiaos/xiaos_insert'><a href="#">销售出库单-新增</a></li>
					<li id='Xiaos/xiaos_list'><a href="#">销售出库单-维护</a></li>
				</ul>
			<li id='cangc'><a href="#">仓存核算</a></li>
				<ul id='cangclist' class="nav nav-pills nav-stacked ermenu hidden" style="width: 80%; margin-left: 15px">
					<li id='Cangchu/jishi'><a href="#">即时库存</a></li>
					<li id='Cangchu/taizhang'><a href="#">库存台账</a></li>
					<!-- <li id='Cangchu/yuemojiesuan'><a href="#">月末结算</a></li> -->
				</ul>
			<li id='wangl'><a href="#">往来核算</a></li>
				<ul id='wangllist' class="nav nav-pills nav-stacked ermenu hidden" style="width: 80%; margin-left: 15px">
					<li id='Wanglai/shoukuan'><a href="#">收款单-新增</a></li>
					<li id='Wanglai/shoukuan_list'><a href="#">收款单-维护</a></li>
					<li id='Wanglai/kehuduizd'><a href="#">客户对账单</a></li>
					<li id='Wanglai/kehuqiank'><a href="#">客户欠款明细</a></li>

					<li><a href="#"><===间隔===></a></li>

					<li id='Wanglai/fukuandan'><a href="#">付款单-新增</a></li>
					<li id='Wanglai/fukuandan_list'><a href="#">付款单-维护</a></li>
					<li id='Wanglai/gongysduizd'><a href="#">供应商对账单</a></li>
					<li id='Wanglai/gongysqiank'><a href="#">供应商欠款明细</a></li>
				</ul>
			<li id='caiwu'><a href="#">财务结算</a></li>
				<ul id='caiwulist' class="nav nav-pills nav-stacked ermenu hidden" style="width: 80%; margin-left: 15px">
					<li id='caiwu/qitashouzhi'><a href="#">其他收支-新增</a></li>
					<li id='caiwu/qitashouzhi_list'><a href="#">其他收支-维护</a></li>
					<li id='caiwu/rijizhang'><a href="#">收支日记账</a></li>
					<li id='caiwu/yuemojiesuan'><a href="#">月末结算</a></li>
				</ul>
			<li id='set'><a href="#">系统设置</a></li>
				<ul id='setlist' class="nav nav-pills nav-stacked ermenu hidden" style="width: 80%; margin-left: 15px">
					<li id='Hout/danw'><a href="#">单位管理</a></li>
					<li id='Hout/wuliao'><a href="#">物料管理</a></li>
					<li id='Hout/kehu'><a href="#">客户管理</a></li>
					<li id='Hout/gongys'><a href="#">供应商管理</a></li>
					<li id='Hout/shoukleibie'><a href="#">收款类别</a></li>
					<li id='Hout/yuangong'><a href="#">员工管理</a></li>
					<li id='Hout/cangku'><a href="#">仓库管理</a></li>
				</ul>
		</ul>
	</div>
	<div id='neirong' style="position: absolute;left: 210px;">
		<ul class="nav nav-tabs" role="tablist">
			<li id="shouye" class="active"><a href="#home" data-toggle="tab">首页</a></li>
		</ul>


		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home">
				<div id="zhu_yingye_chart"></div>
			</div>
		</div>
	</div>
</div>


<div id="update_userpwd" class="modal fade" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document" style="width: 420px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">修改密码</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
		    <label >旧密码</label>
		    <input type="password" class="form-control" id="zhut_pwd" placeholder="旧密码">
		</div>

		<div class="form-group">
		    <label >新密码</label>
		    <input type="password" class="form-control" id="zhut_new_pwd" placeholder="新密码">
		</div>

		<div class="form-group">
		    <label >重复密码</label>
		    <input type="password" class="form-control" id="zhut_new_repwd" placeholder="重复密码">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" id="zhut_update_pwd" class="btn btn-primary">修改密码</button>
      </div>
    </div>
  </div>
</div>



<div id="tongzhi" class="modal fade" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document" style="width: 320px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">提示</h4>
      </div>
      <div class="modal-body">
		<span id='tongzhi_neirong'></span>
		<br/>
		<span id='erji_neirong'></span>
		<br/>
		<span id="zhu_erweima"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>





<script type="text/javascript">
	$('#neirong').css('width',$(window).width()-226);

	$('.firstmenu>li').click(function(event) {
		$('.ermenu').addClass('hidden');
		$('.firstmenu').find('.glyphicon-chevron-down').remove();
		$(this).find('a').append('<span class="glyphicon glyphicon-chevron-down" style="margin-left: 100px">');
		var id = $(this).attr('id') + 'list';
		$('#' + id).toggleClass('hidden');
	});

	$('.ermenu').children('li').click(function(event) {
		$('.firstmenu').find('.glyphicon-chevron-right').remove();
		$(this).find('a').append('<span class="glyphicon glyphicon-chevron-right" style="margin-left: 15px">');
		addtabs('list' + (parseInt($('.nav-tabs').children('li').length)+1), $(this).find('a').text(),$(this).attr('id'));
	});

	function addtabs(fid,fname,furl){
		$(".active").removeClass("active");

		var xinjian=true;
		$('.nav-tabs').find('li').each(function(index, el) {
			if($(this).find('a').text()==fname){
				var tabid = $(this).attr('id');
				var id = tabid.substr(4,10);
				$(this).addClass('active');
				$('#' + id).load('index/' + furl);
				$('#' + id).addClass('active');
				xinjian=false;
			}
		});

		if(xinjian){
			$('.nav-tabs').append('<li id="tab_' + fid + '"><a href="#' + fid + '" data-toggle="tab">' + fname +'<i class="glyphicon glyphicon-remove-sign" tabclose="' + fid + '" style="margin-left: 3px"></i></a></li>');
			$('.tab-content').append('<div role="tabpanel" class="tab-pane" id="' + fid + '"><div class="loading"></div></div>');
			$('#' + fid).load('index/' + furl, function(){
				$('.loading').hide();
			});
			$('#tab_' + fid).addClass('active');
			$('#' + fid).addClass('active');
		}
	}

	$('.nav-tabs').on('click', '.glyphicon-remove-sign', function(event) {
		event.preventDefault();
		var id = $(this).attr('tabclose');
		if($("li.active").attr('id') == "tab_" + id) {
	        $("#tab_" + id).prev().addClass('active');
	        $("#" + id).prev().addClass('active');
	    }
	    //关闭TAB
	    $("#tab_" + id).remove();
	    $("#" + id).remove();
	});

	$('#zhut_update_pwd').click(function(event) {
		if($('#zhut_new_pwd').val() == $('#zhut_new_repwd').val()){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Hout/user_update"); ?>',
				data:{
					zhut_pwd: $('#zhut_pwd').val(),
					zhut_new_pwd: $('#zhut_new_pwd').val(),
					zhut_new_repwd: $('#zhut_new_repwd').val(),

				},
				success: function(msg){
					showtz(msg,'')
				}
			})
		}else{
			showtz('抱歉，前后密码不一致','');
		}
		
	});

	$('.admin_info').hover(function() {
		$(this).tooltip({
            title: "<div style='width: 120px'>管理员微信<br>18113220863</div>",
            html: true,
            animation: false,
            placement: "bottom"
        });
	});



	var bennian = [];
	$.ajax({
	  	url: "<?php echo url('getval/getbennianval'); ?>",
	  	success: function(data){
	  		$.map(data,function(item){
	  			bennian.push(item);
	  		})
	  	}
	})


	var qunian = [];
	$.ajax({
	  	url: "<?php echo url('getval/getqunianval'); ?>",
	  	success: function(data){
	  		$.map(data,function(item){
	  			qunian.push(item);
	  		})
	  	}
	})

	let chart = new frappe.Chart( "#zhu_yingye_chart", {
		    data: {
		      labels: ["1月", "2月", "3月", "4月",
		      "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],

		      datasets: [
		        {
		          name: "今年", chartType: 'bar',
		          values: bennian
		        },
		        {
		          name: "去年", chartType: 'bar',
		          values: qunian
		        },
		      ]
		    },

		    title: "营业额同比",
		    type: 'axis-mixed',
		    height: 360,
		    colors: ['#5bc0de', '#428bca', 'light-blue'],

		    tooltipOptions: {
		      formatTooltipX: d => (d + '').toUpperCase(),
		      formatTooltipY: d => d + '元',
		    }
		  });


		
</script>
