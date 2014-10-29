<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableBookings extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_bookings_id 			= null;
	var $apartment_name 		= null;
	var $location			 	= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_bookings', 'ddcbookit_bookings_id', $db);
  	}
}