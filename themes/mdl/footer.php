		</div><!-- container -->
    </div>
    
    <footer id="footer">
    	<nav id="footer-nav">
        	<ul class="menu">
                <li><a href="<?php echo esc_url( home_url( '/' ) )?>books/">Books</a></li>
                <li><a href="<?php echo esc_url( home_url( '/' ) )?>objects/">Antiques of the Future</a></li>
                <li><a href="<?php echo esc_url( home_url( '/' ) )?>about/">About</a></li>
                <li><a href="<?php echo esc_url( home_url( '/' ) )?>tv/">TV</a></li>
                <li><a href="<?php echo esc_url( home_url( '/' ) )?>press/">Press</a></li>
                <li><a href="<?php echo esc_url( home_url( '/' ) )?>events/">Events</a></li>
            	<li><a href="<?php echo esc_url( home_url( '/' ) )?>contact/">Contact</a></li>
        	</ul>
        </nav>
        <ul id="socs">
            <li><a href="#" class="fb fa fa-facebook-square"></a></li>
            <li><a href="#" class="tw fa fa-twitter"></a></li>
        	<li><a href="#" class="in fa fa-instagram"></a></li>
    	</ul>
	</footer>
    
    <div id="search">
    	<a href="#" class="search-close external" onclick="$('#search').removeClass('show'); return false;">Close</a>
    	<div class="search">
    		<h2>Search:</h2>
        	<div class="search-field"><input type="text" placeholder="Keyword, Designer" onkeypress="return getSearch(event, this);"></div>
        </div>
    </div>
    
    <div class="loading">
    	<div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    
    <div id="scrollToTop" onclick="scrollToTop();"></div>
    
    <bottomBorder>
    <?php do_action('wp_footer'); ?>
</body>
</html>