<section class="content-header">
    <h1>
        Users
        <small>
            <?=($this->router->fetch_method() == 'add')?'Add User':'Edit User'?>
        </small>
    </h1>
    <?php
		$this->load->view(ADMIN."/template/bread_crumb");
	?>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-6">
    		<div class="box-body">
                <?php
                    if (@$flash_msg != "") {
                ?>
                    <div id="flash_msg"><?=$flash_msg?></div>
                <?php
                    }
                ?>
                <form id='user_form' name='user_form' role="form" action="" method="post">
                    <div class="form-group <?=(@$error_msg['Firstname'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['Firstname'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['Firstname']?></label><br/>
                        <?php
                            }
                        ?>
                        <label>First Name:</label>
                        <input type="text" placeholder="Enter ..." class="form-control validate[required]" name="Firstname" id="Firstname" value="<?=@$user[0]->Firstname?>" >
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="Lastname" id="Lastname" value="<?=@$user[0]->Lastname?>" >
                    </div>
                    <div class="form-group <?=(@$error_msg['EmailId'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['EmailId'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['EmailId']?></label><br/>
                        <?php
                            }
                        ?>
                        <label for="EmailId">Email address:</label>
                        <input type="EmailId" placeholder="Enter email" id="EmailId" class="form-control validate[required,custom[email]]" name="EmailId" value="<?=@$user[0]->EmailId?>" >
                    </div>
                    <div class="form-group <?=(@$error_msg['Mobileno'] != '')?'has-error':'' ?>">
						<?php
                            if(@$error_msg['Mobileno'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['Mobileno']?></label><br/>
                        <?php
                            }
                        ?>
                        <label>Contact:</label>
                        <input type="text" placeholder="Enter ..." class="form-control validate[required,custom[phone]" name="Mobileno" id="Mobileno" value="<?=@$user[0]->Mobileno?>">
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="City" id="City" value="<?=@$user[0]->City?>">
                    </div>
                    <div class="form-group">
                        <label>State:</label>
                        <input type="text" placeholder="Enter ..." class="form-control" name="State" id="State" value="<?=@$user[0]->State?>">
                    </div>
                    <div class="form-group <?=(@$error_msg['role'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['role'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['role']?></label><br/>
                        <?php
                            }
                        ?>
                        <label>Role</label>
                        <select class="form-control validate[required]" name="Role" id="Role">
                            <option value="">Select</option>
                            <option value="a" <?=(@$user[0]->Role == 'a')?'selected':''?> >Admin</option>
                            <option value="u" <?=(@$user[0]->Role == 'u')?'selected':''?> >User</option>
                        </select>
                    </div>
					<div class="form-group <?=(@$error_msg['Status'] != '')?'has-error':'' ?>">
                        <?php
                            if(@$error_msg['Status'] != ''){
                        ?>
                            <label for="inputError" class="control-label"><i class="fa fa-times-circle-o"></i><?=$error_msg['Status']?></label><br/>
                        <?php
                            }
                        ?>
                        <label>Status</label>
                        <select class="form-control validate[required]" name="Status" id="Status">
                            <option value="">Select</option>
                            <option value="Active" <?=(@$user[0]->Status == 'Active')?'selected':''?> >Active</option>
                            <option value="Inactive" <?=(@$user[0]->Status == 'Inactive')?'selected':''?> >Inactive</option>
                            <option value="Block" <?=(@$user[0]->Status == 'Block')?'selected':''?> >Block</option>
                        </select>
                    </div>
					<div class="form-group">
                        <label>Password:</label>
                        <input type="password" placeholder="Password" class="form-control validate[minSize[5],maxSize[15]]" name="Password" id="Password">
                    </div>
					<div class="form-group">
                        <label>Repeat Password:</label>
                        <input type="password" placeholder="Repeat Password" class="form-control validate[equals[Password]]" name="re_Password" id="re_Password">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-flat" type="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</section>
