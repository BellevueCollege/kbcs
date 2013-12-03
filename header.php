<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title>
	<?php if (is_front_page()) { bloginfo('name');?> @ Bellevue College <?php } else { 

	wp_title("",true);?> | <?php bloginfo('name'); 
	 } ?>

	</title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<link rel="profile" href="http://gmpg.org/xfn/11" />

	  		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/bootstrap.css">
	  		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/bootstrap-responsive.css">
	  		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/font-awesome.css">
			<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
			<link href='http://fonts.googleapis.com/css?family=Arvo:400,700|PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>

			<?php if(is_page('live-playlist')){ ?>
			
				<link href="<?php bloginfo('stylesheet_directory'); ?>/css/jplayer/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
			
			<?php } ?>
            
            
            <link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/kbcs-touch-icon-iphone.png" />
            <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('stylesheet_directory'); ?>/img/kbcs-ico-144x144.png" />
            <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/kbcs-ico-32x32.png" />
            <!--[if IE]><link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico" /><![endif]-->
            <meta name="msapplication-TileColor" content="#603312" />
			<meta name="msapplication-TileImage" content="<?php bloginfo('stylesheet_directory'); ?>/img/kbcs-ico-144x144.png" />
            <style>
            	#enable_javascript{
            		color: #FF0000;
            		font-weight: bold;
            		padding: 3px;	
            	}
            </style>
            
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="container wrapper"><!-- outer container -->
	<div class="container content"><!-- content container -->	
	<a href="#content" id="skipto-content">Skip to content</a>
	
	<?php 
		$options = get_option( 'funddrive_settings' );
		$start_date = $options['funddrive_startdate'];	
		$end_date = $options['funddrive_enddate'];
		$current_date = date("Y-m-d");
		
	    if($current_date >= $start_date && $current_date <= $end_date) {
    ?>
	
	<div class="row">
		<div class="span12">
			<div class="funddrive-alert alert alert-block alert fade in">
		
			<div class="row">					
				<div class="span8 funddrive_message">
						<h4 class="alert-heading"><?php echo $options['funddrive_message_title']; ?></h4>
						<p><?php echo $options['funddrive_message']; ?></p>
						
						    <ul class="inline">

							    <?php if(! empty($options['funddrive_button_url'])) { ?>
							    <li><a href="<?php echo $options['funddrive_button_url'];?>"><button class="btn btn-inverse"><?php echo $options['funddrive_button_title']; ?></button></a></li>
						    	<?php } ?>

							    <?php if(! empty($options['funddrive_button2_url'])) { ?>
							    	<li><a href="<?php echo $options['funddrive_button2_url']; ?>"><button class="btn btn-inverse"><?php echo $options['funddrive_button2_title']; ?></button></a></li>
						    	<?php } ?>

						    </ul>
				</div><!-- span8 -->	
				
				<div class="span3 funddrive_meter">
					<?php 
					    	$goal = $options['funddrive_goal'];
							$current = $options['funddrive_current'];
							$remaining = ($goal-$current);
							$remaining_percent = $current/$goal * 100;
							$progress = $remaining/$goal;
				    	?>
                    <h4>$<?php echo number_format($goal); ?> Goal</h4>
				    <div class="progress progress-striped active">
				    	
					    <div class="bar" style="width: <?php echo $remaining_percent; ?>%"><?php echo number_format($remaining_percent, 2); ?>%
						</div><!-- bar -->
				    </div><!-- progress -->
				 <!-- Start edited by Tripti Sharma  --> 


				 
				    <?php
				    	$funddrive_enddate = $options['funddrive_enddate'];
				    	$funddrive_enddate_usformat = date("F j, Y",strtotime($funddrive_enddate));
				    ?>

				    <p>Help us end our drive by 
				    	<?php 
							//echo $options['funddrive_enddate']; 
				    		echo $funddrive_enddate_usformat;
				    	?>
			    	</p>
			    	<!--End edited by Tripti Sharma   -->

				</div><!-- span3 -->
			</div><!-- row -->
			</div><!-- alert + funddrive-alert  -->
		</div><!-- span12 -->
	</div><!-- row -->

<?php  } else
        
?>

	<!-- Phone/Tablet Nav Menu -->
		<div class="row visible-phone">
			<div class="navbar top-mobile-nav">
				<div class="navbar-inner">
                	<div class="container">
                        <a class="btn btn-navbar menu" data-toggle="collapse" data-target=".nav-collapse">
                        	<span aria-hidden="true" data-icon="&#xf0c9;"></span>
                   			Menu
                        </a>
                        <a class="brand" href="<?php echo esc_url(home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/kbcs_logo_horiz.png" alt="91.3 KBCS (KBCS Logo)" title="KBCS home page" /></a>
                        <a class="play-btn" href="http://mobile.broadcastmatrix.com/kbcs/" title="Play live stream" target="_blank"><i class="icon-play pull-right"></i></a>
						<?php
							/** Loading WordPress Custom Menu with Fallback to wp_list_pages **/
							wp_nav_menu( array( 
								'menu' => 'main-nav', 
								'items_wrap'      => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
								'container_class' => 'nav-collapse', 
								'menu_class' => 'nav', 
								'fallback_cb' => 'wp_page_menu',
								'menu_id' => 'main-nav') 
							); 
						?>

                       </div><!--container-->
				</div><!-- navbar-inner -->
			</div><!-- navbar -->
		</div><!-- row -->

	<!-- Show Now Playing, Live Stream & Playlists/Audio Archives on small screens -->
		<div class="nowplaying visible-phone">
	    	<strong><a href="<?php echo home_url(); ?>/live-playlist/">Now Playing</a>:</strong>
	    </div> <!--#nowplaying-->

	
		<div class="row site-header">
			<div class="span12">
				<div class="row">
					<div class="span2">					
		                <div id="header-logo" class="hidden-phone">  
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/kbcs_logo.png" alt="91.3 KBCS"  title="KBCS home page" /></a>
							
						</div><!-- header-logo -->	
					</div><!-- span2 -->
					
					<div class="span10">
						<div class="row">
							<div class="span10">
							    <div class="input-append pull-right global-search hidden-phone">
                                
                               		 <form id="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"> 
                                        <span aria-hidden="true" data-icon="&#xf002;"></span>
                                        <input class="span3" type="text" name="s" value="<?php echo trim( get_search_query() ); ?>">
										<input type='hidden' name='post_type' value='programs,segments,staff,events,ads' />
                                         <input id="searchsubmit" value="Search" type="submit" class="btn" />
							    	</form>

                                
                                
                                </div><!-- input-append -->
							</div><!-- span10 -->
							
							<!-- Desktop Nav Menu -->
							<div class="span10 hidden-phone">					    
								<div class="navbar top-global-nav">
									<div class="navbar-inner">
                                    	<div class="container">
											<?php
												/** Loading WordPress Custom Menu with Fallback to wp_list_pages **/
												wp_nav_menu( array( 
													'menu' => 'main-nav', 
													'items_wrap'      => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
													'container_class' => 'nav-collapse', 
													'menu_class' => 'nav', 
													'fallback_cb' => 'wp_page_menu',
													'menu_id' => 'main-nav') 
												); 
											?>
                                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                            	<span aria-hidden="true" data-icon="&#xf0c9;"></span>
                                       			Menu
                                            </a>
                                           </div><!--container-->
									</div><!-- navbar-inner -->
								</div><!-- navbar -->
					    	</div><!-- span10 -->
					    </div><!-- row -->
					</div><!-- span10 -->
				</div><!-- row -->		
			</div><!-- span12 -->
		</div><!-- row -->


		<div id="enable_javascript">Please enable your javascript to have a better view of the website. Click <a href="http://activatejavascript.org" target="_blank">here</a> to learn more about it.</div>



		<script type="text/javascript">
			if(document.getElementById("enable_javascript"))
			{
				document.getElementById("enable_javascript").style.display = "none";
			}
		</script>