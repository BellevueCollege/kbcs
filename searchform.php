<form id="search" class="" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"> 
  <div class="input-append">
		<span aria-hidden="true" data-icon="&#xf002;"></span>
		<input label="Search" class="input-xlarge" type="text" name="s" value="<?php echo trim( get_search_query() ); ?>">
		<input type='hidden' name='post_type' value='programs,segments,staff,events,ads' />
		<button label="button" id="searchsubmit" value="Search" type="submit" class="btn">Search</button>
  </div>
</form>