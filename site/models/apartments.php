<?php // no direct access

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
  var $_ppl					= null;
  var $_adults				= null;
  var $_kids				= null;
  var $_rooms				= null;
  var $_proptype			= null;
  var $_formdata			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$app = JFactory::getApplication();
  	$session = JFactory::getSession();
  	$input = new JInput();
  	if($input->get('apartmentdatecheck',null)==1){
  		$session->set('checkin', JHtml::date($input->get('datecheckin',null),"Y-m-d"));
  		$session->set('checkout', JHtml::date($input->get('datecheckout',null),"Y-m-d"));
  		$session->set('check', 1);
  		$session->set('adults', 2);
  		$session->set('kids', 0);
  	}
  	if($session->get('adults')!=null && $input->get('check',null)==null){
  		$this->_adults = $session->get('adults');
  	}else{
  		$this->_adults = $input->get('adults',null);
  	}
  	if($session->get('kids')!=null){
  		$this->_kids = $session->get('kids');
  	}else{
  		$this->_kids = $input->get('kids',null);
  	}
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
  	if($app->input->get('apartment_id', null)!=null){
  		$this->_apartment_id = $app->input->get('apartment_id', null);
  	}
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_ppl = $input->get('ppl',null);
  	$this->_rooms = $app->input->get('rooms', null);
  	$this->_proptype = $input->get('proptype', null);
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
    $query->select('apartment.apartment_name');
    $query->select('apartment.residence_name as res_id');
    $query->select('apartment.max_adults');
    $query->select('apartment.max_kids');
    $query->select('apartment.min_stay');
    $query->select('apartment.hits');
    $query->select('apartment.catid');
    $query->select('apartment.state');
    $query->select('apartment.proptype_id as pt_id');
    $query->select('(apartment.max_kids+apartment.max_adults) as ppl');
    $query->select('apartment.num_of_beds');
    $query->select('apartment.num_of_apartments');
    $query->select('price.price');
    $query->select('proptype.ddcbookit_proptype_id');
    $query->select('proptype.proptype_title as pt');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->from('#__ddcbookit_proptypes as proptype');
    $query->from('#__ddcbookit_apartment_prices as price');
    $query->select('residence.main_image');
    $query->select('residence.image_thumb');
    $query->select('residence.residence_name as res_name');
    $query->select('residence.town');
    $query->select('residence.post_code');
    $query->select('residence.description');
    $query->from('#__ddcbookit_residences as residence');
    $query->where('apartment.residence_name = residence.ddcbookit_residence_id');
    $query->where('apartment.proptype_id = proptype.ddcbookit_proptype_id');
<<<<<<< HEAD
    $query->where('price.apartment_id = apartment.ddcbookit_apartments_id');
=======
>>>>>>> branch 'master' of https://github.com/redbluesquare/com_ddcbookit
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
  	if($this->_adults!=null)
  	{
  		$query->where('(apartment.max_kids+apartment.max_adults) >= "'.((int)$this->_adults+(int)$this->_kids).'"');
  	}
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
  		$query->where('(price.max_days >= "'.$this->_stayindays.'") AND (price.min_days <= "'.$this->_stayindays.'")');
  	
  	}
  	else
  	{
  		$query->where('(price.max_days >= "'.$this->_stayindays.'") AND (price.min_days <= "'.$this->_stayindays.'")');
  		$query->where('apartment.min_stay <= "'.$this->_stayindays.'"');
  	}
   return $query;
  }
  
  static function getPrices()
  {
  	//UPDATE TO THIS QUERYTO JUST RUN ONCE
  	//SELECT `apartment_id`, min(`max_days`) as max_days, price FROM `jdev1_ddcbookit_apartment_prices` WHERE (apartment_id = 1) AND (max_days >= 29)
  	
  	$db = JFactory::getDBO();
  	$query = $db->getQuery(TRUE);
  	$query->select('price.ddcbookit_apartment_price_id as id, price.residence_id, price.proptype_id, price.catid, price.max_days, price.price');
  	$query->select('price.startdate');
  	$query->select('price.enddate');
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
