<?php

function new_node( &$nodes, $addr, $port )
{
	$tcp = "{$addr}:{$port}";
	$sock = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
	if ( @socket_connect($sock, $addr, $port) )
	{
		echo "CONNECT $tcp\n";
		$nodes[ $tcp ] = $sock;
	}
	else
		echo "FAILED $tcp\n";
}

function broadcast( $nodes, $msg )
{
	echo "BROADCAST {$msg}\n";
	foreach($nodes as $nd)
		socket_send( $nd, $msg, strlen($msg), MSG_EOF );
	return true;
}
