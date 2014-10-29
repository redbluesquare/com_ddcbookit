<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsBookings extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    	= null;
  var $_booking_id			= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  var $_user_id     		= null;
  var $_bookdate			= null;
  var $_checkin				= null;
  var $_checkout			= null;
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
  	$this->session = JFactory::getSession();
  	if($app->input->get('booking_id', null)==null){
  		$this->_booking_id = $this->session->get('bookingref');
  	}else{
  		$this->_booking_id = $app->input->get('booking_id', null);
  	}
  	$input = new JInput();
  	$jinput = JFactory::getApplication()->input;
   	$this->_formdata    = $jinput->get('jform', array(),'array');
   	if(isset($this->_formdata['check'])){	
   		if(isset($this->_formdata['ppl']) Or isset($this->_formdata['checkin']) Or isset($this->_formdata['checkout'])){
   			$this->_ppl = $this->_formdata['ppl'];
   			$this->_checkin = date('Y-m-d', strtotime(str_replace('-','/',$this->_formdata['checkin'])));
   			$this->_checkout = date('Y-m-d', strtotime(str_replace('-','/',$this->_formdata['checkout'])));
   		}
   	}
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_checkin = $app->input->get('datecheckin', null);
  	$this->_checkout = $app->input->get('datecheckout', null);
  	$this->_cat_id = $app->input->get('id', null);
  	//$this->_apartment_id = $app->input->get('apartment_id', null);
  	$jinput = JFactory::getApplication()->input;
  	$this->contact_name = $jinput->get('contact_name', null, 'string');
  	$this->contact_email = $jinput->get('contact_email',null,'string');
  	$this->contact_tel = $jinput->get('contact_tel',null);
  	$this->company = $jinput->get('company',null,'string');
  	$this->flight = $jinput->get('flight',null,'string');
  	$this->airport = $jinput->get('airport',null,'string');
  	$this->arrival_time = $jinput->get('arrival_time',null);
  	$this->notes = $jinput->get('notes',null, 'string');
  	$this->representative = $jinput->get('representative',null,'string');
  	$this->euracom_source = $jinput->get('euarcom_source',null);
  	$this->adults = $jinput->get('num_adults',null);
  	$this->kids = $jinput->get('num_kids',null);
  	$this->booked_price = $jinput->get('booked_price',null);
  	$this->_apartment_id = $jinput->get('apartment_id',null);
  	$this->user_id = $jinput->get('user_id',null);
  	$this->checkin = JHtml::date($jinput->get('checkin',null),'Y-m-d');
  	$this->checkout = JHtml::date($jinput->get('checkout',null),'Y-m-d');
  	$this->beds = $jinput->get('beds_required',null);
  	$this->terms = $jinput->get('terms',null);
  	$this->residence_id = $jinput->get('residence_id',null);
  	  	
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

    $query->select('apartbook.*');
    $query->from('#__ddcbookit_bookings as apartbook');
    $query->select('apartment.residence_name as residence_id');
    $query->select('apartment.house_num');
    $query->select('apartment.min_stay');
    $query->select('apartment.ddcbookit_apartments_id as apart_id');
    $query->leftJoin('#__ddcbookit_apartments as apartment on apartbook.apartment_id = apartment.ddcbookit_apartments_id');
    $query->select('residence.*');
    $query->leftjoin('#__ddcbookit_residences as residence on residence.ddcbookit_residence_id = apartment.residence_name');
    $query->select('proptype.proptype_title');
    $query->leftJoin('#__ddcbookit_proptypes as proptype on apartment.proptype_id = proptype.ddcbookit_proptype_id');
    $query->group('apartbook.ddcbookit_bookings_id');
    $query->order('apartment.ddcbookit_apartments_id');
    $query->order('apartbook.checkin');
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
  	if($this->_booking_id!=null)
  	{
  		$query->where('apartbook.ddcbookit_bookings_id = "'.$this->_booking_id.'"');
  	}
  	if($this->_apartment_id!=null)
  	{
  		$query->where('apartment.ddcbookit_apartments_id = "'.$this->_apartment_id.'"');
  	}
  	//if($this->_apartment_id!=null)
  	//{
  	//	$query->where('apartbook.apartment_id = "'.$this->_apartment_id.'"');
  	//}
   return $query;
  }
  public function storebooking(){
  	$date = date("Y-m-d H:i:s");
  	$jinput = JFactory::getApplication()->input;
  	$this->data = $jinput->get('jform', array(),'array');
  	
  	
  	$contact_name = $jinput->get('contact_name', null, 'string');
  	$contact_email = $jinput->get('contact_email',null,'string');
  	$contact_tel = $jinput->get('contact_tel',null);
  	$company = $jinput->get('company',null,'string');
  	$flight = $jinput->get('flight',null,'string');
  	$airport = $jinput->get('airport',null,'string');
  	$arrival_time = $jinput->get('arrival_time',null);
  	$notes = $jinput->get('notes',null, 'string');
  	$representative = $jinput->get('representative',null,'string');
  	$euracom_source = $jinput->get('euarcom_source',null);
  	$adults = $jinput->get('num_adults',null);
  	$kids = $jinput->get('num_kids',null);
  	$booked_price = $jinput->get('booked_price',null);
  	$apartment_id = $jinput->get('apartment_id',null);
  	$user_id = $jinput->get('user_id',null);
  	$checkin = $jinput->get('checkin',null);
  	$checkout = $jinput->get('checkout',null);
  	$beds = $jinput->get('beds_required',null);
  	$terms = $jinput->get('terms',null);
  	$residence_id = $jinput->get('residence_id',null);
  	$status = $jinput->get('status',null);
  	$created = $date;
  	$modified = $date;

  	if($contact_name==null || $contact_email==null || $contact_tel==null || $terms==0)
  	{
  		$app = JFactory::getApplication();
  		$msg = "Please complete all required fields";
  		$link=  JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$apartment_id,true);
  		$app->redirect($link,$msg);
  	}
  	elseif($apartment_id==DdcbookitModelsDefault::checkmybooking($apartment_id, $checkin, $checkout))
  	{
  		$app = JFactory::getApplication();
  		$msg = "Send message of booking details and note to call";
  		$link=  JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$apartment_id,true);
  		$app->redirect($link,$msg);
  	}
  	else{
  	
  	// Get a db connection.
  	$db = JFactory::getDbo();
  	
  	// Create a new query object.
  	$query = $db->getQuery(true);
  	
  	// Insert columns.
  	$columns = array('user_id', 'apartment_id', 'checkin', 'checkout', 'num_adults',
  					'num_kids', 'beds_required', 'created', 'modified', 'status',
  					'terms', 'contact_name', 'company', 'airport', 'flight',
  					'arrival_time', 'notes', 'representative', 'euracom_source', 'booked_price',
  					'contact_tel', 'contact_email');
  	
  	// Insert values.
  	$values = array($db->quote($user_id), $db->quote($apartment_id), $db->quote($checkin), $db->quote($checkout), $db->quote($adults),
  					$db->quote($kids), $db->quote($beds), $db->quote($created), $db->quote($modified), $db->quote($status),
  					$db->quote($terms), $db->quote($contact_name), $db->quote($company), $db->quote($airport), $db->quote($flight),
  					$db->quote($arrival_time), $db->quote($notes), $db->quote($representative), $db->quote($euracom_source), $db->quote($booked_price),
  					$db->quote($contact_tel), $db->quote($contact_email),);
  	
  	// Prepare the insert query.
  	$query
  	->insert($db->quoteName('#__ddcbookit_bookings'))
  	->columns($db->quoteName($columns))
  	->values(implode(',', $values));
  	
  	// Set the query using our newly populated query object and execute it.
  	$db->setQuery($query);
  	$db->execute();
  	$bookingref = $db->insertid();
  	$this->session->set('bookingref',$bookingref);
  	
  	return $query;
	
  	}
  }
  
}
