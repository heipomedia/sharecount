<?php
/**
 * Twitter Shares
 */
function sharecount_tw()
{
    // Check if nonce is correct (no abuse)
	if ( ! check_ajax_referer('tw_sharecount_nonce', 'sc_tw_nonce' ) )
		die ( 'Nope');

    // Get post id from ajax
    $post_id = $_REQUEST['post_id'];

    // Check if we just make a request to check how many shares we have
    if(get_transient('sharecount_twitter-'.$post_id) === false) :

        // Check if protocol is secure, otherwise the API call throw an ssl handshake error
        $ssl = is_ssl() ? 'https://' : 'http://';

        // Make the api call from OpenShareCount to get the shares
        $api_call = wp_remote_get(
            $ssl.'opensharecount.com/count.json?url='.get_permalink($post_id),
            array('timeout' => 5)
        );

        // Get the status code from the API call
        $status_code = wp_remote_retrieve_response_code($api_call);

        // If API call was successful, proceed
        if($status_code == 200) :

            // Decode to JSON and get shares
            $api = json_decode(wp_remote_retrieve_body($api_call));
            $shares = $api->count;

            // Save to postmeta table
            update_post_meta($post_id, 'sharecount_twitter', $shares);

            // Set transient
            set_transient('sharecount_twitter-'.$post_id, $shares, 3 * HOUR_IN_SECONDS );

        else :

            // If OpenShareCount API is down, then store nothing and get the shares from our postmeta entry
            $shares = get_post_meta($post_id, 'sharecount_twitter', true);
            $shares = empty($shares) ? 0 : $shares;

            // Set transient and try again to contact OpenShareCount API in 3 hours
            set_transient('sharecount_twitter-'.$post_id, $shares, 3 * HOUR_IN_SECONDS );

        endif;

    else :

        // When we checked, get the shares from our postmeta entry
        $shares = get_post_meta($post_id, 'sharecount_twitter', true);
        $shares = empty($shares) ? 0 : $shares;

    endif;

    // Return the shares to our ajax response
    echo $shares;

    exit;
}
add_action('wp_ajax_nopriv_sharecount_tw', 'sharecount_tw');
add_action('wp_ajax_sharecount_tw', 'sharecount_tw');
