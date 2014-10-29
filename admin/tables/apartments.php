<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableApartments extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_apartments_id 			= null;
	var $apartment_name 		= null;
	var $location			 	= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_apartments', 'ddcbookit_apartments_id', $db);
  	}
}