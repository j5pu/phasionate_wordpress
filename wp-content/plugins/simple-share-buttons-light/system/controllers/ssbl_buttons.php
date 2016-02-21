<?php
defined('ABSPATH') or die('No direct access permitted');

    // get and show share buttons
    function ssbl_show_share_buttons($content, $booShortCode = false, $atts = '')
    {
        // globals
        global $post;

        // get ssbl settings
        $ssbl_settings = get_ssbl_settings();

        // variables
        $buttons = '';

        // placement on pages/posts/categories/archives/homepage
        if ((! is_home() && ! is_front_page() && is_page() && $ssbl_settings['pages'] == 'Y') || (is_single() && $ssbl_settings['posts'] == 'Y') || $booShortCode == true) {
            // ssbl comment
            $buttons.= '<!-- Simple Share Buttons Light (v'.SSBL_VERSION.') simplesharebuttons.com/light -->';

            // if running standard
            if ($booShortCode == false) {
                // get title and url
                $strPageTitle = get_the_title($post->ID);
                $urlCurrentPage = get_permalink($post->ID);
            }
            // using shortcode
            else {
                // if we're not viewing a post
                if (! is_single()) {
                    // if a title has been provided
					if (isset($atts['title']) && $atts['title'] != '') {
						// use the set title
						$strPageTitle = $atts['title'];
					} else {
						// get the page title
						$strPageTitle = wp_title('', false);
					}
                }
                // viewing a single post
                else {
                    // set page title as set by user or get if needed
                    $strPageTitle = (isset($atts['title']) ? $atts['title'] : get_the_title());
                }

                // set the url as set by user or get if needed
                $urlCurrentPage = (isset($atts['url']) ? $atts['url'] : ssbl_current_url());
            }

            // strip any unwanted tags from the page title
            $strPageTitle = esc_attr(strip_tags($strPageTitle));

            // get wrap
            $buttons.= '<div class="ssbl-wrap">';

                // ssbl div
                $buttons.= '<div class="ssbl-container">';

                    // if there is some share text
                    if ($ssbl_settings['share_text'] != '') {
                        // add share text
                        $buttons.= '<span class="ssbl-share-text">'.$ssbl_settings['share_text'].'</span>';
                    }

                    // initiate class and get buttons
                    $ssblButtons = new SSBL_Buttons($ssbl_settings, $strPageTitle, $urlCurrentPage);

                    // add the buttons
                    $buttons.= $ssblButtons->get_buttons();

                // close container div
                $buttons.= '</div>';

            // close wrap div
            $buttons.= '</div>';

            // adding shortcode buttons
            if ($booShortCode == true) {
                return $buttons;
            } else {
                // return buttons after content
                return $content.$buttons;
            }
        } else {
            // no buttons
            return $content;
        }
    }

    // shortcode for adding buttons
    function ssbl_buttons($atts)
    {
        // get buttons - NULL for $content, TRUE for shortcode flag
        return ssbl_show_share_buttons(null, true, $atts);
    }

    // shortcode for hiding buttons
    function ssbl_hide($content)
    {
        // nothing to do here
    }

    // get URL function
    function ssbl_current_url()
    {
        // add http
        $urlCurrentPage = 'http';

        // add s to http if required
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $urlCurrentPage .= 's';
        }

        // add colon and forward slashes
        $urlCurrentPage .= '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // return url
        return htmlspecialchars($urlCurrentPage);
    }

    /**
    * Simple Share Buttons Light
    */
    class SSBL_Buttons {

        // variables
        public $buttons;
        public $images;
        public $title;
        public $url;

    	function __construct($settings, $title, $url)
    	{
        	// prepare class variables
        	$this->settings = $settings;
        	$this->title = $title;
        	$this->url = $url;

        	// include the images needed ready
            $this->images = include_once SSBL_ROOT.'/buttons/'.$settings['image_set'].'.php';
    	}

    	// get all buttons
    	function get_buttons()
    	{
        	// explode saved include list and add to a new array
            $selected = explode(',', $this->settings['selected_buttons']);

            // for each included button
            foreach ($selected as $button) {
                // prepare function name
                $function = 'ssbl_' . $button;

                // add each share button
                $this->buttons .= $this->$function();
            }

            // return the buttons
            return $this->buttons;
    	}

        // get facebook button
        function ssbl_facebook() {

            // facebook share link
            $return = '<a target="_blank" class="ssbl_facebook_share" href="http://www.facebook.com/sharer.php?u='.$this->url.'">';

                // show selected ssbl image
                $return .= '<img src="'.$this->images['facebook'].'" title="Facebook" class="ssbl ssbl-img" alt="Share on Facebook" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get twitter button
        function ssbl_twitter() {

            // format the URL into friendly code
            $twitter_text = urlencode(html_entity_decode($this->title, ENT_COMPAT, 'UTF-8'));

            // twitter share link
            $return = '<a target="_blank" class="ssbl_twitter_share" href="http://twitter.com/share?url='.$this->url.'&amp;text='.$twitter_text.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['twitter'].'" title="Twitter" class="ssbl ssbl-img" alt="Tweet about this on Twitter" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get google+ button
        function ssbl_google() {

            // google share link
            $return = '<a target="_blank" class="ssbl_google_share" href="https://plus.google.com/share?url='.$this->url.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['google'].'" title="Google+" class="ssbl ssbl-img" alt="Share on Google+" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get diggit button
        function ssbl_diggit() {

            // diggit share link
            $return = '<a target="_blank" class="ssbl_diggit_share ssbl_share_link" href="http://www.digg.com/submit?url='.$this->url.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['diggit'].'" title="Digg" class="ssbl ssbl-img" alt="Digg this" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get reddit button
        function ssbl_reddit() {

            // reddit share link
            $return = '<a target="_blank" class="ssbl_reddit_share" href="http://reddit.com/submit?url='.$this->url.'&amp;title='.$this->title.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['reddit'].'" title="Reddit" class="ssbl ssbl-img" alt="Share on Reddit" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get linkedin button
        function ssbl_linkedin() {

            // linkedin share link
            $return = '<a target="_blank" class="ssbl_linkedin_share ssbl_share_link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$this->url.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['linkedin'].'" title="LinkedIn" class="ssbl ssbl-img" alt="Share on LinkedIn" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get pinterest button
        function ssbl_pinterest() {

            // pinterest link
            $return = "<a class='ssbl_pinterest_share' href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'>";

                // show ssbl image
                $return .= '<img src="'.$this->images['pinterest'].'" title="Pinterest" class="ssbl ssbl-img" alt="Pin on Pinterest" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get stumbleupon button
        function ssbl_stumbleupon() {

            // stumbleupon share link
            $return = '<a target="_blank" class="ssbl_stumbleupon_share ssbl_share_link" href="http://www.stumbleupon.com/submit?url='.$this->url.'&amp;title='.$this->title.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['stumbleupon'].'" title="StumbleUpon" class="ssbl ssbl-img" alt="Share on StumbleUpon" />';


            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get email button
        function ssbl_email() {

            // replace ampersands as needed for email link
            $emailTitle = str_replace('&', '%26', $this->title);

            // email share link
            $return = '<a class="ssbl_email_share" href="mailto:?subject='.$emailTitle.'&amp;body='.$this->url.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['email'].'" title="Email" class="ssbl ssbl-img" alt="Email this to someone" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get buffer button
        function ssbl_buffer() {

            // buffer share link
            $return = '<a target="_blank" class="ssbl_buffer_share" href="https://bufferapp.com/add?url='.$this->url . '&amp;text='.$this->title.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['buffer'].'" title="Buffer" class="ssbl ssbl-img" alt="Buffer this page" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get tumblr button
        function ssbl_tumblr() {

            // check if http:// is included
            if (preg_match('[http://]', $this->url)) {

                // remove http:// from URL
                $url = str_replace('http://', '', $this->url);
            } else if (preg_match('[https://]', $this->url)) { // check if https:// is included

                    // remove https:// from URL
                    $url = str_replace('https://', '', $this->url);
                }

            // tumblr share link
            $return = '<a target="_blank" class="ssbl_tumblr_share" href="http://www.tumblr.com/share/link?url='.$url.'&amp;name='.$this->title.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['tumblr'].'" title="tumblr" class="ssbl ssbl-img" alt="Share on Tumblr" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get print button
        function ssbl_print() {

            // linkedin share link
            $return = '<a class="ssbl_print ssbl_share_link" href="#" onclick="window.print()">';

                // show ssbl image
                $return .= '<img src="'.$this->images['print'].'" title="Print" class="ssbl ssbl-img" alt="Print this page" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get vk button
        function ssbl_vk() {

            // vk share link
            $return = '<a target="_blank" class="ssbl_vk_share ssbl_share_link" href="http://vkontakte.ru/share.php?url='.$this->url.'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['vk'].'" title="VK" class="ssbl ssbl-img" alt="Share on VK" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

        // get yummly button
        function ssbl_yummly() {

            // yummly share link
            $return = '<a target="_blank" class="ssbl_yummly_share ssbl_share_link" href="http://www.yummly.com/urb/verify?url='.$this->url.'&title='.urlencode(html_entity_decode($this->title)).'">';

                // show ssbl image
                $return .= '<img src="'.$this->images['yummly'].'" title="Yummly" class="ssbl ssbl-img" alt="Share on Yummly" />';

            // close href
            $return .= '</a>';

            // return share buttons
            return $return;
        }

    }

