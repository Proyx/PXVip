<?php

class task_item
{
	protected $class;

	protected $task = array();

	protected $registry;
	protected $DB;
	protected $lang;

	public function __construct( ipsRegistry $registry, $class, $task )
	{
		$this->registry	= $registry;
		$this->DB		= $registry->DB();
		$this->lang		= $this->registry->getClass('class_localization');

		$this->class	= $class;
		$this->task		= $task;
		$this->settings		=& $this->registry->fetchSettings();
	}

	public function runTask()
	{
		ipsRegistry::DB()->build( array( 'select' => '*',
		'from' => 'members') );
		
		$members_vip = $this->DB->execute();
		
		while( $m = $this->DB->fetch( $members_vip ) ) {
			$vipValido = false;
			
			ipsRegistry::DB()->build( array( 'select' => '*',
				'from' => 'vips') );
		
			$vips = ipsRegistry::DB()->execute();
			
			while( $vip = $this->DB->fetch( $vips ) ) {
				if($vip['nome'] == $m['name']) {
					if($vip[$vip['usando']] > 0) {
						if($m['member_group_id'] != $this->settings['pxvip_GrupoVip']) {
							$this->DB->update('members', array( 'member_group_id' => $this->settings['pxvip_GrupoVip']), 'member_id='.$m['member_id']);
						}
						$vipValido = true;
					}
				} 
			}
			if($vipValido == false && $m['member_group_id'] == $this->settings['pxvip_GrupoVip']) {
				$this->DB->update('members', array( 'member_group_id' => 3), 'member_id='.$m['member_id']);
			}
		}
		$this->class->appendTaskLog( $this->task, $this->lang->words['my_task_log_lang_string'] );
		$this->class->unlockTask( $this->task );
	}
}