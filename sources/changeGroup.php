<?php

class changeGroup {
	protected $registry;
	protected $DB;
	protected $settings;
	protected $request;
	protected $lang;
	protected $member;
	protected $cache;
	
	public function __construct( ipsRegistry $registry )
	{		
		$this->registry = $registry;
		$this->DB	    = $this->registry->DB();
		$this->settings =& $this->registry->fetchSettings();
		$this->request  =& $this->registry->fetchRequest();
		$this->cache	= $this->registry->cache();
		$this->caches   =& $this->registry->cache()->fetchCaches();
		$this->lang		=  $this->registry->getClass('class_localization');
	}
	
	public function change_group( $member )
	{  
		$vips = ipsRegistry::DB()->buildAndFetch( array( 'select' => '*',
		'from' => 'vips') );
		
		$isVip = false;
		
		foreach($vips as $vip) {
			if($vip = $member['members_display_name']) {
				$isVip = true;
			}
		}
		
		if($isVip) {
			$this->DB->update('members', array( 'member_group_id' => $this->settings['pxvip_GrupoVip']), 'member_id='.$member['member_id']);
		}
	}
}