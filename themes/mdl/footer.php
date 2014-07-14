		</div><!-- container -->
    </div>
    
    <footer id="footer">
    	<nav id="footer-nav">
        	<ul class="menu">
                <li><a href="#">Books</a></li>
                <li><a href="#">Antiques of the Future</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">TV</a></li>
                <li><a href="#">Press</a></li>
            	<li><a href="#">Contact</a></li>
        	</ul>
        </nav>
        <ul id="socs">
            <li><a href="#" class="fb">FaceBook</a></li>
            <li><a href="#" class="tw">Twitter</a></li>
        	<li><a href="#" class="in">Instagram</a></li>
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
    
    <bottomBorder>
    <?php do_action('wp_footer'); ?>
</body>
</html>