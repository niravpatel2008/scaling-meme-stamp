<script>
$(document).ready(function(){
	<?php if(isset($userdetailError) && $userdetailError==true) { ?>
		$("#Proceed").trigger('click');
	<?php } ?>
});
</script>
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
			<h2 class="alt">Welcome to Ezcell</h2>
		</header>
		<div class="row">	
			<?php if(form_error('firstname')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('firstname') ?> </div> <?php } ?>
			<?php if(form_error('lastname')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('lastname') ?> </div><?php } ?>
			<?php if(form_error('emailId')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('emailId') ?> </div><?php } ?>
			<?php if(form_error('state')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('state') ?> </div><?php } ?>
			<?php if(form_error('city')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('city') ?> </div><?php } ?>
			<?php if(form_error('password')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('password') ?> </div><?php } ?>
			<?php if(form_error('repassword')!='') { ?><div class="12u errorMsg" id="errorMsg"> <?php echo form_error('repassword') ?> </div><?php } ?>
			<div class="8u" id="userDetail">
			<table>
			<tr>
				<td  align="left">
					<label>Prepaid Mobile No : </label>
				</td>
				<td align="left">
					<input type="number" name="mobileno" id="mobileno"/>
				</td>
			</tr>
			<tr>
				<td  align="left">
					<label>Your provider : </label>
				</td>
				<td align="left">
					<select id="provider" name="provicer">
						<option value="">-- Select --</option>
						<option value="1">Airtel</option>
						<option value="1">Vodaphone</option>
						<option value="1">idea</option>
					</select>
				</td>
			</tr>
			<tr>
				<td  align="left">
					<label>Recharge amount : </label>
				</td>
				<td align="left">
					<input type="number" name="amount" id="amount"/>
				</td>
			</tr>
			<tr>
				<td  colspan="2" align="center"> 
					<input type="button" name="Proceed" id="Proceed" value="Proceed">
				</td>
			</tr>
			</table>
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

			