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
	/**
	 * Protected fields
	 **/
	var $_session    	= null;
	
	function __construct()
	{
		$this->_session = JFactory::getSession();
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
  					$this->_session->set('bookingref',$row->ddcbookit_bookings_id);
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
					if(($this->data['status']=='2') Or ($this->data['status']=='1')){
						$sent = false;
						$sent = $this->_sendEmail();
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
				$viewName = $app->input->getWord('view', 'bookings');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
 
			}
			
			//display view
			return parent::execute();
		}
		else
		{
			$viewName = $app->input->getWord('view', 'dashboard');
			$app->input->set('layout','default');
			$app->input->set('view', $viewName);
			//display view
			return parent::execute();
		}
	}
	private function _sendEmail()
	{
		//save the new booking and send to customer
		$modelBooking = new DdcbookitModelsBookings();
  		$this->booking = $modelBooking->booking_request_mail();
  		$this->_session->clear('bookingref');
  		$params = JComponentHelper::getParams('com_ddcbookit');
  		
		$app = JFactory::getApplication();
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');
		$sitename	= $app->getCfg('sitename');
		$email2 	= (string)$params->get('second_email');
	
		$name		= (string)$this->booking[1];
		$email		= (string)$this->booking[2];
		$subject	= (string)$this->booking[3];
		$body		= (string)$this->booking[0];
	
		$mail = JFactory::getMailer();
		$mail->addRecipient(array($email,$mailfrom));
		$mail->addBCC($email2);
		$mail->addReplyTo(array($mailfrom, $fromname));
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject($sitename.': '.$subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';
		$mail->setBody($body);
		$sent = $mail->Send();
		return $sent;
	}
		
}