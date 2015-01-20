<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Apartments Controller
 */
class DdcbookitControllersProptypes extends DdcbookitControllersDefault
{

	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		$this->data = $jinput->get('jform', array(),'array');
		
		
	if($this->data['table']=='proptypes')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='proptype.add')
			{
				$viewName = $app->input->getWord('view', 'proptypes');
    			$app->input->set('layout','edit');
    			$app->input->set('view', $viewName);
			}
			if($task=="proptype.save")
			{
				$modelName  = $app->input->get('models', 'proptypes');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
				$viewName = $app->input->getWord('view', 'proptypes');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			if($task=="proptype.cancel")
			{
				$viewName = $app->input->getWord('view', 'proptypes');
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