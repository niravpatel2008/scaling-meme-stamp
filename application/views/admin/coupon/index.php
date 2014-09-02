<section class="content-header clearfix">
    <h1 class="pull-left">
        Manage Coupons
        <!-- <small>Control panel</small> -->
    </h1>
	<div class="pull-right">
		<button class="btn btn-primary btn-xs" title="Minimize All" onclick="$('[data-widget=\'collapse\']').click();"><i class="fa fa-minus"></i></button>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div id="flash_msg">
				<?php
					if ($this->session->flashdata('flash_type') == "success") {
						echo success_msg_box($this->session->flashdata('flash_msg'));
					}

					if ($this->session->flashdata('flash_type') == "error") {
						echo error_msg_box($this->session->flashdata('flash_msg'));
					}
				?>
			</div>
		</div>
	</div>
	<div class='row'>
		<?php if ($this->user_session['role'] == 'a') { ?>
		<div class="col-md-4">
			<div class="box">
				<div class="box-header">
                     <h3 class="box-title">Select User</h3>
					 <div class="box-tools pull-right">
						<button class="btn btn-primary btn-xs" data-toggle="tooltip" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
					</div>
                </div>
                <div class="box-body">
					<select class="form-control validate[required]" id="t_uid" name="t_uid">
						<option value="">Select</option>
						<?php foreach ($users as $user) { ?>
							<option value='<?=$user->id; ?>'><?=$user->Firstname." (".$user->EmailId.")"; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="col-md-4">
			<div class="box">
				<div class="box-header">
                     <h3 class="box-title">Generate Coupon Codes</h3>
					 <div class="box-tools pull-right">
						<button class="btn btn-primary btn-xs" data-toggle="tooltip" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
					</div>
                </div>
				<form id='coupon_form' name='coupon_form' role="form" action="<?=admin_path()?>coupon/add" method="post">
                <div class="box-body">
					<div class="form-group">
                        <label>Name:</label>
                        <input type="text" placeholder="Enter ..." class="form-control validate[required]" name="coupon_name" id="coupon_name" value="" />
                    </div>
					<div class="form-group">
							<label for="coupon_offer">Type:</label>
							<select class="form-control validate[required]" id="coupon_type" name="coupon_type">
								<option value="">Select</option>
								<option value='Topup'>Topup</option>
								<option value='Offer'>Offer</option>
							</select>
					</div>
					<div class="form-group" id='coupon_disounton_div' style='display:none;'>
							<label for="coupon_disounton">Discount on minimun recharge:</label>
							<input type="text" placeholder="Enter ..." class="form-control" name="coupon_disounton" id="coupon_disounton" value="" />
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-4 form-group">
								<label>Amount</label>
								<input type="text" placeholder="Coupon Amount" id="coupon_price" name='coupon_price' class="coupon_price changeprice form-control" value="" >
							</div>

							<div class="col-xs-4 form-group">
								<label>Coupons</label>
								<input type="text" placeholder="Count" id="coupon_count" name='coupon_count' class="coupon_count changeprice form-control"  value="" >
							</div>

							<div class="col-xs-4 form-group">
								<label>Total</label>
								<input type="text" placeholder="Total" id="amt_total" class="amt_total form-control" value="" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
							<label for="coupon_status">Status:</label>
							<select class="form-control validate[required]" id="coupon_status" name="coupon_status">
								<option value='Active'>Active</option>
								<option value='Inactive'>Inactive</option>
							</select>
					</div>
					<div class="form-group">
							<label for="coupon_timeperiod">Start & End Time:</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
								<input placeholder="Select Start & End Time" id="coupon_timeperiod" class="form-control validate[required]" name="coupon_timeperiod" value="">
							</div>
					</div>
				</div>
				<div class='box-footer'>
					<div class="form-group">
                        <button class="btn btn-primary btn-flat" type="submit" id="submit">Submit</button>
                    </div>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-4">
			<div class="box">
				<div class="box-header">
                     <h3 class="box-title">Select Coupon</h3>
					 <div class="box-tools pull-right">
						<button class="btn btn-primary btn-xs" data-toggle="tooltip" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
					</div>
                </div>
                <div class="box-body">
					<div class="box-body">
						<select class="form-control validate[required]" id="select_coupon" name="select_coupon">
							<?php foreach ($coupons as $coupon) { ?>
								<option value='<?=$coupon->id; ?>'><?=$coupon->Name." (".$coupon->Type.")"; ?></option>
							<?php } ?>						
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-md-12">
            <div id="list">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Coupon codes</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="codeTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Deal</th>
                                    <th>Dealer</th>
                                    <th>User</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Payment Option</th>
                                    <th>Amount Paid</th>
                                    <th>Deal Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Deal</th>
                                    <th>Dealer</th>
                                    <th>User</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Payment Option</th>
                                    <th>Amount Paid</th>
                                    <th>Deal Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</section>
