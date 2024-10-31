<?php
/**
Plugin Name: Radio2 RT
Plugin URI: http://blog.andrewshell.org/radio2rt
Description: Redirect RT requests to Press This URL
Author: Andrew Shell
Author URI: http://blog.andrewshell.org/
Version: 1.1.0
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

add_action( 'init', 'radio2rt_init' );
add_action( 'wp_loaded', 'radio2rt_wp_loaded' );

function radio2rt_get_param($k)
{
    return (empty($_GET[$k]) ? '' : urlencode(html_entity_decode(stripslashes($_GET[$k]), null, 'UTF-8')));
}

function radio2rt_init() {
    if (!is_admin()) {
        wp_enqueue_script( 'the_js', plugins_url( '/rt.js', __FILE__ ) );
    }
}

function radio2rt_wp_loaded($arg)
{
    // http://scripting.com/stories/2012/02/03/aStandardForRting.html
    if (isset($_GET['link']) || isset($_GET['title']) || isset($_GET['description'])) {
        $params = array(
            'u' => radio2rt_get_param('link'),
            't' => radio2rt_get_param('title'),
            's' => radio2rt_get_param('description'),
            'v' => 4,
        );
        $first = true;
        if (class_exists('Press_This_Reloaded')) {
            $url = admin_url( 'post-new.php' ); // . '?' . http_build_query($params);
        } else {
            $url = admin_url( 'press-this.php' ); // . '?' . http_build_query($params);
        }
        $first = true;
        foreach ($params as $k => $v) {
            if ($first) {
                $url .= '?';
                $first = false;
            } else {
                $url .= '&';
            }
            $url .= $k . '=' . $v;
        }
        header('Location:' . $url );
        exit;
    }
}

function radio2rt_get_rt_link($id = 0)
{
    global $wp_filter, $merged_filters;

    // Temporarily remove all 'excerpt_more' filters
    if (isset($wp_filter['excerpt_more'])) {
        $tmp_wp_filter_excerpt_more = $wp_filter['excerpt_more'];
        unset($wp_filter['excerpt_more']);
    }
    if (isset($merged_filters['excerpt_more'])) {
        $tmp_merged_filters_excerpt_more = $merged_filters['excerpt_more'];
        unset($merged_filters['excerpt_more']);
    }

    $post = &get_post($id);

    if ( empty($post->ID) ) {
        return false;
    }

    $excerpt = $post->post_excerpt;
    if ( post_password_required($post) ) {
        $excerpt = __('There is no excerpt because this is a protected post.');
    }
    $excerpt = esc_attr( strip_tags( wp_trim_excerpt( $excerpt ) ) );

    $permalink = get_permalink( $post->ID );

    $title = get_the_title( $post->ID );

    $rt_link = "<a href=\"javascript:void(0)\" onclick=\"sendToLinkblog('{$excerpt}', '{$permalink}', '{$title}')\" title=\"Send to linkblog.\">RT</a>";

    // Reinstate all 'excerpt_more' filters
    if (isset($tmp_wp_filter_excerpt_more)) {
        $wp_filter['excerpt_more'] = $tmp_wp_filter_excerpt_more;
    }
    if (isset($tmp_merged_filters_excerpt_more)) {
        $merged_filters['excerpt_more'] = $tmp_merged_filters_excerpt_more;
    }

    return $rt_link;
}

function radio2rt_rt_link()
{
    echo apply_filters('radio2rt_rt_link', radio2rt_get_rt_link());
}