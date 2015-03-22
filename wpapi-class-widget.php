<?php
require_once "wpapi-class-content.php";
class WpapiWidget extends WP_Widget
{
    /**
     * Register Widget
     */
    function __construct() {
        parent::__construct(
            'wp_api',
            'WP-API',
            array( 'description' => "Get WP-API's data", )
        );
    }

    /**
     * @param array $args    
     * @param array $instance
     */
    public function widget( $args, $instance ) {

        $url = $instance['wpapi'];
        $html = "<ul class='wpapi wpapi-widget'>";
        $wp_api_posts = wp_remote_get($url);
        $WpapiContent = new WpapiContents();
        if($wp_api_posts['response']['code'] != 200){
            return $html . $WpapiContent->get_badresponse($wp_api_posts);
        }
        $wp_api_posts = json_decode($wp_api_posts['body']);
        $html .= $WpapiContent->get_posts($wp_api_posts);
        $html .= "</ul>";

        $wpapi = $instance['wpapi'];
        echo $args['before_widget'];
        echo $html;
        echo $args['after_widget'];
    }
 
    /** 
     * @param array $instance
     * @return string|void
     */
    public function form( $instance ){
        $wpapi = '';
        if (isset($instance['wpapi'])) {
            $wpapi = $instance['wpapi'];
        }
        $wpapi_name = $this->get_field_name('wpapi');
        $wpapi_id = $this->get_field_id('wpapi');
        ?>
        <p>
            <label for="<?php echo $wpapi_id; ?>">SiteURL(only RootURL,widthout /wp-json/):</label>
            <input class="widefat" id="<?php echo $wpapi_id; ?>" name="<?php echo $wpapi_name; ?>" type="text" value="<?php echo esc_attr( $wpapi ); ?>">
        </p>
        <p>
            <label for="<?php echo $wpapi_query_id; ?>">Search Query:</label>
            <input class="widefat" id="<?php echo $wpapi_query_id; ?>" name="<?php echo $wpapi_query_name; ?>" type="text" value="<?php echo esc_attr( $wpapi_query ); ?>">
        </p>
        <p>
            <label for="<?php echo $wpapi_num_id; ?>">Search Query:</label>
            <input class="widefat" id="<?php echo $wpapi_num_id; ?>" name="<?php echo $wpapi_num_name; ?>" type="text" value="<?php echo esc_attr( $wpapi_num ); ?>">
        </p>
        <?php
    }
 
    /** 
     * @param array $new_instance 
     * @param array $old_instance
     * @return array             
     */
    function update($new_instance, $old_instance) {
        if(!filter_var($new_instance['wpapi'],FILTER_VALIDATE_URL)){
            return false;
        }
        return $new_instance;
    }

}