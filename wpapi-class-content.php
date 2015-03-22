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
            $id = $v->ID;
            $title = $v->title;
            $link  = $v->link;
            $thumbnail = $v->featured_image->guid;
            $excerpt = $v->excerpt;
            $html .= "<li><a href='{$link}'>";
            if($thumbnail){$html .= "<img src='{$thumbnail}'>";}
            $html .="<h2 class='wpapi-title'>{$title}</h2>{$excerpt}</a></li>";
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