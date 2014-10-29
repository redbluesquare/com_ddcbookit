<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbookitControllersAdd extends JControllerBase {
	
	//private $data = Null;
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$checkservice = $app->input->get('checkservice',null);
		
		if($checkservice==1)
		{
			$modelName  = $app->input->get('models', 'residences');
			$modelName  = 'DdcbookitModels'.ucwords($modelName);
			
			$model = new $modelName();
			
			if ( $query = $model->addservice() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				//$return['html'] = DdcbookitHelpersView::getHtml($view, $layout, $item, $row);
			}else{
				$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_FAILURE');
			}
		}
		echo json_encode($return);
	}
		
}
