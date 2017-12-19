<?php
/**
 * Display share buttons
 */
function sharecount_display()
{
    $sharing_buttons = '';

    // Get shares from Mail
    $shares_mail = get_post_meta(get_the_ID(), 'sharecount_mail', true);
    $shares_mail = empty($shares_mail) ? 0 : $shares_mail;

    // Show buttons only if we are on a single page
    if (is_single()) {

        // Define theme for sharing buttons
        $sharing_buttons = '
        <div class="sharing-buttons-post-id" data-postid="'.get_the_ID().'"></div>
        <div class="sharing-buttons">
            <a href="https://www.facebook.com/sharer.php?u='.get_permalink().'" target="_blank" class="sharing-button sharing-button--facebook">
				<i class="icon-facebook" aria-hidden="true"></i>
                <span class="sharing-button__text">SHARE</span>
                <span class="sharing-button__count sharecount_fb">0</span>
            </a>
            <a href="https://twitter.com/intent/tweet?url='.get_permalink().'" target="_blank" class="sharing-button sharing-button--twitter">
				<i class="icon-twitter" aria-hidden="true"></i>
                <span class="sharing-button__text">TWEET</span>
                <span class="sharing-button__count sharecount_tw">0</span>
            </a>
            <a href="mailto:?subject=Artikel-Empfehlung&body=Hallo%2C%0A%0Adieser%20Artikel%20könnte%20dir%20gefallen%3A%20'.get_permalink().'%0A%0Alg" class="sharing-button sharing-button--mail">
				<i class="icon-mail" aria-hidden="true"></i>
                <span class="sharing-button__text">MAIL</span>
                <span class="sharing-button__count sharecount_mail">'.$shares_mail.'</span>
            </a>
        </div>
        ';

    }

    return $sharing_buttons;
}
