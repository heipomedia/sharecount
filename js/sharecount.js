// Load share count after page has loaded
jQuery(window).on('load', function() {

    // Get post id from div
    var post_id = $('.sharing-buttons-post-id').data('postid');

    // Get facebook share counts
    $.ajax({
        url : get_fb_sharecount.ajax_url,
        type : 'get',
        data : {
            action : 'sharecount_fb',
            post_id: post_id,
            sc_fb_nonce: get_fb_sharecount.fb_sharecount_nonce
        },
        success : function( response ) {
			$('.sharecount_fb').html( response );
		}
    });

    // Get twitter share counts from opensharecount.com (please register)
    $.ajax({
        url : get_tw_sharecount.ajax_url,
        type : 'get',
        data : {
            action : 'sharecount_tw',
            post_id: post_id,
            sc_tw_nonce: get_tw_sharecount.tw_sharecount_nonce
        },
        success : function( response ) {
			$('.sharecount_tw').html( response );
		}
    });

    // Get mail share counts (per click one share)
    $('.sharing-button--mail').click(function(){
        $.ajax({
            url : get_mail_sharecount.ajax_url,
            type : 'post',
            data : {
                action : 'sharecount_mail',
                post_id: post_id,
                sc_mail_nonce: get_mail_sharecount.mail_sharecount_nonce
            },
            success : function( response ) {
    			$('.sharecount_mail').html( response );
    		}
        });

    });

});
