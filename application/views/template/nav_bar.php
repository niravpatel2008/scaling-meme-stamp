
<!-- Header -->
	<div id="header" class="skel-layers-fixed">
		<?php
			if (isset($this->front_session['id']) && $this->front_session['id'] > 0) {
				$user_Data = $this->common_model->selectData(TBLUSER, 'Firstname, Lastname, EmailId', array('id' => $this->front_session['id']));
			}
		?>
		<div class="top">
			<!-- Logo -->
			<div id="logo">
				<?php
					if (isset($this->front_session['id']) && $this->front_session['id'] > 0) {
				?>
					<span class="image avatar48"><img src="<?=public_path()?>images/avtar.png" alt="" /></span>
					<h1 id="title">
						<?=ucwords($user_Data[0]->Firstname.' '.$user_Data[0]->Lastname)?>
						<a href="<?=base_url()?>profile/edit">
							<img src="<?=public_path()?>images/edit_icon.png" alt="Edit Profile" style="height:32px; width:32px;" />
						</a>
					</h1>
					<p>
						<?=$user_Data[0]->EmailId?><br/>
						<a href="<?=base_url()?>signout">Sign out</a>
					</p>
				<?php
					}else{
				?>
					<span class="image avatar48"><img src="<?=public_path()?>images/avtar.png" alt="" /></span>
					<h1 id="title">Hello Guest</h1>
					<a href="<?=base_url()?>signin">Sign in</a>
				<?php
					}
				?>

			</div>
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li><a href="<?=base_url()?>index/index" class="skel-layers-ignoreHref"><span class="icon fa-home">Home</span></a></li>
					<li><a href="<?=base_url()?>index/articals" class="skel-layers-ignoreHref"><span class="icon fa-th">Articals</span></a></li>
					<li><a href="<?=base_url()?>index/aboutus" class="skel-layers-ignoreHref"><span class="icon fa-user">About Me</span></a></li>
					<li><a href="<?=base_url()?>index/contactus" class="skel-layers-ignoreHref"><span class="icon fa-envelope">Contact</span></a></li>
				</ul>
			</nav>
		</div>
		<div class="bottom">
			<!-- Social Icons -->
			<ul class="icons">
				<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
				<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
				<li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
			</ul>
		</div>
	</div>
