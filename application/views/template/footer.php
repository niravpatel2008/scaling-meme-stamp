<!-- Footer -->
		<div id="footer">
			<!-- Copyright -->
			<ul class="copyright">
				<li>&copy; Ezcell. All rights reserved.</li>
			</ul>
		</div>
		<script src="<?=public_path()?>js/bootstrap.min.js"></script>
		<script src="<?=public_path()?>js/jquery.scrolly.min.js"></script>
		<script src="<?=public_path()?>js/jquery.scrollzer.min.js"></script>
		<script src="<?=public_path()?>js/skel.min.js"></script>
		<script src="<?=public_path()?>js/skel-layers.min.js"></script>
		<script src="<?=public_path()?>js/init.js"></script>

		<?php if ($this->router->fetch_class() == "index" && in_array($this->router->fetch_method(), array("index"))) { ?>
        	<script src="<?=public_path()?>js/front/index/index.js" type="text/javascript"></script>
    	<?php } ?>

    	<?php if ($this->router->fetch_class() == "index" && in_array($this->router->fetch_method(), array("login"))) { ?>
        	<script src="<?=public_path()?>js/front/index/login.js" type="text/javascript"></script>
    	<?php } ?>
		
	</body>
</html>
