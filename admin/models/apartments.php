<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsApartments extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    		= null;
  var $_residence_id			= null;
  var $_cat_id		    		= null;
  var $_pagination  			= null;
  var $_published   			= 1;
  var $_user_id     			= null;
  var $_bookdate				= null;
  var $_checkin					= null;
  var $_checkout				= null;
  var $_adults					= null;
  var $_children				= null;
  var $_formdata				= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$app = JFactory::getApplication();
  	$this->_apartment_id = $app->input->get('apartment_id', null);
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_checkin = $app->input->get('datecheckin', null);
  	$this->_checkout = $app->input->get('datecheckout', null);
  	$this->_adults = $app->input->get('adults', null);
  	$this->_children = $app->input->get('children', null);
  	$this->_cat_id = $app->input->get('id', null);
  	$jinput = JFactory::getApplication()->input;
	$this->_formdata    = $jinput->get('jform', array(),'array');
  	  	
    parent::__construct();       
  }
    
	
  /**
  * Builds the query to be used by the product model
  * @return   object  Query object
  *
  *
  */
  protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('apartment.ddcbookit_apartments_id');
    $query->select('apartment.house_num');
    $query->select('apartment.num_of_apartments');
    $query->select('apartment.residence_name');
    $query->select('apartment.max_guests');
    $query->select('apartment.min_guests');
    $query->select('apartment.proptype_id');
    $query->select('apartment.num_of_beds');
    $query->select('apartment.catid');
    $query->select('apartment.min_stay');
    $query->select('apartment.thumbnail_image');
    $query->select('apartment.hits');
    $query->select('apartment.state');
    $query->select('cat.title as cat_title');
    $query->select('residence.residence_name as res_name,residence.ddcbookit_residence_id');
    $query->select('proptype.proptype_title,proptype.ddcbookit_proptype_id');
    $query->select('c.title as category_title');
    $query->select('poi.title as poi_title');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->leftJoin('#__ddcbookit_proptypes as proptype ON (proptype.ddcbookit_proptype_id = apartment.proptype_id)');
    $query->leftJoin('#__ddcbookit_residences as residence ON (residence.ddcbookit_residence_id = apartment.residence_name)');
    $query->leftJoin('#__categories as c ON (apartment.catid = c.id)');
    $query->leftJoin('#__ddcbookit_poi as poi ON (poi.ddcbookit_poi_id = residence.nearest_poi)');
    $query->leftJoin('#__categories as cat ON (cat.id = poi.catid)');
    $query->order('residence.residence_name ASC');
    $query->order('apartment.proptype_id ASC');
    
    return $query;
    
  }

  /**
  * Builds the filter for the query
  * @param    object  Query object
  * @return   object  Query object
  *
  */
  protected function _buildWhere(&$query)
  {

  	if($this->_apartment_id!=null)
  	{
  		$query->where('apartment.ddcbookit_apartments_id = "'.(int)$this->_apartment_id.'"');
  	}
  	if(($this->_adults!=null) Or ($this->_children!=null))
  	{
  		$query->where('apartment.ddcbookit_max_guests >= "'.((int)$this->_adults+(int)$this->_children).'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('residence.state = "'.$this->_published.'"');
  	}
  	
   return $query;
  }
  
  static function getPrices()
  {
  	$db = JFactory::getDBO();
  	$query = $db->getQuery(TRUE);
  	$query->select('price.ddcbookit_apartment_price_id as id, price.residence_id, price.proptype_id,price.max_days, price.price');
  	$query->from('#__ddcbookit_apartment_prices as price');
  	$query->group('price.ddcbookit_apartment_price_id');
  	// Reset the query using our newly populated query object.
  	$db->setQuery($query);
  	$results = $db->loadObjectList();
  	if($db->getErrorNum()){
  		JError::raiseWarning(500,$db->stderr(true));
  	}
  	return $results;
  }
}