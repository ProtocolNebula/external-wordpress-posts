<?php
/*
 * Original plugin: https://es.wordpress.org/plugins/wpapi-shortcode-and-widgets/
 */
class WpapiContents
{
	private $attr;
	
	function __construct($attrs = array()) {
		$this->attr = $attrs;
	}
	
    function get_badresponse($wp_api_posts){
        $html = "<dt>faild get WP-API</dt>";
        $html .= "<dd>Response Code:{$wp_api_posts['response']['code']}<br/>";
        $html .= "{$wp_api_posts['response']['message']}</dd></dl>";
        return $html;
    }

    function get_posts($wp_api_posts){
        $html = '';
		
		$max = (isset($this->attr['posts_per_page'])) ? $this->attr['posts_per_page'] : 0;
		
		$c = 0;
        foreach ($wp_api_posts as $k => $v){
            $id = $v['id'];
            $title = $v['title']['rendered'];
            $link  = $v['link'];
            $excerpt = $v['excerpt']['rendered'];
            $category = $v['_embedded']['wp:term'][0][0];
			
            $date = $v['date'];
            $dateRedeable = __(get_date_from_gmt( $v['date'] , 'd/m/y' ));
            $html .= "<div class='news-mini-wrap col-lg-6 col-md-6'>";

            //print_r($v);
            $media = isset($v['_embedded']['wp:featuredmedia']) ? $v['_embedded']['wp:featuredmedia'] : false;
            
                if( isset( $media ) && $media ) {
                    $img_title = $media[0]['title']['rendered'];
                    $img_path   = $media[0]['media_details']['sizes']['medium']['source_url'];
					if (!$img_path) $img_path = $media[0]['source_url'];

                    $html .= '<figure class="news-featured-image"><a href="'.$link.'" title="'.$img_title.'}" target="_blank">'
                            . "<img src='{$img_path}' class='attachment-full size-full wp-post-image' alt='{$img_title}' sizes='(max-width: 1200px) 100vw, 1200px' width='1200' height='1600'></a></figure>";
                }

                $html .= "<h1 class='page-title'>"
                    . "<a href='{$link}' title='{$title}' target='_blank'>{$title}</a>"
                . "</h1>"
                . "<div class='news-meta'>"
                    . "<span class='news-meta-date'>"
                        . "<a href='{$link}' title='Permalink to {$title}' rel='bookmark'>"
                            . "<time datetime='{$date}'>{$dateRedeable}</time>"
                        . "</a>"
                    . "</span>" 
                    . "<span class='news-meta-date'>"
                        . '<a rel="category" class="cat-walk" href="'.$category['link'].'" target="_blank">'.$category['name'].'</a>'
                    . "</span>"
                    . "<div class='news-summary'>{$excerpt}</div>"
                . "</div>"
            . "</div>";
			
			// Avoid errors if reply return more than "posts_per_page"
			if ($max > 0 and $max <= ++$c) break;
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
