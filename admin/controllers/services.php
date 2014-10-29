<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Residences Controller
 */
class DdcbookitControllersServices extends DdcbookitControllersDefault
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
		
		if($this->data['table']=='services')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='service.add')
			{
				$viewName = $app->input->getWord('view', 'services');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
			}
			if($task=="service.save")
			{
				$modelName  = $app->input->get('models', 'services');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
				$viewName = $app->input->getWord('view', 'services');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			if($task=="service.cancel")
			{
				$viewName = $app->input->getWord('view', 'services');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			//display the view.
			return parent::execute();
		}
	}
		
}