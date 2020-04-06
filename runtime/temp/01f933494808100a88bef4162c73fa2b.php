<?php /*a:1:{s:64:"C:\wamp64\www\jinxiaocun\application\index\view\Index\index.html";i:1583433060;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>供应链系统</title>
	<link href="public/static/css/bootstrap.min.css" rel="stylesheet">
	<link href="public/static/css/def.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="public/static/css/bootstrap-datetimepicker.min.css">
	<script src="public/static/js/jquery.min.js"></script>
	<script src="public/static/js/bootstrap.min.js"></script>
	<script src="public/static/js/bootstrap3-typeahead.min.js"></script>
	<script src="public/static/js/bootstrap-datetimepicker.min.js"></script>
	<script src="public/static/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="https://unpkg.com/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
	<script src="public/static/js/def.js"></script>
</head>
<body >
	<div id="zhuti">
		<div style="text-align: center;">
			<div class="panel panel-primary" style="width: 420px;margin: 60px auto;">
				<div class="panel-heading">
					<h3 class="panel-title">供应链系统</h3>
				</div>
				<div class="panel-body">
					<div class="form-group" style="text-align: left">
						<label class="control-label">用户名</label>
						<input type="text" class="form-control" id='fuser' placeholder="用户名">
					</div>
					<div class="form-group" style="text-align: left">
						<label class="control-label">密码</label>
						<input type="password" class="form-control" id='fpwd' placeholder="密码">
					</div>

					<div id='del_yanzm' class="form-group form-inline" style="text-align: left">
						<label class="control-label">验证码</label>
						<input type="text" class="form-control" id='yanzm' style="width: 140px;margin-left: 10px" placeholder="验证码">
						<img src="<?php echo url('index/verify'); ?>" alt="captcha" id='yanzm_img' onclick="this.src='<?php echo url("index/verify"); ?>?s/'+ Math.random()" />
					</div>
					<div style="display: flex;justify-content: space-between;">
						<button type="submit" class="btn btn-warning" style="width: 49%" id="zhuce">注册</button>
						<button type="submit" class="btn btn-success" style="width: 49%" id="login">登录</button>
					</div>
					<small style="margin-top: 5px; color: #ccc">微信：18113220863 &nbsp 提供二次开发服务</small>
				</div>
			</div>
		</div>
		<div style="position: fixed; bottom: 5px;right: 15px" style="text-align: center; width: 100%">备案号：鲁ICP备18055211号-1</div>
	</div>


	<script type="text/javascript">
		$.ajax({
			url: '<?php echo url("Index/checklogin"); ?>',
			success: function(res){
				if(res){
					$('#zhuti').empty();
					$('#zhuti').load('<?php echo url("Index/zhu"); ?>');
				}
			}
		})
		

		$('#login').click(function(event) {
			if(isempty(['fuser','fpwd','yanzm'])){
				$.ajax({
					type: 'post',
					url: '<?php echo url("index/login"); ?>',
					data:{
						fuser: $('#fuser').val(),
						fpwd: $('#fpwd').val(),
						fyanzm: $('#yanzm').val()
					},
					success: function(msg){
						if(msg == true){
							$('#zhuti').empty();
							$('#zhuti').load('<?php echo url("Index/zhu"); ?>');
						}else{
							$('#yanzm_img').attr('src',"<?php echo url('index/verify'); ?>?s/" + Math.random());
							$('#login').removeClass('btn-primary');
							$('#login').addClass('btn-danger');
							$('#login').text(msg);
						}
					}
				})
			}

		});


		$('#zhuce').click(function(event) {
			$('#zhuti').empty();
			$('#zhuti').load('<?php echo url("Index/zhuce"); ?>');
		});



		var isChrome = window.navigator.userAgent.indexOf("Chrome") !== -1;
		var isSafari = window.navigator.userAgent.indexOf("Safari") !== -1;
		var isFirefox = window.navigator.userAgent.indexOf("Firefox") !== -1;


		if (!isChrome && !isSafari && !isFirefox) {
			alert("请使用Chrome或Firefox内核的浏览器。例如：谷歌浏览器、360浏览器、火狐浏览器等");
			$('#login').attr('disabled','disabled');
		}
	</script>
</body>
</html>