<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Residences Controller
 */
class DdcbookitControllersResidences extends DdcbookitControllersDefault
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = $app->input;
		$this->data = $jinput->get('jform', array(),'array');
		
		if($this->data['table']=='residences')
		{
			$task = $app->input->get('task', null );
			if($task=='residence.add')
			{
    			$viewName = $app->input->getWord('view', 'residences');
    			$app->input->set('layout','edit');
    			$app->input->set('view', $viewName);
    			
			}
			if($task=="residence.save")
			{
				$modelName  = $app->input->get('models', 'residences');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
     			$viewName = $app->input->getWord('view', 'residences');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);

			}
			if($task=="residence.cancel")
			{
				$viewName = $app->input->getWord('view', 'residences');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);

			}
			
			if($task=="residence.apply")
			{
				$modelName  = $app->input->get('models', 'residences');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();
				
				if( $row = $model->updatetable() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}
				$viewName = $app->input->getWord('view', 'residences');
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