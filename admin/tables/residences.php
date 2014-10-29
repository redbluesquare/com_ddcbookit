<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableResidences extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_residence_id 			= null;
	var $residence_name 		= null;
	var $location			 	= null;
	
	function __construct( $db )
	{
    	parent::__construct('#__ddcbookit_residences', 'ddcbookit_residence_id', $db);
  	}
}