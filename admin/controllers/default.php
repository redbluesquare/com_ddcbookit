<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

class DdcbookitControllersDefault extends JControllerBase
{
  public function execute()
  {
  	// Get the application
  	$app = JFactory::getApplication();
  	
  	// Get the document object.
  	$document     = JFactory::getDocument();
  	
  	$viewName     = $app->input->getWord('view', 'dashboard');
  	$viewFormat   = $document->getType();
  	$layoutName   = $app->input->getWord('layout', 'default');
  	
  	$app->input->set('view', $viewName);
  	
  	// Register the layout paths for the view
  	$paths = new SplPriorityQueue;
  	$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/views/' . $viewName . '/tmpl', 'normal');
  	
  	$viewClass  = 'DdcbookitViews' . ucfirst($viewName) . ucfirst($viewFormat);
  	$modelClass = 'DdcbookitModels' . ucfirst($viewName);
  	
  	if (false === class_exists($modelClass))
  	{
  		$modelClass = 'DdcbookitModelsDefault';
  	}
  	
  	$view = new $viewClass(new $modelClass, $paths);
  	
  	$view->setLayout($layoutName);
  	
  	// Render our view.
  	echo $view->render();
  	

  	
  	return true;
  }

}