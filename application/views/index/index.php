
<style>
.errorMsg{
color:red;
padding:0;
margin:0 !important;
font-size:18px;
font-weight:bold;
height:30px;
}
</style>
<!-- Intro -->
<section id="top" class="one dark cover">
	<div class="container">

		<header>
			<h2 class="alt">Welcome</h2>
		</header>
		<div class="row">	
			<?php if(form_error('mobileno')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('mobileno') ?> </div><?php } ?>
			<?php if(form_error('provider')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('provider') ?> </div><?php } ?>
			<?php if(form_error('amount')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('amount') ?> </div><?php } ?>
			<?php if(form_error('firstname')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('firstname') ?> </div> <?php } ?>
			<?php if(form_error('emailId')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('emailId') ?> </div><?php } ?>
			<?php if(form_error('password')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('password') ?> </div><?php } ?>
			<?php if(form_error('repassword')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('repassword') ?> </div><?php } ?>
	<div class="8u" id="userDetail">
	
	<form name="userdetail" method="post">
			<table>
			<tr>
				<td  align="left">
					<label>Prepaid Mobile No : </label>
				</td>
				<td align="left">
					<input type="number" class="form-control" name="mobileno" id="mobileno"/>
				</td>
			</tr>
			<tr>
				<td  align="left">
					<label>Your provider : </label>
				</td>
				<td align="left">
					<select id="provider" class="form-control" name="provider">
						<option value="">-- Select --</option>
						<option value="3">Airtel</option>
						<option value="12">Vodaphone</option>
						<option value="10">idea</option>
					</select>
				</td>
			</tr>
			<tr>
				<td  align="left">
					<label>Recharge amount (Rs): </label>
				</td>
				<td align="left">
					<input type="number" class="form-control" name="amount" id="amount"/>
				</td>
			</tr>
		<tr>
			<td  align="left">
				<label>Coupon code : </label>
			</td>
			<td align="left">
				<input type="text" class="form-control" style="width:75%;display: inline;" name="coupon" id="coupon"/>
				<input type="button" class="btn btn-Primary" id="btnApply" style="display: inline;height:34px;"value="Apply">
			</td>
		</tr>
		<tr id="disamountrow" style="display:none;">
			<td  align="left">
				<label>Discount amount (Rs): </label>
			</td>
			<td align="left">
				<span id="disamount"></span>
			</td>
		</tr>
		<tr id="payamountrow"  style="display:none;">
			<td  align="left">
				<label>Total pay amount (Rs): </label>
			</td>
			<td align="left">
				<span id="payamount"> </span>
			</td>
		</tr>
		<tr>
			<td  align="left">
				<label>Name : </label>
			</td>
			<td align="left">
				<input type="text" name="username" class="form-control" id="username" />
			</td>
		</tr>
		<tr>
			<td  align="left">
				<label>Email : </label>
			</td>
			<td align="left">
				<input type="text" name="emailId" class="form-control" id="emailId"/>
			</td>
		</tr>
		
		<tr class="passwordfield" style="display:none;">
			<td  align="left">
				<label>Password</label>
			</td>
			<td align="left">
				<input type="password" name="password" class="form-control" id="password"/>
			</td>
		</tr>
		<tr class="passwordfield" style="display:none;">
			<td  align="left">
				<label>Repeat password</label>
			</td>
			<td align="left">
				<input type="password" name="repassword" class="form-control" id="repassword"/>
			</td>
		</tr>		
			<tr>
				<td  colspan="2" align="center"> 
					<input type="submit" class="btn btn-info" style="height:34px;" name="Proceed" id="Proceed" value="Proceed">
				</td>
			</tr>
			</table>
		</form>
	</div>
			<!--div class="4u">
				here we display google add.
			</div>
			<div class="12u">
				here we display google add.
			</div-->
		</div>
		<footer>
			
		</footer>

	</div>
</section>

	<script>
$(document).ready(function(){
	
});
$("#beuser").on('change',function(){
	if($("#beuser").is(':checked'))
	{	
		$(".passwordfield").show();
	}
	else
	{
		$(".passwordfield").hide();
	}
});
$("#mobileno").on('blur',function(){
	if($("#mobileno").val()!='' && $("#mobileno").val().length==10)
	{
		$.ajax({
			type:'post',
			url:baseurl+"index/checkuser",
			data:'mo='+$("#mobileno").val(),
			success:function(data){
				if(data=='Exist')
				{
					$(".passwordfield").hide();
				}
				else
				{
					$(".passwordfield").show();
				}
			}
			});
	}
	else
	{
		$(".passwordfield").hide();
	}
});
</script>		