<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsResidence extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    	= null;
  var $_residence_id		= null;
  var $_featured_id			= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  var $_user_id     		= null;
  var $_bookdate			= null;
  var $_checkin				= null;
  var $_checkout			= null;
  var $_children			= null;
  var $_adults				= null;
  var $_stayindays			= null;
  var $_formdata			= null;
  var $_max_guests			= null;
  var $_proptype			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
   	$this->_max_guests = $app->input->get('max_guests', null);
  	$this->_residence_id = $app->input->get('residence_id', null);
  	if($app->input->get('apartment_id', null)!=null){
  		$this->_apartment_id = $app->input->get('apartment_id', null);
  	}
  	$this->_featured_id = $app->input->get('featured_id', null);
  	$this->_cat_id = $app->input->get('id', null);
  	$app = JFactory::getApplication();
  	$session = JFactory::getSession();
  	$input = new JInput();
  	if($input->get('apartmentdatecheck',null)==1){
  		$session->set('checkin', JHtml::date($input->get('datecheckin',null),"Y-m-d"));
  		$session->set('checkout', JHtml::date($input->get('datecheckout',null),"Y-m-d"));
  		$session->set('check', 1);
  		$session->set('adults', $input->get('adults',null));
  		$session->set('proptype', $input->get('proptype',null));
  		$session->set('children', $input->get('children',null));
  	}
  	if($session->get('adults')!=null && $input->get('check',null)==null){
  		$this->_adults = $session->get('adults');
  	}else{
  		$this->_adults = $input->get('adults',null);
  	}
  	if($session->get('proptype')!=null && $input->get('check',null)==null){
  		$this->_proptype = $session->get('proptype');
  	}else{
  		$this->_proptype = $input->get('proptype',null);
  	}
  	if($session->get('children')!=null){
  		$this->_children = $session->get('children');
  	}else{
  		$this->_children = $input->get('children',null);
  	}
  	$this->_max_guests = (int)$this->_adults+(int)$this->_children;
  	if($session->get('checkin')!=null){
  	$checkin = $session->get('checkin');
  	$checkout = $session->get('checkout');
  	}else{
  		$checkin = JHtml::date($input->get('datecheckin',null),"Y-m-d");
  		$checkout = JHtml::date($input->get('datechecout',null),"Y-m-d");
  	}
  	$checkinA = date_create($checkin);
  	$checkoutA = date_create($checkout);
  	$interval = date_diff($checkinA, $checkoutA);
  	$this->_stayindays = $interval->format('%a');
  	
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

    $query->select('residence.*');
    $query->from('#__ddcbookit_residences as residence');
	$query->select('apartment.residence_name as residence_id');
	$query->select('apartment.ddcbookit_apartments_id as apart_id');
	$query->select('apartment.min_stay');
	$query->select('COUNT(apartment.ddcbookit_apartments_id) as num_of_aparts');
	$query->select('apartment.max_guests');
	$query->select('poi.title as poi_title');
	$query->select('cat.title as cat_title');
	$query->select('proptype.proptype_title as pt');
	$query->from('#__ddcbookit_proptypes as proptype');
	$query->from('#__ddcbookit_apartments as apartment');
	$query->from('#__ddcbookit_poi as poi');
	$query->from('#__categories as cat');
	$query->where('apartment.residence_name = residence.ddcbookit_residence_id');
	$query->where('apartment.proptype_id = proptype.ddcbookit_proptype_id');
	$query->where('poi.catid = cat.id');
    $query->where('poi.ddcbookit_poi_id = residence.nearest_poi');
	$query->group('residence.ddcbookit_residence_id');
	$query->order('apartment.hits DESC');
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
  		$query->where('apartment.ddcbookit_apartments_id = "'.$this->_apartment_id.'"');
  	}
  	if($this->_max_guests!=null)
  	{
  		$query->where('apartment.max_guests >= "'.(int)$this->_max_guests.'"');
  	}
  	if($this->_residence_id!=null)
  	{
  		$query->where('residence.ddcbookit_residence_id = "'.$this->_residence_id.'"');
  	}
  	if($this->_proptype!=null)
  	{
  		$query->where('apartment.proptype_id = "'.$this->_proptype.'"');
  	}
  	if($this->_featured_id!=null)
  	{
  		$query->where('f.ddcbookit_featuredapartment_id = "'.$this->_featured_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('residence.state = "'.$this->_published.'"');
  	}
  	if(($this->_stayindays!=0))
  	{
  		$query->where('apartment.min_stay <= "'.$this->_stayindays.'"');
  	}


   return $query;
  }
}