//判断是否空
function isempty(fids){
	var ftmp=true;
	fids.map(function(index, elem) {
		if($.trim($('#' + index).val())==''){
			$('#' + index).parent('div').addClass('has-error');
			ftmp = false;
		}else{
			$('#' + index).parent('div').removeClass('has-error');
		}
	})
	return ftmp;
}

//绑定日期自动填充
function datelist(fid){
	$('#' + fid).datetimepicker({
		language: "zh-CN",
		format: 'yyyy-mm-dd',//显示格式
		todayHighlight: true,//今天高亮
		minView: "month",//设置只显示到月份
		autoclose: true,//选择后自动关闭
		todayBtn: true
	});
}


//填充表格
function tablehangshul(hangshu){
	for(var i=1;i<hangshu;i++){
		$('.biaod_biaog table').append('<tr><td>' + i + '</td><td><input type="text" class="wuliao_id"></td><td><input type="text" class="wuliao"></td><td><select class="danw"></select></td><td><input type="text" class="shul" value="0" ></td><td><input type="text" class="danj" min="0" value="0" step="0.01"></td><td><input type="text" class="jine" value="0" step="0.01"></td><td><input type="text" class="beizhu"></td></tr>');
	}
}


//获取class的值
function getclassval(fclass){
	var row={};
	$(fclass).each(function(index, el) {
		row[index] = $(this).val();
	});
	return row;
}

//获取class的值
function getclasstext(fclass){
	var row={};
	$('.' + fclass).each(function(index, el) {
		row[index] = $(this).text();
	});
	return row;
}


//检查是否为数字
function checknumber(num) {
	var result = parseFloat(num);
	if (isNaN(result)) {
		return 0;
	}
	result = Math.round(num * 100) / 100;
	return result;
}

//提示
function showtz(msg, url){
	if(msg.indexOf(';')>-1){
		var arr = msg.split(';');
		$('#tongzhi_neirong').text(arr[0]);
		$('#erji_neirong').text(arr[1]);
	}else{
		$('#tongzhi_neirong').text(msg);
		$('#erji_neirong').text('');
	}

	$('#zhu_erweima').empty();
	if(url != ''){
		$('#zhu_erweima').append(url);
	}
	
	$('#tongzhi').modal('show');
}



//人民币大写
function renminbidaxie(n){    
	var fraction = ['角', '分'];    
	var digit = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];    
	var unit = [ ['元', '万', '亿'], ['', '拾', '佰', '仟']  ];    
	var head = n < 0? '欠': '';    
	n = Math.abs(n);    
	var s = '';    
	for (var i = 0; i < fraction.length; i++){    
		s += (digit[Math.floor(n * 10 * Math.pow(10, i)) % 10] + fraction[i]).replace(/零./, '');    
	}    
	s = s || '整';    
	n = Math.floor(n);    

	for (var i = 0; i < unit[0].length && n > 0; i++)     {    
		var p = '';    
		for (var j = 0; j < unit[1].length && n > 0; j++)     {    
			p = digit[n % 10] + unit[1][j] + p;    
			n = Math.floor(n / 10);    
		}    
		s = p.replace(/(零.)*零$/, '').replace(/^$/, '零')  + unit[0][i] + s;    
	}    
	return head + s.replace(/(零.)*零元/, '元').replace(/(零.)+/g, '零').replace(/^整$/, '零元整');    
}