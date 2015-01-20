<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsResidences extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    	= null;
  var $_residence_id		= null;
  var $_query				= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_residence_id = $app->input->get('residence_id', null);
	$this->_query = $app->input->get('query', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('residence.*');
    $query->from('#__ddcbookit_residences as residence');
    $query->select('sum(apartment.num_of_apartments) as num_apartments');
    $query->leftJoin('#__ddcbookit_apartments as apartment on apartment.residence_name = residence.ddcbookit_residence_id');
    $query->group('residence.residence_name');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_residence_id!=null)
  	{
  		$query->where('residence.ddcbookit_residence_id = "'.$this->_residence_id.'"');
  	}
   return $query;
  }
  
   function updatetable()
   {
  	$db = JFactory::getDBO();
  	$db->setQuery( "
						CREATE TABLE IF NOT EXISTS #__ddc_payments (
  							ddc_payment_id int(11) NOT NULL AUTO_INCREMENT,
  							ref varchar(100) NOT NULL,
  							ref_id int(11) NOT NULL,
							token text NOT NULL,
  							PRIMARY KEY (ddc_payment_id),
  							KEY ref_id (ref_id)
						)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
  			" );

  	if (!$db->query()) {
  		$this->setError($db->getErrorMsg());
  		return false;
  	}

   }
  
  function addservice()
  {
  	$app = JFactory::getApplication();
  	$modelServices = new DdcbookitModelsServices();
  	$this->services = $modelServices->listItems();
  	$num_services = count($this->services);
  	$servicecheck = array();
  	for($svce=0;$svce<$num_services;$svce++)
  	{
  		if($app->input->get('service'.$svce,null)!="")
  		{
  			array_push($servicecheck,$app->input->get('service'.$svce,null));
  		}
  	}
  	$services=null;
  	for($svce=0;$svce<$num_services;$svce++)
  	{
  		if($services==null)
  		{
  			if(in_array($this->services[$svce]->ddcbookit_services_id,$servicecheck)){
  				$services = $this->services[$svce]->ddcbookit_services_id;
  			}
  		}else
  		{
  			if(in_array($this->services[$svce]->ddcbookit_services_id,$servicecheck)){
  				$services = $services.','.$this->services[$svce]->ddcbookit_services_id;
  			}
  		}
  	}
  	$residence_id = $app->input->get('residence_id',null);
  	// Get a db connection.
  	$db = JFactory::getDbo();
  	
  	// Create a new query object.
  	$query = $db->getQuery(true);

  	
  	// Fields to update.
  	$fields = array(
  		$db->quoteName('services') . ' = '.$db->quote($services)
 	);
  	
  	// Conditions for which records should be updated.
  	$conditions = array(
  		$db->quoteName('ddcbookit_residence_id') . ' = '.$db->quote($residence_id)
  	);
  	
  	$query->update($db->quoteName('#__ddcbookit_residences'))->set($fields)->where($conditions);
  
  	// Set the query using our newly populated query object and execute it.
  	$db->setQuery($query);
  	$db->execute();
  	
  	return $query;
  }

}