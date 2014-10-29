<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableProptypes extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_proptype_id 			= null;
	var $proptype_title 		= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_proptypes', 'ddcbookit_proptype_id', $db);
  	}
}