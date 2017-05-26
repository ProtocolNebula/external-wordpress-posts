<?php
/*
 * Original plugin: https://es.wordpress.org/plugins/wpapi-shortcode-and-widgets/
 */
require_once "wpapi-class-content.php";
class WpapiShortcodes
{
	private $attr; // Attributes received
	
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
            'order' => '',
            'orderby' => '',
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
            'posts_per_page' => 4
        );

    function set_query($attr){
        extract(shortcode_atts($this->default, $attr));
        //$q = "&filter[orderby]={$orderby}";
        $q = '';
		$this->attr = $attr;
        /*if($m){ $q .= "&filter[m]={$m}";}
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
        if($cpage){ $q .= "&filter[cpage]={$cpage}";}*/
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
        $url = "{$url}/wp-json/wp/v2/{$type}?_embed{$q}";

        $wp_api_posts = $this->getDataFromURL($url);

        $WpapiContent = new WpapiContents($this->attr);
        $html = "<div class='row gutter k-equal-height clear-wrapper-margin'>";
        
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
        $html .= "</div>";
        return $html;
    }

    /**
     * Get data from remote.
     * First try to get locally. It don't use transitions because remote server can be down
     * @param type $url Remote wordpress url
     * @return type
     */
    private function getDataFromURL($url) {
        $option_name = 'ewp-' . $url;

        // ONLY FOR TESTING
        //delete_option($option_name);
        // Load stored cache
        $data = get_option($option_name);
        if ($data) {
            $data = json_decode($data, true);
        }

        // If no cache / is time to renew...
        if (!$data or $data['renew'] <= time()) {
            $wp_api_posts = wp_remote_get($url);

            //$WpapiContent = new WpapiContents();
            if (is_wp_error($wp_api_posts)) {
                // Failed to load URL
                $data['renew'] = time() + 180; // Force 3 minutes
                /* $html = "<dl><dt>faild get WP-API</dt></dl>";
                  return $html . "</ul>"; */
            } elseif ($wp_api_posts['response']['code'] != 200) {
                $data['renew'] = time() + 180; // Force 3 minutes
                //return $html . $WpapiContent->get_badresponse($wp_api_posts);
            } else {
                $data['renew'] = time() + 600; // 10 minutes cache
                $data['posts'] = json_decode(json_encode(json_decode($wp_api_posts['body'])), true);
            }

            // Prepare data to save
            $save = json_encode($data);

            // Delete stored data
            if ($data) {
                delete_option($option_name);
            }
            add_option($option_name, $save, null, false);
        }

        // Return posts saved
        return $data['posts'];
    }

}
