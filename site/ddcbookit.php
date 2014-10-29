<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

//sessions
jimport( 'joomla.session.session' );
 
//load tables
JTable::addIncludePath(JPATH_COMPONENT.'/tables');

//load classes
JLoader::registerPrefix('Ddcbookit', JPATH_COMPONENT);

//Load plugins
//JPluginHelper::importPlugin('ddcbookit');
 
//Load styles and javascripts
DdcbookitHelpersStyle::load();

//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controller = $app->input->get('controller','default');

// Create the controller
$classname  = 'DdcbookitControllers'.ucwords($controller);
$controller = new $classname();
 
// Perform the Request task
$controller->execute();