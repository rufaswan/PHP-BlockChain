<?php
// to be included by clients
// REQ client $host
// REQ client $port

set_time_limit(0);
$to_sec  = 1;
$to_usec = 0;
$records = array();

$sock = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
	socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $to_sec, 'usec' => $to_usec));
	socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, array('sec' => $to_sec, 'usec' => $to_usec));
	socket_set_nonblock( $sock );
	socket_bind($sock, $host, $port);

socket_listen($sock);
echo "SOCKET LISTEN {$host}:{$port}\n";

$prevbuf = "";
while (1)
{
	foreach ( $nodes as $n => $nd )
	{
		if ( ! $nd )
		{
			echo "DELETE NODE {$n}\n";
			unset( $nodes[ $n ] );
			continue;
		}

		$buf = "";
		while ( socket_recv( $nd, $buf, 1024, MSG_DONTWAIT ) )
		{
			$buf = trim($buf);
			if ( $prevbuf == $buf )
				break;

			echo "BUFFER $n : $buf\n";
			switch ( $buf )
			{
				case "dump":
					print_r( $records );
					break;
				default:
					if ( ! in_array($buf, $records) )
					{
						echo "ADD RECORD $buf\n";
						$records[] = $buf;
					}
					break;
			}

			broadcast( $nodes, $buf );
			$prevbuf = $buf;
			break;
		}
	}

	if ( $newsock = socket_accept($sock) )
	{
		$newaddr = "";
		$newport = 0;
		socket_getpeername( $newsock, $newaddr, $newport );
		$newtcp  = "{$newaddr}:{$newport}";

		if ( ! isset( $nodes[ $newtcp ] ) )
		{
			echo "ADD NODE $newtcp\n";
			$nodes[ $newtcp ] = $newsock;
		}
	}

} // while 1

socket_close($sock);
