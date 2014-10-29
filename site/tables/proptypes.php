<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableProptypes extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $type_id 			= null;
	var $type_title 		= null;
	var $type_description 	= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_proptypes', 'ddcbookit_proptype_id', $db);
  	}
}