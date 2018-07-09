<?php
require("inc_block.php");

class BlockChain {

	private $m_difficult = 0;        // how many leading zero for a valid hash
	private $m_vchain    = array();

	private function get_last_hash()
	{
		$end = count($this->m_vchain) - 1;
		return $this->m_vchain[ $end ]->gethash();
	}

	public function add_block( $block )
	{
		$block->m_prevhash = $this->get_last_hash();
		$block->mine_block( $this->m_difficult );

		$this->m_vchain[] = $block;
	}

	public function __construct()
	{
		$this->m_difficult = 1;

		$block = new Block( 0, "Genesis Block" );
		//$block->mine_block( $this->m_difficult );

		$this->m_vchain[]  = $block;
	}

} // BlockChain
