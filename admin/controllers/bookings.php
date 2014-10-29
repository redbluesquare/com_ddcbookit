<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Residences Controller
 */
class DdcbookitControllersBookings extends DdcbookitControllersDefault
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		$this->data = $jinput->get('jform', array(),'array');
		
		if($this->data['table']=='bookings')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='booking.add')
			{
				$viewName = $app->input->getWord('view', 'bookings');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);		
			}
			if($task=="booking.save")
			{
 				$modelName = $app->input->get('models', 'Bookings');
 				$modelName  = 'DdcbookitModels'.ucwords($modelName);
   				$model = new $modelName();
   				
				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
					if($this->data['status']=='2'){
						$sent = false;
						$sent = $this->_sendConfEmail();
					}
					
					
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
				
				$viewName = $app->input->getWord('view', 'bookings');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);

			}
			if($task=="booking.cancel")
			{
				$viewName = $app->input->getWord('view', 'apartments');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
 
			}
			
			//display view
			return parent::execute();
		}
	}
	private function _sendConfEmail()
	{
		//get the new booking posted by function storebooking()
		$params = JComponentHelper::getParams('com_ddcbookit');
		$modelBooking = new DdcbookitModelsBookings();
		$this->booking = $modelBooking->getItem();
		$booking_id = (string)$this->booking->ddcbookit_bookings_id;
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
		$todaysdate =  (string)JHtml::date("",'Y');
		$emailheader = (string)$params->get('email_header_conf');
		$bookref = (string)$params->get('book_reference');
		$book_summary = (string)$params->get('book_summary_confirmed');
		$terms = (string)$params->get('terms_details_confirmed');
		$interval = date_diff(date_create($this->booking->checkin),date_create($this->booking->checkout));
		$days = (int)$interval->format('%a');
		 
		$sitetitle = JFactory::getApplication()->getCfg('sitename');
		$message = <<<EOT
  	<div style="width:800px; box-shadow:#ccc 0px 0px 5px;">
  		<div style="background:#163bb2;display:block;width:770px;color:#cfcfcf;padding:2px 10px 1px 20px;">
  			<h1 style="float:left;">$sitetitle</h1>
  			<p style="float:right;"><span>$bookref: </span><span>$booking_id</span></p>
  			<div style="clear:both;"></div>
  		</div>
		<div style="background:#ffffff;display:block;padding:10px;"><h2>$emailheader</h2><hr />
		<div>$book_summary</div>
			<table class="table borderless"><tbody>
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
			<div>$terms</div>
		</div>
		<div style="background:#163bb2;display:block;min-height:20px;padding:10px;">
			<p style="float:right;color:#ffffff\"><a style="color:#ffffff;text-decoration:none;" href="http:\\www.euracomapartments.co.uk">Euracom Apartments $todaysdate</a></p><div style="clear:both;">
		</div>
	</div>
EOT;
	
		$app = JFactory::getApplication();
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');
		$sitename	= $app->getCfg('sitename');
	
		$name		= $this->booking->contact_name;
		$email		= JStringPunycode::emailToPunycode($contact_email);
		$subject	= "Booking made today";
		$body		= "Booking message sent to e-mail address";
	
		// Prepare email body
		$prefix = JText::sprintf('COM_CONTACT_ENQUIRY_TEXT', JUri::base());
		$body	= $prefix."\n".$name.' <'.$email.'>'."\r\n\r\n".stripslashes($body);
	
		$mail = JFactory::getMailer();
		$mail->addRecipient($contact_email,$mailfrom);
		$mail->addReplyTo(array($email, $name));
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject($sitename.': '.$subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';
		$mail->setBody($message);
		$sent = $mail->Send();
		return $sent;
	}
		
}