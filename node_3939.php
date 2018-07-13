<?php
require("inc_nodefunc.php");

$host = "127.0.0.1";
$port = 3939;

$nodes = array();
new_node( $nodes, "127.0.0.1", 3939 );
new_node( $nodes, "127.0.0.1", 5454 );
new_node( $nodes, "127.0.0.1", 8282 );

require("inc_nodebase.php");
