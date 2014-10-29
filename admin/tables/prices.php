<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TablePrices extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_apartment_price_id 			= null;

	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_apartment_prices', 'ddcbookit_apartment_price_id', $db);
  	}
}