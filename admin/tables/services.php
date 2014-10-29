<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableServices extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_services_id 	= null;
	var $service_name 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_services', 'ddcbookit_services_id', $db);
  	}
}