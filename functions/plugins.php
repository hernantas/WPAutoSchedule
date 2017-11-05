<?php 
    namespace AutoSchedule;

    class Plugins {
        private $draft_status = ['pending', 'draft', 'auto-draft'];
        private $publish_status = ['publish', 'future', 'private'];

        public function __construct() {
            add_action( 'admin_notices', array( $this, 'script_init' ) );

            $page = new SettingPage();
        }

        public function is_in_editor() {
            global $pagenow;
            if($new_edit == "edit")
                return in_array( $pagenow, array( 'post.php',  ) );
            elseif($new_edit == "new") //check for new post page
                return in_array( $pagenow, array( 'post-new.php' ) );
            else //check for either new or edit
                return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
        }

        public function is_post_drafted( $id ) {
            return in_array( get_post_status( $id ), $this->draft_status );
        }

        public function is_post_published( $id ) {
            return in_array( get_post_status( $id ), $this->publish_status );
        }

        public function get_all_scheduled_post() {
            $today = getdate();
            $query = array(
                'post_status' => $this->publish_status,
                'date_query' => array(
                    array(
                        'year'  => $today['year'],
                        'month' => $today['mon'],
                        'day'   => $today['mday']
                    ),
                    'compare' => '>='
                ),
            );
    
            $counter = [];
            $loop = new \WP_Query( $query );
    
            foreach ( $loop->get_posts() as $post ) {
                $time = strtotime( $post->post_date );
                $date = date( 'd-m-Y', $time );
                $day = strtolower( date( 'l', $time ) );
                if ( !isset( $counter[ $date ] ) ) {
                    $counter[ $date ] = [ 0, $day ];
                }
                $counter[ $date ][0]++;
            }

            return $counter;
        }

        public function script_init() {
            global $post;

            if ( $this->is_in_editor() ) {
                wp_enqueue_script( 'autoschedule', PLUGIN_URL . 'js/autoschedule.js' );
                wp_localize_script( 'autoschedule', 'autoschedule', [
                    'scheduledCounter' => $this->get_all_scheduled_post(),
                    'options' => get_option( 'auto_schedule_options' )
                ] );
            }
        }        
    }
?>