<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsBooking extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    	= null;
  var $_residence_id		= null;
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
   	if(isset($this->_formdata['ppl']) Or isset($this->_formdata['checkin']) Or isset($this->_formdata['checkout'])){
   		$this->_ppl = $this->_formdata['ppl'];
   		$this->_checkin = date('Y-m-d', strtotime(str_replace('-','/',$this->_formdata['checkin'])));
   		$this->_checkout = date('Y-m-d', strtotime(str_replace('-','/',$this->_formdata['checkout'])));
   	}
   	$this->_apartment_id = $app->input->get('apartment_id', null);
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_checkin = $app->input->get('datecheckin', null);
  	$this->_checkout = $app->input->get('datecheckout', null);
  	$this->_cat_id = $app->input->get('id', null);
  	  	
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

    $query->select('residence.ddcbookit_residence_id');
    $query->select('apartment.min_stay');
    $query->select('apartment.ddcbookit_apartments_id as apart_id');
    $query->select('proptype.proptype_title');
    $query->select('residence.residence_name');
    $query->select('residence.address1');
    $query->select('residence.town');
    $query->select('residence.post_code');
    $query->select('apartbook.*');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->from('#__ddcbookit_residences as residence');
    $query->from('#__ddcbookit_bookings as apartbook');
    $query->from('#__ddcbookit_proptypes as proptype');
    $query->where('(apartbook.apartment_id = apartment.ddcbookit_apartments_id)');
    $query->where('(residence.ddcbookit_residence_id = apartment.residence_name)');
    $query->where('(apartment.proptype_id = proptype.ddcbookit_proptype_id)');
    $query->group('apartbook.ddcbookit_bookings_id');
    $query->order('apartment.ddcbookit_apartments_id');
    return $query;
    
  }

  /**
  * Builds the filter for the query
  * @param    object  Query object
  * @return   object  Query object
  *
  */
  protected function _buildWhere($query, $apartment_id, $checkin, $checkout)
  {
  	if($this->_booking_id!=null)
  	{
  		$query->where('(apartbook.ddcbookit_bookings_id = "'.$this->_booking_id.'")');
  	}
<<<<<<< HEAD
  	if($this->_apartment_id!=null)
  	{
  		$query->where('(apartment.ddcbookit_apartments_id = "'.$this->_apartment_id.'")');
  	}
=======
>>>>>>> branch 'master' of https://github.com/redbluesquare/com_ddcbookit
  	if($checkin!=null || $checkout!=null)
  	{
  		$query->where('(("'.$checkin.'" BETWEEN apartbook.checkin AND apartbook.checkout) Or ("'.$checkout.'" BETWEEN apartbook.checkin AND apartbook.checkout))');
  	}
  	//$query->where('(apartbook.checkout > date(now()))');
  	$query->where('(apartbook.status<>"0")');
   return $query;
  }
  public function storebooking(){
  	$date = date("Y-m-d H:i:s");
  	$jinput = JFactory::getApplication()->input;
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
  	$status = 1;
  	$created = $date;
  	$modified = $date;
  	$sitetitle = JFactory::getApplication()->getCfg('sitename');

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
