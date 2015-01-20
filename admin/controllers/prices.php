<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Apartments Controller
 */
class DdcbookitControllersPrices extends DdcbookitControllersDefault
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
		
		if(isset($this->data['table'])){
		if($this->data['table']=='prices')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='price.add')
			{
    			$viewName = $app->input->getWord('view', 'prices');
    			$app->input->set('layout','edit');
    			$app->input->set('view', $viewName);
			}
			if($task=="price.save")
			{
				$modelName  = $app->input->get('models', 'prices');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
     			$viewName = $app->input->getWord('view', 'prices');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
     
			}
			if($task=="price.cancel")
			{
				$viewName = $app->input->getWord('view', 'prices');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			if($task=="price.delete")
			{
				$modelName  = $app->input->get('models', 'prices');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();
				
				if( $row = $model->delete() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_DELETE_SUCCESS');
				}
				$viewName = $app->input->getWord('view', 'prices');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			if($task=="price.update")
			{
				if($app->input->get('search_text', null)==null)
				{
					$session = JFactory::getSession();
					$session->clear('searchtext');
				}
				if($app->input->get('startdate', null)==null)
				{
					$session = JFactory::getSession();
					$session->clear('startdate');
				}
				if($app->input->get('enddate', null)==null)
				{
					$session = JFactory::getSession();
					$session->clear('enddate');
				}
				$viewName = $app->input->getWord('view', 'prices');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
				
				$fileName = $_FILES["pricefile"]["name"];
				$fileTmpLoc = $_FILES["pricefile"]["tmp_name"];
				$fileType = $_FILES["pricefile"]["type"];
				$fileSize = $_FILES["pricefile"]["size"];
				$fileErrorMsg = $_FILES["pricefile"]["error"];
				
				if(!$fileTmpLoc){
					echo "Error, please first select a file!";
					//exit();
				}
				if(move_uploaded_file($fileTmpLoc, JRoute::_(JPATH_COMPONENT."/assets/uploads/$fileName"))){
					$return['msq'] = "$fileName has completed uploading.";
					
					$modelName  = $app->input->get('models', 'prices');
					$modelName  = 'DdcbookitModels'.ucwords($modelName);
					$model = new $modelName();
					if($rows = $model->uploadPrices())
						$return['msq'] = "Apartment prices have updated";
						$return['success'] = true;

				}else{
					echo "move_uploaded_file function failed";
				}
				
			}
			
			//display view
			return parent::execute();
		}
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
		
}