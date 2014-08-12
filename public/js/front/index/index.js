
$("#Proceed").on("click",function(){
	$.ajax({
		type: 'post',
		url: baseurl+'index/getdetail',
		data: 'Mn='+$('#mobileno').val()+"&Pr="+$('#provider').val()+"&Rm="+$('#amount').val(),
		success: function (data) {
			if(data!='Error')
			{
				$("#userDetail").html(data);
			}
			else
			{
				$("#userDetail").html("There is error in your data");
			}
		}
	});
});