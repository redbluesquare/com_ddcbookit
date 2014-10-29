<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class DdcbookitHelpersView
{
	public static function load($viewName, $layoutName='default', $viewFormat='html', $vars=null)
	{
		// Get the application
		$app = JFactory::getApplication();

		$app->input->set('view', $viewName);

        // Register the layout paths for the view
	    $paths = new SplPriorityQueue;
	    $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');

	    $viewClass  = 'DdcbookitViews' . ucfirst($viewName) . ucfirst($viewFormat);
	    $modelClass = 'DdcbookitModels' . ucfirst($viewName);

	    if (false === class_exists($modelClass))
	    {
	      $modelClass = 'DdcbookitModelsDefault';
	    }

	    $view = new $viewClass(new $modelClass, $paths);

	    $view->setLayout($layoutName);

		if(isset($vars)) 
		{
			foreach($vars as $varName => $var) 
			{
				$view->$varName = $var;
			}
		}

		return $view;
	}
	function getHtml($view, $layout, $item, $data)
	{
		$objectView = DdcbookitHelpersView::load($view, $layout, 'phtml');
		$objectView->$item = $data;
	
		ob_start();
		echo $objectView->render();
		$html = ob_get_contents();
		ob_clean();
	
		return $html;
	}
}