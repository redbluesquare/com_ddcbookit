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
  var $_stayindays			= null;
  var $_formdata			= null;
  var $_ppl					= null;
  var $_proptype			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$app = JFactory::getApplication();
   	$this->_ppl = $app->input->get('ppl', null);
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_featured_id = $app->input->get('featured_id', null);
  	$this->_cat_id = $app->input->get('id', null);
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
	$query->select('(apartment.max_kids+apartment.max_adults) as ppl');
	$query->select('price.price');
	$query->select('proptype.proptype_title as pt');
	$query->from('#__ddcbookit_proptypes as proptype');
	$query->from('#__ddcbookit_apartments as apartment');
	$query->from('#__ddcbookit_apartment_prices as price');
	$query->where('apartment.residence_name = residence.ddcbookit_residence_id');
	$query->where('apartment.proptype_id = proptype.ddcbookit_proptype_id');
	$query->where('apartment.ddcbookit_apartments_id = price.apartment_id');
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
  	if($this->_residence_id!=null)
  	{
  		$query->where('residence.ddcbookit_residence_id = "'.$this->_residence_id.'"');
  	}
  	if($this->_featured_id!=null)
  	{
  		$query->where('f.ddcbookit_featuredapartment_id = "'.$this->_featured_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('residence.state = "'.$this->_published.'"');
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
}
