<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsBooking extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_apartment_id    	= null;
  var $_residence_id		= null;
  var $_booking_id			= null;
  var $_session				= null;
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
  	$this->_session = JFactory::getSession();
  	if($app->input->get('booking_id', null)==null){
  		$this->_booking_id = $this->_session->get('bookingref');
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
    $query->select('c.title');
    $query->select('apartbook.*');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->from('#__ddcbookit_residences as residence');
    $query->from('#__ddcbookit_bookings as apartbook');
    $query->from('#__ddcbookit_proptypes as proptype');
    $query->from('#__categories as c');
    $query->where('(c.id = apartment.catid)');
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
  	if($this->_apartment_id!=null)
  	{
  		$query->where('(apartment.ddcbookit_apartments_id = "'.$this->_apartment_id.'")');
  	}
  	if($checkin!=null || $checkout!=null)
  	{
  		$query->where('(("'.$checkin.'" BETWEEN apartbook.checkin AND apartbook.checkout) Or ("'.$checkout.'" BETWEEN apartbook.checkin AND apartbook.checkout))');
  	}

  	$query->where('(apartbook.status<>"0")');
  	//$this->_session->clear('bookingref');
   return $query;
  }
  public function storebooking(){
  	$date = date("Y-m-d H:i:s");
  	$jinput = JFactory::getApplication()->input;
  	$token = new DdcbookitModelsDefault();
  	$token = $token->randstring(40);
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
  	$apartment_id = $jinput->get('apartment_id',null);
  	$user_id = $jinput->get('user_id',null);
  	$checkin = JHtml::date($jinput->get('checkin',null),"Y-m-d");
  	$checkout = JHtml::date($jinput->get('checkout',null),"Y-m-d");
  	$booked_price = DdcbookitModelsDefault::apartment_price($apartment_id, $checkin, $checkout);
  	$booked_price = $booked_price[0];
  	$beds = $jinput->get('beds_required',null);
  	$terms = $jinput->get('terms',null);
  	//$residence_id = $jinput->get('residence_id',null);
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
  	else{
  	
  	// Get a db connection.
  	$db = JFactory::getDbo();
  	
  	// Create a new query object.
  	$query = $db->getQuery(true);
  	
  	// Insert columns.
  	$columns = array('user_id', 'apartment_id', 'checkin', 'checkout', 'num_adults',
  					'num_kids', 'beds_required', 'created', 'modified', 'status',
  					'terms', 'token', 'contact_name', 'company', 'airport', 'flight',
  					'arrival_time', 'notes', 'representative', 'euracom_source', 'booked_price',
  					'contact_tel', 'contact_email');
  	
  	// Insert values.
  	$values = array($db->quote($user_id), $db->quote($apartment_id), $db->quote($checkin), $db->quote($checkout), $db->quote($adults),
  					$db->quote($kids), $db->quote($beds), $db->quote($created), $db->quote($modified), $db->quote($status),
  					$db->quote($terms), $db->quote($token,true), $db->quote($contact_name), $db->quote($company), $db->quote($airport), 
  					$db->quote($flight), $db->quote($arrival_time), $db->quote($notes), $db->quote($representative), 
  					$db->quote($euracom_source), $db->quote($booked_price), $db->quote($contact_tel), $db->quote($contact_email));
  	
  	// Prepare the insert query.
  	$query
  	->insert($db->quoteName('#__ddcbookit_bookings'))
  	->columns($db->quoteName($columns))
  	->values(implode(',', $values));
  	
  	// Set the query using our newly populated query object and execute it.
  	$db->setQuery($query);
  	$db->execute();
  	$bookingref = $db->insertid();
  	$this->_session->set('bookingref',$bookingref);
  	
  	
  	return $query;
	
  	}
  	
  }  
  public function booking_payment()
  {
  	$success = true;
  	$app = JFactory::getApplication();
  	$this->_booking_id;
  	$card_type = $app->input->get('card_type',null);
  	$issuing_bank = $app->input->get('issuing_bank',null,'string');
  	$card_number = $app->input->get('card_number',null);
  	$name_on_card = $app->input->get('name_on_card',null,'string');
  	$smonth = $app->input->get('smonth',null,'string');
  	$syear = $app->input->get('syear',null,'string');
  	$sdate = $smonth." / ".$syear;
  	$emonth = $app->input->get('emonth',null,'string');
  	$eyear = $app->input->get('eyear',null,'string');
  	$edate = $emonth." / ".$eyear;
  	$cvv2_number = $app->input->get('cvv2_number',null);
  	$issue_number = $app->input->get('issue_number',null);
  	$address_of_cardholder = $app->input->get('address_of_cardholder',null,'string');
  	$booking_id = $app->input->get('booking_id',null);
  	$table= $app->input->get('table',null);
  	
  	
  	if(($card_type==null) || ($issuing_bank==null) || ($card_number==null) || ($name_on_card==null) || ($emonth==null) || ($eyear==null) || ($cvv2_number==null) || ($address_of_cardholder==null) )
  	{
  		$this->session->set('card_type',$card_type);
  		$this->session->set('issuing_bank',$issuing_bank);
  		$this->session->set('card_number',$card_number);
  		$this->session->set('name_on_card',$name_on_card);
  		$this->session->set('smonth',$smonth);
  		$this->session->set('syear',$syear);
  		$this->session->set('emonth',$emonth);
  		$this->session->set('eyear',$eyear);
  		$this->session->set('cvv2_number',$cvv2_number);
  		$this->session->set('issue_number',$issue_number);
  		$this->session->set('address_of_cardholder',$address_of_cardholder);
  		$success = false;
  	}
  	
  	
  	$model = new DdcbookitModelsBooking();
  	$current_booking = $model->getItem();
  	if($current_booking->status!=2)
  	{
  		$this->_session->set('bookingref',$booking_id);
  		//exit and return to booking summary
  		return true;
  	}
  	elseif($success==false)
  	{
  		//exit and return to payment form
  		return false;
  	
  	}
  	else 
  	{
  		//proceed to next step and collect all data
  		$content .="Card Type: ".$card_type."<br>";
  		$content .="Issuing Bank: ".$issuing_bank."<br>";
  		$content .="Card Number: ".$card_number."<br>";
  		$content .="Name appearing on Card: ".$name_on_card."<br>";
  		$content .="Start Date: ".$sdate."<br>";
  		$content .="Expiry Date: ".$edate."<br>";
  		$content .="CVV2 Number: ".$cvv2_number."<br>";
  		$content .="Issue Number: ".$issue_number."<br>";
  		$content .="Address of Cardholder: ".$address_of_cardholder."<br>";
  		
  		$content = base64_encode($content);
  		
  		
  		// Get a db connection.
  		$db = JFactory::getDbo();
  		 
  		// Create a new query object.
  		$query = $db->getQuery(true);
  		
  		// Insert columns.
  		$columns = array('ref', 'ref_id', 'token');
  		
  		// Insert values.
  		$values = array($db->quote($table), $db->quote($booking_id), $db->quote($content));
  		
  		// Prepare the insert query.
  		$query
  		->insert($db->quoteName('#__ddc_payments'))
  		->columns($db->quoteName($columns))
  		->values(implode(',', $values));
  		
  		// Set the query using our newly populated query object and execute it.
  		$db->setQuery($query);
  		$db->execute();
  		
  		//Update the Booking status and token
  		$db = JFactory::getDbo();
  		
  		$query = $db->getQuery(true);
  		
  		// Fields to update.
  		$fields = array(
  				$db->quoteName('status') . ' = 3'
  		);
  		
  		// Conditions for which records should be updated.
  		$conditions = array(
  				$db->quoteName('ddcbookit_bookings_id') . ' = '.(int)$booking_id
  		);
  		
  		$query->update($db->quoteName('#__ddcbookit_bookings'))->set($fields)->where($conditions);
  		$db->setQuery($query);
  		$result = $db->execute();
  		
  		$this->_session->set('bookingref',$booking_id);
  		return true;
  		
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
  	$modelBooking = new DdcbookitModelsBooking();
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
  	$paymenturl = JRoute::_('index.php?option=com_ddcbookit&view=bookings&layout=default&booking_id='.$booking_id.'&token='.$token);
  	
  	$sitetitle = JFactory::getApplication()->getCfg('sitename');
  	
  	if($this->booking->status==1):
  	$emailheader = (string)$params->get('email_header');
  	$terms = (string)$params->get('terms_details_request');
  	$message = <<<EOT
  	<div style="width:800px; box-shadow:#ccc 0px 0px 5px;">
  		<div style="background:#163bb2;display:block;width:770px;color:#cfcfcf;padding:2px 10px 1px 20px;">
  			<h1 style="padding:10px;">$sitetitle</h1>
  		</div>
		<div style="background:#ffffff;display:block;padding:10px;"><h2>$emailheader</h2><hr />
			<table class="table borderless"><tbody>
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
  	if($this->booking->status==2):
  	$emailheader = (string)$params->get('email_header_conf');
  	$terms = (string)$params->get('terms_details_confirmed');
  	$message = <<<EOT
  	<div style="width:800px; box-shadow:#ccc 0px 0px 5px;">
  		<div style="background:#163bb2;display:block;width:770px;color:#cfcfcf;padding:2px 10px 1px 20px;">
  			<h1 style="padding:10px;">$sitetitle</h1>
  		</div>
		<div style="background:#ffffff;display:block;padding:10px;"><h2>$emailheader</h2><hr />
			<table class="table borderless"><tbody>
			<tr><td>We have good news, your booking has now been confirmed and ready for payment. Please <a href="$paymenturl" target="_BLANK" >click here</a> to enter your payment details.</td></tr>
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
	
  	$result = array($message,$name, $email, $subject);
  	
	return $result; 	
  }
}