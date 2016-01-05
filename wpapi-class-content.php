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
		$wp_api_posts = json_decode( json_encode( $wp_api_posts ),true );
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
            $id = $v->ID;
            $title = $v->title;
            $link  = $v->link;
            $excerpt = $v->excerpt;
            $html .= "<li><a href='{$link}'>";
            $html .="<h2 class='wpapi-title'>{$title}</h2>{$excerpt}</a></li>";
        }
        return $html;
    }

    function get_media($wp_api_posts, $size){
        $html = '';
        foreach ($wp_api_posts as $k => $v){
            $id = $v->ID;
            $title = $v->title;
            $imgsrc = $v->attachment_meta->sizes->$size->url;
            $html .= "<li><a href='{$imgsrc}'><img src='{$imgsrc}'><h2 class='wpapi-title'>{$title}</h2></a></li>";
        }
        return $html;
    }
}
