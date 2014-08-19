
$("#btnApply").on("click",function(){
	if($.trim($('#amount').val())!='' && $.trim($('#amount').val())>'0')
	{
		$.ajax({
			type: 'post',
			url: baseurl+'index/applycoupon',
			data: 'Code='+$('#coupon').val()+"&Amt="$('#amount').val(),
			success: function (response) {
				var data=JQObj.parseJSON(response);
				if(data['status']=='Success')
				{
					var aldata="Now pay only : "+data['paymentAmt'] +" Inated of "+data['actualAmt'];
					alert(aldata);
				}
				else if(data['status']=='Error')
				{
					alert(data['Message']);
				}
				
			}
		});
	}
	else
	{
		alert("please insert amount first");
	}
});