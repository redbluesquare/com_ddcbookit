<?php // no direct access
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsApartments extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id   		= null;
  var $_residence_id		= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  var $_user_id     		= null;
  var $_max_guests			= null;
  var $_adults				= null;
  var $_children			= null;
  var $_rooms				= null;
  var $_proptype			= null;
  var $_formdata			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_rooms = $app->input->get('rooms', null);
  	$this->_cat_id = $app->input->get('id', null);
  	$session = JFactory::getSession();
  	$input = new JInput();
  	if($input->get('check')==2){
  		$session->clear('check');
  		$session->clear('location');
  		$session->clear('proptype');
  		$session->clear('checkin');
  		$session->clear('checkout');
  		$session->clear('adults');
  		$session->clear('children');
  	}
  	if( ($input->get('apartmentdatecheck',null)==1) OR ($input->get('check',null)==1)){
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
  	if($session->get('checkin')!=null){
  	$checkin = $session->get('checkin');
  	$checkout = $session->get('checkout');
  	}else{
  		$checkin = JHtml::date($input->get('datecheckin',null),"Y-m-d");
  		$checkout = JHtml::date($input->get('datecheckout',null),"Y-m-d");
  	}
  	$checkinA = date_create($checkin);
  	$checkoutA = date_create($checkout);
  	$interval = date_diff($checkinA, $checkoutA);
  	$this->_stayindays = $interval->format('%a');
  	if($app->input->get('apartment_id', null)!=null){
  		$this->_apartment_id = $app->input->get('apartment_id', null);
  	}
  	
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
    $query->select('apartment.apartment_name');
    $query->select('apartment.residence_name as res_id');
    $query->select('apartment.max_guests');
    $query->select('apartment.min_guests');
    $query->select('apartment.min_stay');
    $query->select('apartment.hits');
    $query->select('apartment.state');
    $query->select('apartment.proptype_id as pt_id');
    $query->select('residence.main_image');
    $query->select('residence.image_thumb');
    $query->select('residence.residence_name as res_name');
    $query->select('residence.town');
    $query->select('residence.post_code');
    $query->select('residence.description');
    $query->select('max_guests');
    $query->select('apartment.num_of_beds');
    $query->select('apartment.num_of_apartments');
    $query->select('apartment.thumbnail_image');
    $query->select('cat.title as cat_title');
    $query->select('c.title');
    $query->select('proptype.ddcbookit_proptype_id');
    $query->select('proptype.proptype_title as pt');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->leftJoin('#__ddcbookit_residences as residence ON (apartment.residence_name = residence.ddcbookit_residence_id)');
    $query->leftJoin('#__ddcbookit_proptypes as proptype ON (apartment.proptype_id = proptype.ddcbookit_proptype_id)');
    $query->leftJoin('#__categories as c ON (apartment.catid = c.id)');
    $query->leftJoin('#__ddcbookit_poi as poi ON (poi.ddcbookit_poi_id = residence.nearest_poi)');
    $query->leftJoin('#__categories as cat ON poi.catid = cat.id');

    $query->group('apartment.ddcbookit_apartments_id');
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
  		$query->where('apartment.ddcbookit_apartments_id = "'.(int)$this->_apartment_id.'"');
  	}
  	if($this->_proptype!=null)
  	{
  		$query->where('apartment.proptype_id = "'.(int)$this->_proptype.'"');
  	}
  	if($this->_residence_id!=null)
  	{
  		$query->where('residence.ddcbookit_residence_id = "'.(int)$this->_residence_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('apartment.state >= "'.(int)$this->_published.'"');
  	}
  	if($this->_stayindays==0)
  	{
  	
  	}
  	else
  	{
  		$query->where('apartment.min_stay <= "'.$this->_stayindays.'"');
  	}
  	if(($this->_adults!=null) Or ($this->_children!=null))
  	{
  		$query->where('apartment.max_guests >= "'.((int)$this->_adults+(int)$this->_children).'"');
  	}
   return $query;
  }
 
  
  //Add a hit when ever a user gets to the booking stage
  public function hit($pk = 0)
  {
  	$input = JFactory::getApplication()->input;
    $hitcount = $input->getInt('hitcount', 1);
  	if ($hitcount)
  	{
  		// Initialise variables.
  		$pk = (!empty($pk)) ? $pk : (int)$this->_apartment_id;
  		$db = JFactory::getDBO();
  
  		$db->setQuery(
  				'UPDATE #__ddcbookit_apartments' .
  				' SET hits = hits + 1' .
  				' WHERE ddcbookit_apartments_id = '.(int) $pk
  		);
  
  		if (!$db->query()) {
  			$this->setError($db->getErrorMsg());
  			return false;
  		}
  	}
  
  	return true;
  }
  
}