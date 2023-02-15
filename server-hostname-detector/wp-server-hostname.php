<?php
/*
Plugin Name: Server Hostname Detector
Description: This plugin is designed that if you was using WordPres on more then one server that by just viewing the source code you will be able to see which server the page was loaded from.
Version: 1.1
Author: Snat
Author URI: https://snat.co.uk/
?>
<?php
/*  Copyright 2010  Matthew Ellis  (email : matthew@ellisfamily.tk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function snat_display_server_hostname() {
    echo "<!--" . gethostname() . "-->";
    
  }
  
  add_action('wp_footer', 'snat_display_server_hostname');

?>