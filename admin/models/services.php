<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsServices extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    	= null;
  var $_residence_id		= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_service_id = $app->input->get('service_id', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('service.*');
    $query->select('service.service_name');
    $query->from('#__ddcbookit_services as service');
    $query->group('service.service_name');
    $query->order('service.service_name ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_service_id!=null)
  	{
  		$query->where('service.ddcbookit_services_id = "'.$this->_service_id.'"');
  	}
   return $query;
  }

}