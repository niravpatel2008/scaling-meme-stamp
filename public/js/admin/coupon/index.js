var oTable;
$(document).ready(function() {
	$("#coupon_form").validationEngine();
	$('#coupon_timeperiod').daterangepicker({format: 'MM/DD/YYYY'});
	$(".changeprice").on("blur",function(){
		var coupon_price = parseInt($(this).closest("div.row").find(".coupon_price").val());
		var coupon_count = parseInt($(this).closest("div.row").find(".coupon_count").val());
		if (!isNaN(coupon_price) && coupon_price != "" && !isNaN(coupon_count) && coupon_count != "")
		{
			amt_total = coupon_price * coupon_count;
			if (amt_total >= 0)
				$(this).closest("div.row").find(".amt_total").val(amt_total);
		}
	});

	$('#coupon_uid').on('change',function(){
		$('#tblUser_id').val($(this).val());
		var url = admin_path()+'coupon/coupon_list/';
		$.post(url,{"tblUser_id":$(this).val()},function(e){
			e = JSON.parse(e);
			var optHtml = "";
			for(option in e)
			{
				opt = e[option];
				optHtml += "<option value='"+opt.id+"'> "+opt.name+" ("+opt.Type+") </option>";
			}
			$('#select_coupon').html(optHtml);
			$('#select_coupon').change();
		});
	});

	$('#coupon_type').on('change',function(){
		if($(this).val()=='Offer')
			$('#coupon_disounton_div').show().find("input").addClass("validate[required]");
		else
			$('#coupon_disounton_div').hide().find("input").removeClass("validate[required]");
	});

	$("#select_coupon").on("change",function(){
		var coupon_id = $(this).val();
		//if (coupon_id == "") return;

		oTable.fnClearTable(0);
		oTable.fnDraw();
	});

	oTable = $('#codeTable').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": admin_path ()+'coupon/code_list/',
			"type": "POST",
			"data": function ( d ) {
                d.tblcoupon_id = $("#select_coupon").val();
            }
		},
		aoColumnDefs: [
		  {
			 bSortable: false,
			 aTargets: [ -1 ]
		  }
		]
	} );
} );