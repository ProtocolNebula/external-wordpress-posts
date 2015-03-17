<?php
require_once "wpapi-class-content.php";
class WpapiShortcodes
{
    private $default = array(
            'm' => '',
            'p' => '',
            'posts' => '',
            'w' => '',
            'cat' => '',
            'withcomments' => '',
            'withoutcomments' => '',
            's' => '',
            'search' => '',
            'exact' => '',
            'sentence' => '',
            'calendar' => '',
            'page' => '',
            'paged' => '',
            'more' => '',
            'tb' => '',
            'pb' => '',
            'author' => '',
            'order' => 'DESC',
            'orderby' => 'date',
            'year' => '',
            'monthnum' => '',
            'day' => '',
            'hour' => '',
            'minute' => '',
            'second' => '',
            'name' => '',
            'category_name' => '',
            'tag' => '',
            'feed' => '',
            'author_name' => '',
            'static' => '',
            'pagename' => '',
            'page_id' => '',
            'error' => '',
            'comments_popup' => '',
            'attachment' => '',
            'attachment_id' => '',
            'subpost' => '',
            'subpost_id' => '',
            'preview' => '',
            'robots' => '',
            'taxonomy' => '',
            'term' => '',
            'cpage' => '',
            'post_type' => '',
            'posts_per_page' => 10
        );

    function set_query($attr){
        extract(shortcode_atts($this->default, $attr));
        $q = "filter[orderby]={$orderby}";
        if($m){ $q .= "&filter[m]={$m}";}
        if($p){ $q .= "&filter[p]={$p}";}
        if($posts){ $q .= "&filter[posts]={$posts}";}
        if($w){ $q .= "&filter[w]={$w}";}
        if($cat){ $q .= "&filter[cat]={$cat}";}
        if($withcomments){ $q .= "&filter[withcomments]={$withcomments}";}
        if($withoutcomments){ $q .= "&filter[withoutcomments]={$withoutcomments}";}
        if($s){ $q .= "&filter[s]={$s}";}
        if($search){ $q .= "&filter[search]={$search}";}
        if($exact){ $q .= "&filter[exact]={$exact}";}
        if($sentence){ $q .= "&filter[sentence]={$sentence}";}
        if($calendar){ $q .= "&filter[calendar]={$calendar}";}
        if($page){ $q .= "&filter[page]={$page}";}
        if($paged){ $q .= "&filter[paged]={$paged}";}
        if($more){ $q .= "&filter[more]={$more}";}
        if($tb){ $q .= "&filter[tb]={$tb}";}
        if($pb){ $q .= "&filter[pb]={$pb}";}
        if($author){$q .= "&filter[author]={$author}";}
        if($order){$q .= "&filter[order]={$order}";}
        if($year){ $q .= "&filter[year]={$year}";}
        if($monthnum){ $q .= "&filter[monthnum]={$monthnum}";}
        if($day){ $q .= "&filter[day]={$day}";}
        if($hour){ $q .= "&filter[hour]={$hour}";}
        if($minute){ $q .= "&filter[minute]={$minute}";}
        if($second){ $q .= "&filter[second]={$second}";}
        if($name){ $q .= "&filter[name]={$name}";}
        if($category_name){ $q .= "&filter[category_name]={$category_name}";}
        if($tag){ $q .= "&filter[tag]={$tag}";}
        if($feed){ $q .= "&filter[feed]={$feed}";}
        if($author_name){ $q .= "&filter[author_name]={$author_name}";}
        if($static){ $q .= "&filter[static]={$static}";}
        if($pagename){ $q .= "&filter[pagename]={$pagename}";}
        if($page_id){ $q .= "&filter[page_id]={$page_id}";}
        if($error){ $q .= "&filter[error]={$error}";}
        if($comments_popup){ $q .= "&filter[comments_popup]={$comments_popup}";}
        if($attachment){ $q .= "&filter[attachment]={$attachment}";}
        if($attachment_id){ $q .= "&filter[attachment_id]={$attachment_id}";}
        if($subpost){ $q .= "&filter[subpost]={$subpost}";}
        if($subpost_id){ $q .= "&filter[subpost_id]={$subpost_id}";}
        if($preview){ $q .= "&filter[preview]={$preview}";}
        if($robots){ $q .= "&filter[robots]={$robots}";}
        if($taxonomy){ $q .= "&filter[taxonomy]={$taxonomy}";}
        if($term){ $q .= "&filter[term]={$term}";}
        if($cpage){ $q .= "&filter[cpage]={$cpage}";}
        if($post_type){ $q .= "&filter[post_type]={$post_type}";}
        if($posts_per_page){$q .= "&filter[posts_per_page]={$posts_per_page}";}
        return $q;
    }

    function get_api($attr){
        $q = $this->set_query($attr);
        extract(shortcode_atts(array(
            'url' => get_home_url(),
            'type' => 'posts',
            'size' => 'medium',
        ), $attr));
        $url = "{$url}/wp-json/{$type}?{$q}";
        $wp_api_posts = wp_remote_get($url);
        $html = "<ul class='wpapi wpapi-shortcode'>";

        $WpapiContent = new WpapiContents();
        if($wp_api_posts['response']['code'] != 200){
            return $html . $WpapiContent->get_badresponse($wp_api_posts);
        }
        $wp_api_posts = json_decode($wp_api_posts['body']);
        switch ($type) {
            case 'posts':
                $html .= $WpapiContent->get_posts($wp_api_posts);
                break;
            case 'pages':
                $html .= $WpapiContent->get_pages($wp_api_posts);
                break;
            case 'media':
                $html .= $WpapiContent->get_media($wp_api_posts, $size);
                break;
        }
        $html .= "</ul>";
        return $html;
    }
}