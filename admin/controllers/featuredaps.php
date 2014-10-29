<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Apartments Controller
 */
class DdcbookitControllersFeaturedaps extends DdcbookitControllersDefault
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
		
		
		if($this->data['table']=='featuredaps')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='featured.add')
			{
    			
    			$app = JFactory::getApplication();
    			$link=  JRoute::_('index.php?option=com_ddcbookit&view=featuredaps&layout=edit&task=featured.add',FALSE);
    			
    			$app->redirect($link,true);
    			
			}
			if($task=="featured.save")
			{
				$modelName  = $app->input->get('models', 'featuredaps');
				$modelName  = 'DdcbookitModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
				}
				$mainframes = JFactory::getApplication();
				$link=  JRoute::_('index.php?option=com_ddcbookit&view=featuredaps',FALSE);
				
				$mainframes->redirect($link,true);
			}
			if($task=="featured.cancel")
			{
				$mainframes = JFactory::getApplication();
				$link=  JRoute::_('index.php?option=com_ddcbookit&view=featuredaps',FALSE);
				
				$mainframes->redirect($link,true);
			}
		}
	}
		
}