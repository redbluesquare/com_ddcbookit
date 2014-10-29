<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class DdcbookitHelpersStyle
{
	public static function load()
	{
		$document = JFactory::getDocument();

		//stylesheets
		$document->addStylesheet(JURI::base().'components/com_ddcbookit/assets/css/style.css');
		$document->addStyleSheet('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');

		//javascripts
		$document->addScript(JURI::base().'components/com_ddcbookit/assets/js/ddcbookit.js');

	}
}