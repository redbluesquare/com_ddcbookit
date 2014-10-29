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
			
			//display view
			return parent::execute();
		}
	}
		
}