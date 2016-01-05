<?php
class WpapiContents
{
    function get_badresponse($wp_api_posts){
        $html = "<dt>faild get WP-API</dt>";
        $html .= "<dd>Response Code:{$wp_api_posts['response']['code']}<br/>";
        $html .= "{$wp_api_posts['response']['message']}</dd></dl>";
        return $html;
    }

    function get_posts($wp_api_posts){
        $html = '';
        foreach ($wp_api_posts as $k => $v){
            $id = $v['id'];
            $title = $v['title']['rendered'];
            $link  = $v['link'];
            $excerpt = $v['excerpt']['rendered'];
            $html .= "<li><a href='{$link}'>";
			if( isset( $v['_embedded']['https://api.w.org/featuredmedia'] ) && $v['_embedded']['https://api.w.org/featuredmedia'] ) {
				$img_title = $v['_embedded']['https://api.w.org/featuredmedia'][0]['title']['rendered'];
				$img_path   =$v['_embedded']['https://api.w.org/featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url'];
	            $html .= "<img src='{$img_path}' alt='{$img_title}'>";
			}
            $html .="<h2 class='wpapi-title'>{$title}</h2></a>{$excerpt}</li>";
        }
        return $html;
    }

    function get_pages($wp_api_posts){
        $html = '';
        foreach ($wp_api_posts as $k => $v){
            $id = $v['id'];
            $title = $v['title']['rendered'];
            $link  = $v['link'];
            $excerpt = $v['excerpt']['rendered'];
            $html .= "<li><a href='{$link}'>";
            $html .="<h2 class='wpapi-title'>{$title}</h2>{$excerpt}</a></li>";
        }
        return $html;
    }

    function get_media($wp_api_posts, $size){
        $html = '';
        foreach ($wp_api_posts as $k => $v){
			if ( ! isset( $v['media_details']['sizes'] ) || ! $v['media_details']['sizes'] ) {
				continue;
			}
            $id = $v['id'];
            $title = $v['title']['rendered'];
			$img = $v['media_details']['sizes'];
			$link = $v['link'];
			$alt = $v['alt_text'];
			if ( isset( $img[ $size ] ) && $img[ $size ] ) {
				$imgsrc = $img[ $size ]['source_url'];
			} else {
				$imgsrc = $img['full']['source_url'];
			}
            $html .= "<li><a href='{$link}'><img src='{$imgsrc}' alt='{$alt}'><h2 class='wpapi-title'>{$title}</h2></a></li>";
        }
        return $html;
    }
}
