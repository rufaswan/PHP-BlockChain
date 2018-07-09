<?php

class Block {

	private $m_index    = "";
	private $m_nonce    = "";
	private $m_data     = "";
	private $m_hash     = "";
	private $m_time     = "";
	public  $m_prevhash = "";

	private function hash()
	{
		$str = $this->m_index . $this->m_time . $this->m_data . $this->m_nonce . $this->m_prevhash;
		return hash( "sha256", $str, false );
	}

	public function mine_block( $difficult )
	{
		while (1)
		{
			$this->m_nonce++;
			$this->m_hash = $this->hash();

			$zeros = substr( $this->m_hash, 0, $difficult );
			if ( empty($zeros) )
			{
				echo "BLOCK [{$this->m_index}] : {$this->m_data}\n";
				echo "-> PREV : {$this->m_prevhash}\n";
				echo "-> HASH : {$this->m_hash}\n";
				return;
			}

		} // while 1
	}

	public function gethash()
	{
		return $this->m_hash;
	}

	public function __construct( $index, $data )
	{
		$this->m_index = $index;
		$this->m_data  = $data;
		$this->m_nonce = -1;
		$this->m_time  = time();
	}

} // Block
