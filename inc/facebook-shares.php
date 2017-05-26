<?php
/**
 * Facebook Shares
 */
function sharecount_fb()
{
    // Check if nonce is correct (no abuse)
	if ( ! check_ajax_referer('fb_sharecount_nonce', 'sc_fb_nonce' ) )
		die ( 'Nope');

    // Get post id from ajax
    $post_id = $_REQUEST['post_id'];

    // Check if we just make a request to check how many shares we have
    if(get_transient('sharecount_facebook-'.$post_id) === false) :

        // Make the api call to get the shares
        $api_call = wp_remote_get(
            'https://graph.facebook.com/?id='.get_permalink($post_id),
            array('timeout' => 5)
        );

        // Get the status code from the API call
        $status_code = wp_remote_retrieve_response_code($api_call);

        // If API call was successful, proceed
        if($status_code == 200) :

            // Decode to JSON and get shares
            $api = json_decode(wp_remote_retrieve_body($api_call));
            $shares = $api->share->share_count;

            // Save to postmeta table
            update_post_meta($post_id, 'sharecount_facebook', $shares);

            // Set transient
            set_transient('sharecount_facebook-'.$post_id, $shares, 3 * HOUR_IN_SECONDS );

        else :

            // If Facebook API is down, then store nothing and get the shares from our postmeta entry
            $shares = get_post_meta($post_id, 'sharecount_facebook', true);
            $shares = empty($shares) ? 0 : $shares;

            // Set transient and try again to contact Facebook API in 3 hours
            set_transient('sharecount_facebook-'.$post_id, $shares, 3 * HOUR_IN_SECONDS );

        endif;

    else :

        // When we checked, get the shares from our postmeta entry
        $shares = get_post_meta($post_id, 'sharecount_facebook', true);
        $shares = empty($shares) ? 0 : $shares;

    endif;

    // Return the shares to our ajax response
    echo $shares;

    exit;
}
add_action('wp_ajax_nopriv_sharecount_fb', 'sharecount_fb');
add_action('wp_ajax_sharecount_fb', 'sharecount_fb');
