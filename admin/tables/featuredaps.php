<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableFeaturedaps extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbookit_featuredapartment_id	= null;
	var $apartment_name 				= null;
	var $location			 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbookit_featuredapartments', 'ddcbookit_featuredapartment_id', $db);
  	}
}