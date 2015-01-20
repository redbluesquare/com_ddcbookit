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
  	$this->_apartment_id = $app->input->get('apartment_id', null);
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
  	$kids = $jinput->get('num_children',null);
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
  
  /**
   * Function to save an e-mail before sending it out to all relevant receipients
   * @table		#__ddcmailmax_articles to save the data
   * @link		c.catid to save the ddcbookit_bookings_id in the @table
   */
  public function booking_request_mail()
  {
  	//get the new booking posted by function storebooking()
  	$params = JComponentHelper::getParams('com_ddcbookit');
  	$modelBooking = new DdcbookitModelsBookings();
  	$this->booking = $modelBooking->getItem();
  	$booking_id = (string)$this->booking->ddcbookit_bookings_id;
  	$token = (string)$this->booking->token;
  	$contact_name = (string)$this->booking->contact_name;
  	$contact_email = (string)$this->booking->contact_email;
  	$contact_tel = (string)$this->booking->contact_tel;
  	$residence_name = (string)$this->booking->residence_name;
  	$proptype_title = (string)$this->booking->proptype_title;
  	$num_adults = (string)$this->booking->num_adults;
  	$num_kids = (string)$this->booking->num_kids;
  	$checkin = (string)JHtml::date($this->booking->checkin,'d-M-Y');
  	$checkout = (string)JHtml::date($this->booking->checkout,'d-M-Y');
  	$address1 = (string)$this->booking->address1;
  	$town = (string)$this->booking->town;
  	$status = (int)$this->booking->status;
  	$post_code = (string)$this->booking->post_code;
  	$booked_price = (string)number_format($this->booking->booked_price,2);
  	if($booked_price==0)
  	{
  		$booked_price="TBC";
  	}
  	$todaysdate =  (string)JHtml::date("",'Y-m-d');
  	$year =  (string)JHtml::date("",'Y');
  	$emailheader = null;
  	$bookref = (string)$params->get('book_reference');
  	$terms = null;
  	$interval = date_diff(date_create($this->booking->checkin),date_create($this->booking->checkout));
  	$days = (int)$interval->format('%a');
  	$paymenturl = JUri::root().'index.php?option=com_ddcbookit&view=bookings&layout=default&booking_id='.$booking_id.'&token='.$token;
  	 
  	$sitetitle = JFactory::getApplication()->getCfg('sitename');
  	 
  	if($status==1):
  	$emailheader = (string)$params->get('email_header');
  	$terms = (string)$params->get('terms_details_request');
  	$message = <<<EOT
  	<div style="width:800px; box-shadow:#ccc 0px 0px 5px;">
  		<div style="background:#163bb2;display:block;width:770px;color:#cfcfcf;padding:2px 10px 1px 20px;">
  			<h1 style="padding:10px;">$sitetitle</h1>
  		</div>
		<div style="background:#ffffff;display:block;padding:10px;"><h2>$emailheader</h2><hr />
			<table class="table borderless"><tbody>
			<tr><td class="span3" style="text-align:right;font-weight:bold;">$bookref </td><td class="span9">$booking_id</td></tr>
			<tr><td class="span3" style="text-align:right;font-weight:bold;">Contact Name: </td><td class="span9">$contact_name</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Contact E-mail: </td><td>$contact_email</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Contact Telephone: </td><td>$contact_tel</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Apartment: </td><td><span style="font-weight:bold;font-size:1.3em;color:#990099">$residence_name</span><br />$proptype_title</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Address: </td><td>$address1<br />$town<br />$post_code<br /></td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Number of Guests: </td><td>$num_adults adults and $num_kids kids</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Duration: </td><td><span class="price_green\">$checkin</span> to <span class="price_green">$checkout</span> ($days nights)</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Price: </td><td>&pound; $booked_price</td></tr>
  			</tbody>
  			</table>
			$terms
		</div>
		<div style="background:#163bb2;display:block;min-height:20px;padding:10px;">
			<p style="float:right;color:#ffffff\"><a style="color:#ffffff;text-decoration:none;" href="http:\\www.euracomapartments.co.uk">Euracom Apartments $year</a></p><div style="clear:both;">
		</div>
	</div>
EOT;
  	endif;
  	if($status==2):
  	$emailheader = (string)$params->get('email_header_conf');
  	$terms = (string)$params->get('terms_details_confirmed');
  	$message = <<<EOT
  	<div style="width:800px; box-shadow:#ccc 0px 0px 5px;">
  		<div style="background:#163bb2;display:block;width:770px;color:#cfcfcf;padding:2px 10px 1px 20px;">
  			<h1 style="padding:10px;">$sitetitle</h1>
  		</div>
		<div style="background:#ffffff;display:block;padding:10px;"><h2>$emailheader</h2><hr />
			<table class="table borderless"><tbody>
			<tr><td colspan="2">We have good news, your booking has now been confirmed and ready for payment. Please <a href="$paymenturl" target="_BLANK" >click here</a> to enter your payment details.</td></tr>
			<tr><td class="span3" style="text-align:right;font-weight:bold;">$bookref: </td><td class="span9">$booking_id</td></tr>
			<tr><td class="span3" style="text-align:right;font-weight:bold;">Contact Name: </td><td class="span9">$contact_name</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Contact E-mail: </td><td>$contact_email</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Contact Telephone: </td><td>$contact_tel</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Apartment: </td><td><span style="font-weight:bold;font-size:1.3em;color:#990099">$residence_name</span><br />$proptype_title</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Address: </td><td>$address1<br />$town<br />$post_code<br /></td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Number of Guests: </td><td>$num_adults adults and $num_kids kids</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Duration: </td><td><span class="price_green\">$checkin</span> to <span class="price_green">$checkout</span> ($days nights)</td></tr>
  			<tr><td style="text-align:right;font-weight:bold;">Price: </td><td>&pound; $booked_price</td></tr>
  			</tbody>
  			</table>
			$terms
		</div>
		<div style="background:#163bb2;display:block;min-height:20px;padding:10px;">
			<p style="float:right;color:#ffffff\"><a style="color:#ffffff;text-decoration:none;" href="http:\\www.euracomapartments.co.uk">Euracom Apartments $year</a></p><div style="clear:both;">
		</div>
	</div>
EOT;
  	endif;
  	 
  	// Get a db connection.
  	$db = JFactory::getDbo();
  
  	// Create a new query object.
  	$query = $db->getQuery(true);
  	 
  	// Insert columns.
  	$columns = array('title', 'alias', 'fulltext', 'ref_id', 'state', 'created', 'modified');
  	 
  	// Insert values.
  	$values = array($db->quote(''), $db->quote(''), $db->quote($message), $db->quote($booking_id), '1', $todaysdate, $todaysdate);
  	 
  	// Prepare the insert query.
  	$query
  	->insert($db->quoteName('#__ddcmailmax_articles'))
  	->columns($db->quoteName($columns))
  	->values(implode(',', $values));
  	 
  	// Set the query using our newly populated query object and execute it.
  	$db->setQuery($query);
  	$db->execute();
  	 
  	$name		= $contact_name;
  	$email		= JStringPunycode::emailToPunycode($contact_email);
  	$subject	= "Booking made today on www.euracomapartments.co.uk";
  
  	$result = array($message, $name, $email, $subject);
  	 
  	return $result;
  }
  
}