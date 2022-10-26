// On Load, Get Content from API and Render
jQuery(document).ready(function() {
    // Get Data from API
    get_now_playing();
    // Render Data    
    function get_now_playing() {
        // Get Data from API
        jQuery.getJSON("/wp-json/kbcsapi/v1/now-playing").done(
            function(data) {
                if (data) {
                    jQuery('h1#hero-title').html(data.current.title);
                    jQuery('#hero-host').html(data.current.host);
                    jQuery('#hero-airtimes').html(data.current.airtimes);
                    jQuery('#hero-link').attr('href', data.current.permalink);
                    if (data.current.image_url) {
                        jQuery('#hero-image img').attr('src', data.current.image_url)
                            .attr('alt', data.current.image_alt);
                    }
                    jQuery('#hero-block').removeClass('loading');
                    jQuery('#hero-block .loading').remove();
                    

                    // get first element with the class of 'title' inside the ul with the id of 'hero-past'
                    jQuery('#hero-past-title').html(data.previous.title);
                    jQuery('#hero-past-time').html(data.previous.airtimes);
                    jQuery('#hero-past-link').attr('href', data.previous.permalink);

                    jQuery('#hero-future-title').html(data.next.title);
                    jQuery('#hero-future-time').html(data.next.airtimes);
                    jQuery('#hero-future-link').attr('href', data.next.permalink);

                    jQuery('#hero-past-future').removeClass('loading');


                }
            }
        )
    }
});
