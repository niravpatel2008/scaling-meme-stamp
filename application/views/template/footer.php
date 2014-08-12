<!-- Footer -->
		<div id="footer">
			<!-- Copyright -->
			<ul class="copyright">
				<li>&copy; Ezcell. All rights reserved.</li></li>
			</ul>
		</div>
		
		<script src="<?=public_path()?>js/jquery.scrolly.min.js"></script>
		<script src="<?=public_path()?>js/jquery.scrollzer.min.js"></script>
		<script src="<?=public_path()?>js/skel.min.js"></script>
		<script src="<?=public_path()?>js/skel-layers.min.js"></script>
		<script src="<?=public_path()?>js/init.js"></script>
		 <?php if ($this->router->fetch_class() == "index") { ?>
        <script src="<?=public_path()?>js/front/index/index.js" type="text/javascript"></script>
    <?php } ?>
	</body>
</html>