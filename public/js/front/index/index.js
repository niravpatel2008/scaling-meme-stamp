
$("#btnApply").on("click",function(){
	$.ajax({
		type: 'post',
		url: baseurl+'index/applycoupon',
		data: 'Code='+$('#coupon').val(),
		success: function (data) {
			alert(data);
		}
	});
});