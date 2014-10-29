<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ddcbookit
 */

defined('_JEXEC') or die;

/**
 * Ddcbookit component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ddcbookit
 * @since       1.6
 */
class DdcbookitHelpersDdcbookit
{
	public static $extension = 'com_ddcbookit';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_ddcbookit';
		$level = 'component';

		$actions = JAccess::getActions('com_ddcbookit', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
	
	public static function addSubmenu($submenu)
	{
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENT_RESIDENCES'),
		'index.php?option=com_ddcbookit&view=residences', $submenu == 'residences');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENTS'),
		'index.php?option=com_ddcbookit&view=apartments', $submenu == 'apartments');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENT_PROPTYPES'),
		'index.php?option=com_ddcbookit&view=proptypes', $submenu == 'proptypes');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENT_CATEGORIES'),
		'index.php?option=com_categories&view=categories&extension=com_ddcbookit', $submenu == 'categories');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENT_PRICES'),
		'index.php?option=com_ddcbookit&view=prices', $submenu == 'prices');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENT_SERVICES'),
		'index.php?option=com_ddcbookit&view=services', $submenu == 'services');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_APARTMENT_BOOKINGS'),
		'index.php?option=com_ddcbookit&view=bookings', $submenu == 'bookings');
		JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_FEATURED_APARTMENTS'),
		'index.php?option=com_ddcbookit&view=featuredaps', $submenu == 'featured apartments');
		// set some global property
		$document = JFactory::getDocument();

		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_DDCBOOKIT_ADMINISTRATION_CATEGORIES'));
		}
	}
}