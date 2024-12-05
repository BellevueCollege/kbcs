<form id="search" label="Search" role="search" class="hidden-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"> 
  <div class="input-append">
		<span aria-hidden="true" data-icon="&#xf002;"></span>
		<input class="input-xlarge" aria-label="Search" type="text" name="s" value="<?php echo trim( get_search_query() ); ?>"/>
		<input type='hidden' name='post_type' value='programs,segments,staff,events,ads' />
		<button id="searchsubmit" value="Search" type="submit" class="btn">Search</button>
  </div>
</form>
