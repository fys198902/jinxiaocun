<?php /*a:1:{s:64:"C:\wamp64\www\jinxiaocun\application\index\view\Index\zhuce.html";i:1553126400;}*/ ?>
<div>
	<div class="panel panel-primary" style="width: 420px;margin: 60px auto;">
		<div class="panel-heading">
			<h3 class="panel-title">注册</h3>
		</div>
		<div class="panel-body">
			<div class="form-group" style="text-align: left">
				<label class="control-label">用户名</label>
				<input type="text" class="form-control" id='zhuc_username' placeholder="用户名">
			</div>

			<div class="form-group password" style="text-align: left">
				<label class="control-label">密码</label>
				<input type="password" class="form-control" id='zhuc_password' placeholder="密码">
			</div>

			<div class="form-group password" style="text-align: left">
				<label class="control-label">确认密码</label>
				<input type="password" class="form-control" id='zhuc_repassword' placeholder="确认密码">
			</div>

			<div class="form-group" style="text-align: left">
				<label class="control-label">公司名称</label>
				<input type="text" class="form-control" id='zhuc_gonngs' placeholder="公司名称">
			</div>

			<div class="form-group form-inline" style="text-align: left">
				<label class="control-label">验证码</label>
				<input type="text" class="form-control" id='yanzm' style="width: 140px;margin-left: 10px" placeholder="验证码">
				<img src="<?php echo url('Index/verify'); ?>" alt="captcha" id='yanzm_img' onclick="this.src='<?php echo url("Index/verify"); ?>?s/'+ Math.random()" />
			</div>

			<button type="submit" class="btn btn-success" style="width: 99%" id="zhuce">注册</button>

			<div style="width: 100%;display: flex;justify-content: space-between;padding: 10px 5px 0px 5px;">
				<span class="label label-info">3个月免费试用期</span>
				<span class="label label-warning">单用户600元/年</span>
				<span class="label label-success">每增加一个用户增加500元/年</span>
			</div>
			<span class="label label-danger center-block" style="margin-top: 5px">新用户，请先进行系统设置-客户物料等基础信息录入</span>
			<span class="label label-default center-block" style="margin-top: 5px">提供二次开发服务  微信：18113220863</span>

		</div>
	</div>
</div>

<script type="text/javascript">
	$('#zhuce').click(function(event) {
		if($('#zhuc_password').val() == $('#zhuc_repassword').val()){
			$.ajax({
				type: 'post',
				url: '<?php echo url("Index/zhuce_do"); ?>',
				data:{
					username: $('#zhuc_username').val(),
					password: $('#zhuc_password').val(),
					repassword: $('#zhuc_repassword').val(),
					gongs: $('#zhuc_gonngs').val(),
					yanzm: $('#yanzm').val()
				},
				success: function(msg){
					if(msg == true){
						window.location.reload('<?php echo url("Index/index"); ?>');
					}else{
						$('#yanzm_img').attr('src',"<?php echo url('index/verify'); ?>?s/" + Math.random());
						$('#zhuce').removeClass('btn-primary');
						$('#zhuce').addClass('btn-danger');
						$('#zhuce').text(msg);
					}
				}
			})
		}else{
			$('#zhuce').removeClass('btn-primary');
			$('#zhuce').addClass('btn-danger');
			$('#zhuce').text('两次密码不一致');
		}
		
	});
</script>