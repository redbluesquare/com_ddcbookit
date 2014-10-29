<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbookitControllersApartmentcheck extends JControllerBase {
	
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$data = $data ? $data : JRequest::get('post');
		
		if($data['apartmentdatecheck']=='1')
		{
			$modelName  = $app->input->get('models', 'apartments');
			$view       = $app->input->get('view', 'apartments');
			$layout     = $app->input->get('layout', 'apartments');
			$item       = $app->input->get('item', 'residence');
			$modelName  = 'DdcbookitModels'.ucwords($modelName);
			
			$model = new $modelName();
			
			if ( $row = $model->listItems() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
			}else{
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
			}
		}
		if($data['table']=='residences')
		{
			$modelName  = $app->input->get('models', 'residence');
			$view       = $app->input->get('view', 'apartments');
			$layout     = $app->input->get('layout', 'residence');
			$item       = $app->input->get('item', 'residence');
			$modelName  = 'DdcbookitModels'.ucwords($modelName);
				
			$model = new $modelName();
				
			if ( $row = $model->store() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				$return['html'] = DdcbookitHelpersView::getHtml($view, $layout, $item, $row);
			}else{
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
			}
		}
		echo json_encode($return);
	}
		
}
