<div class='clear'></div>
</div>

<div class="container" id="bottom">
	<ul>

	<?php if ( !function_exists('dynamic_sidebar')
	        || !dynamic_sidebar("Footer") ) : ?>  
	
	<?php endif; ?>
	
	</ul>
	<div class='clear'></div>
</div>

<div class="container" id="footer">
	<div class="fcred">
		Copyright &copy; 2016-<?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> - <?php bloginfo('description'); ?>.<br />
		<span class="icon-office"></span> 中国北京市海淀区中关村北大街128号 | No.128 Zhongguancun North Street, Haidian District, Beijing, China<br/>
		<span class="icon-phone"></span> 010-62754420<br/><br/>
		Please report problems to support: milliele@pku.edu.cn / ljzh2014@pku.edu.cn.
	</div>	
<div class='clear'></div>	
<?php wp_footer(); ?>
</div>
<div class='clear'></div>	
</div>
</body>
</html>      
