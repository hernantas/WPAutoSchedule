<?php 
    namespace AutoSchedule;
    
    class SettingPage {
        private $options = [];

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        private function get_days() {
            return ['Sunday', 'Monday' , 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        }

        public function add_plugin_page() {
            add_options_page(
                'Auto Schedule',   // Page Admin Menu
                'Auto Schedule',    // Menu Title
                'manage_options', // Capabilities
                'auto-schedule', // Page
                array( $this, 'create_admin_page' )
            );
        }

        public function create_admin_page() {
            $this->options = get_option( 'auto_schedule_options' );
            include ( PLUGIN_PATH . 'views/admin_page.php' );
        }

        public function page_init() {
            register_setting(
                'auto_schedule_group', // Option group
                'auto_schedule_options', // Option name
                array( $this, 'sanitize' ) // Sanitize
            );
    
            add_settings_section(
                'auto_schedule_section_schedule', // ID
                'Schedule', // Title
                array( $this, 'print_schedule_info' ), // Callback
                'auto-schedule' // Page
            );

            foreach ( $this->get_days() as $day ) {
                $day = strtolower($day);
                add_settings_field(
                    'day_'.$day, // ID
                    ucwords($day), // Title 
                    array( $this, 'day_callback' ), // Callback
                    'auto-schedule', // Page
                    'auto_schedule_section_schedule', // Section   
                    $day      
                );
            }

            add_settings_field(
                'only_schedule', // ID
                'Only Schedule', // Title 
                array( $this, 'only_schedule' ), // Callback
                'auto-schedule', // Page
                'auto_schedule_section_schedule', // Section   
                $day      
            );
        }

        /**
         * Sanitize each setting field as needed
         *
         * @param array $input Contains all settings fields as array keys
         */
        public function sanitize( $input ) {
            $ninput = array();
            foreach( $this->get_days() as $day ) {
                $day = strtolower( $day );
                $ninput[ 'day_'.$day ] = absint( $input[ 'day_'.$day ] );
                $ninput[ 'time_from_'.$day ] = $this->sanitize_clock( $input[ 'time_from_'.$day ] );
                $ninput[ 'time_to_'.$day ] = $this->sanitize_clock( $input[ 'time_to_'.$day ] );
            }
            $ninput[ 'only_schedule' ] = ( $input[ 'only_schedule' ] == 'true' ? 'true' : 'false' );
            return $ninput;
        }

        private function sanitize_clock( $clock ) {
            $h = $this->math_clamp( (int)substr( $clock, 0, 2 ), 0, 23 );
            $m = $this->math_clamp( (int)substr( $clock, 2, 2 ), 0, 59 );
            return sprintf( '%1$02d%02$02d', $h, $m );
        }

        private function math_clamp( $number, $min, $max ) {
            return min( max( $number, $min ), $max );
        }

        /** 
         * Print the Section text
         */
        public function print_schedule_info() {
            print 'Specify maximum scheduled post each day: (Set to 0 for None)';
        }

        public function time_callback( $optName, $day ) {
            $opts = '';
            for ($h = 0; $h < 24; $h++) {
                for ($m = 0; $m < 60; $m+= 30) {
                    $selected = false;
                    $name = sprintf('%1$02d%02$02d', $h, $m);
                    $display = sprintf('%1$02d:%02$02d', $h, $m);
                    if ( isset ($this->options[ $optName.$day ]) ) {
                        if ( $this->options[ $optName.$day ] == $name ) {
                            $selected = true;
                        }
                    } else if (($optName == 'time_from_' && $h == 8 && $m == 0) || 
                        ($optName == 'time_to_' && $h == 16 && $m == 0)) {
                        $selected = true;            
                    }

                    $opts .= sprintf('<option value="%1$s" %3$s>%2$s</option>', 
                        $name, 
                        $display,
                        $selected ? 'selected="selected"' : ''
                    );
                }
            }
            printf('<select name="auto_schedule_options[%3$s%1$s]">%2$s</select>', $day,$opts, $optName);
        }

        public function day_callback( $day ) {
            printf('<label for="day_%1$s">Max: </label>', $day);
            printf(
                '<input type="number" id="day_%1$s" name="auto_schedule_options[day_%1$s]" class="small-text" value="%2$s" />',
                $day,
                ( isset( $this->options[ 'day_' . $day ] ) ? $this->options[ 'day_' . $day ] : ( ( $day[0] == 's' ) ? 0 : 1 ) )
            );
            printf(' <label for="time_from_%1$s">From: </label>', $day);
            $this->time_callback( 'time_from_', $day );

            printf(' <label for="time_to_%1$s">To: </label>', $day);
            $this->time_callback( 'time_to_', $day );
        }

        public function only_schedule() {
            $schedule_only = false;
            if ( !isset( $this->options['only_schedule'] ) || $this->options['only_schedule'] == 'true' ) {
                $schedule_only = true;
            }

            printf('<label><input type="radio" name="auto_schedule_options[only_schedule]" %1$s value="true" />Only Schedule</label>',
                ($schedule_only == true ? 'checked="checked"' : ''));
            printf(' <label><input type="radio" name="auto_schedule_options[only_schedule]" %1$s value="false" />With Publish</label>',
                ($schedule_only == false ? 'checked="checked"' : ''));
            printf('<div><textarea>%1$s</textarea></div>', $this->arr_to_str($this->options));
        }

        private function arr_to_str( $array ) {
            $ret = '';
            if ( is_array($array) === true ) {
                $ret .= '{';
                foreach ( $array as $key => $val ) {
                    $ret .= sprintf('%1$s=>%2$s ', $key, $this->arr_to_str( $val ) );
                }
                $ret .= '}';
            } else {
                $ret = $array;
            }
            return $ret;
        }
    }
?>