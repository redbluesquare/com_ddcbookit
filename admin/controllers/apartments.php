<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Apartments Controller
 */
class DdcbookitControllersApartments extends DdcbookitControllersDefault
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
		
		
		if($this->data['table']=='apartments')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='apartment.add')
			{
				$viewName = $app->input->getWord('view', 'apartments');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
    			
			}
			if($task=="apartment.save")
			{
				$modelName  = $app->input->get('models', 'apartments');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
     			$viewName = $app->input->getWord('view', 'apartments');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			if($task=="apartment.cancel")
			{
     			$viewName = $app->input->getWord('view', 'apartments');
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
		
}