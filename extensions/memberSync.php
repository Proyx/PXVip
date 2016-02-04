<?php

class PXVipMemberSync {
	public $registry;
	
	public function __construct()
	{
		$this->registry = ipsRegistry::instance();
        $this->settings = $this->registry->settings();	
	}
	
	public function onCompleteAccount( $member )
	{                    
		require_once( IPSLib::getAppDir( 'PXVip' ) . '/sources/changeGroup.php' );
		$this->registry->setClass( 'changeGroup', new changeGroup( $this->registry ) );
		$this->registry->changeGroup->change_group( $member );
	}
    
	public function onCreateAccount( $member )
	{	   
        if( IN_ACP )
        {   
            require_once( IPSLib::getAppDir( 'PXVip' ) . '/sources/changeGroup.php' );
			$this->registry->setClass( 'changeGroup', new changeGroup( $this->registry ) );
			$this->registry->changeGroup->change_group( $member );
        }
	}
}