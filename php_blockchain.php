<?php
require("inc_blockchain.php");

$bc = new BlockChain();

$bc->add_block( new Block(1, "Block 1 Data") );
$bc->add_block( new Block(2, "Block 2 Data") );
$bc->add_block( new Block(3, "Block 3 Data") );

// print_r( $bc );
