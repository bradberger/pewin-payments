<?php

wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pewin-payments-admin.css', array(), $this->version, 'all' );
wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pewin-payments-admin.js', array( 'jquery' ), $this->version, false );
