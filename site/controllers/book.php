<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbookitControllersBook extends DdcbookitControllersDefault {
	
	private $data = Null;

	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$table = $app->input->get('table',null);
		
		if(isset($table)){
		if($table=='booking_payment')
		{
			$modelName  = $app->input->get('models', 'booking');
			$modelName  = 'DdcbookitModels'.ucwords($modelName);
			$model = new $modelName();
			if($row = $model->booking_payment())
			{
				$return['success'] = true;
				
				$viewName = $app->input->getWord('view', 'Apartments');
				$app->input->set('layout','booksummary');
				$app->input->set('view', 'apartments');
			}
			else 
			{
				$viewName = $app->input->getWord('view', 'bookings');
				$app->input->set('layout','default');
				$app->input->set('view', 'bookings');

				// Add a message to the message queue
				$app->enqueueMessage(JText::_('COM_DDCBOOKIT_ENTER_ALL_REQUIRED_FIELDS'), 'error');
			}
			return parent::execute();
		}
		
		if($table=='booking')
		{
			$modelName  = $app->input->get('models', 'booking');
			$modelName  = 'DdcbookitModels'.ucwords($modelName);
			$model = new $modelName();
			
			if( $row = $model->storebooking() )
			{
				$sent = false;
				$sent = $this->_sendRequestEmail();
				$return['success'] = true;
				$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				
				$viewName = $app->input->getWord('view', 'apartments');
				$app->input->set('layout','booksummary');
				$app->input->set('view', 'apartments');
			}
			else{
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				
				$viewName = $app->input->getWord('view', 'apartments');
				$app->input->set('layout','apartmentbook');
				$app->input->set('view', $viewName);
			}

		}
		//echo json_encode($return);
		}else 
		{
			$viewName = $app->input->getWord('view', 'residences');
			$app->input->set('layout','residence');
			$app->input->set('view', $viewName);
		}
		return parent::execute();
		
	}
	
	
	
	private function _sendRequestEmail()
	{
		//save the new booking and send to customer
		$modelBooking = new DdcbookitModelsBooking();
  		$this->booking = $modelBooking->booking_request_mail();
  		$params = JComponentHelper::getParams('com_ddcbookit');
  		
		$app = JFactory::getApplication();
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');
		$sitename	= $app->getCfg('sitename');
		$email2 = (string)$params->get('second_email');
	
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
