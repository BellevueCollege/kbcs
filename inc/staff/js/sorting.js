/////////////////////////////////////////////////////////////////////////////////////////////////////
// THIS SCRIPT APPLIES TO THE CUSTOM SCRIPT MODIFICATION ALLOWING HIERARCHICAL PAGES TO BE REORDERED
/////////////////////////////////////////////////////////////////////////////////////////////////////

// NOTE: make sure the previous code added to your functions.php file references this code correctly.

jQuery("table.widefat tbody").sortable({  
    cursor: 'move',
    //handle: '.column-order img',
    axis: 'y',
    containment: 'table.widefat',
    scrollSensitivity: 40,
    helper: function(e, ui) {                   
        ui.children().each(function() { jQuery(this).width(jQuery(this).width()); });
        return ui;
    },
    start: function(event, ui) {
        if ( ! ui.item.hasClass('alternate') ) ui.item.css( 'background-color', '#ffffff' );
        ui.item.children('td, th').css('border','none');
        ui.item.css( 'outline', '1px solid #dfdfdf' );
    },
    stop: function(event, ui) {     
        ui.item.removeAttr('style');
        ui.item.children('td, th').removeAttr('style');
    },
    update: function(event, ui) {   
        if ( ui.item.hasClass('inline-editor') ) {
            jQuery("table.widefat tbody").sortable('cancel');
            alert( 'Please close the quick editor before reordering this item.' );
            return;
        }

        var postid = ui.item.find('.check-column input').val(); // THIS POST ID
        var postparent = ui.item.find('.post_parent').html();   // POST PARENT

        var prevpostid = ui.item.prev().find('.check-column input').val();
        var nextpostid = ui.item.next().find('.check-column input').val();

        // can only sort in same tree

        var prevpostparent = undefined;
        if ( prevpostid != undefined ) {
            var prevpostparent = ui.item.prev().find('.post_parent').html()
            if ( prevpostparent != postparent) prevpostid = undefined;
        }

        var nextpostparent = undefined;
        if ( nextpostid != undefined ) {
            nextpostparent = ui.item.next().find('.post_parent').html();
            if ( nextpostparent != postparent) nextpostid = undefined;
        }   

        // DISPLAY AN ALERT MESSAGE IF ANY OF THE FOLLOWING TAKES PLACE
        // IF PREVIOUS AND NEXT ARE NOT AT THE SAME TREE LEVEL OR NOT AT THE SAME TREE LEVEL AND THE PREVIOUS PAGE IS THE PARENT OF THE NEXT OR JUST MOVED BENEATH ITS OWN CHILDREN                     
        if ( ( prevpostid == undefined && nextpostid == undefined ) || ( nextpostid == undefined && nextpostparent == prevpostid ) || ( nextpostid != undefined && prevpostparent == postid ) ) {
            jQuery("table.widefat tbody").sortable('cancel');
            alert( "SORRY, THIS ACTION IS NOT POSSIBLE!\n\n>>> WHY THIS DOES NOT WORK:\nDrag-and-Drop capabilities only work for items within their current tree.\n\n>>> HERE IS HOW YOU CAN MOVE IT:\nIn order to move this item to the location you specified you simply need to use the \"Quick Edit\" link and modify the associated \"Parent\" page.\n\n>>> LOCATING THE QUICK EDIT LINK:\nOn the post you want to move, just hover over the post title and click on the \"Quick Edit\" link which appears below the title." );
            return;
        }

        // SHOW AJAX SPINNING SAVE ELEMENT
        ui.item.find('.check-column input').hide().after('<img alt="processing" src="images/wpspin_light.gif" class="waiting" style="margin-left: 6px;" />');

        // EXECUTE THE SORTING VIA AJAX
        jQuery.post( ajaxurl, { action: 'simple_page_ordering', id: postid, previd: prevpostid, nextid: nextpostid }, function(response){           
            if ( response == 'children' ) window.location.reload();
            else ui.item.find('.check-column input').show().siblings('img').remove();
        });

        // FIX CELL COLORS
        jQuery( 'table.widefat tbody tr' ).each(function(){
            var i = jQuery('table.widefat tbody tr').index(this);
            if ( i%2 == 0 ) jQuery(this).addClass('alternate');
            else jQuery(this).removeClass('alternate');
        });
    }
}).disableSelection();