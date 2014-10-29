<?php
/**
 * @version     1.0.0
 * @package     com_blueb
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Darryl Usher <info@redbluesquare.co.uk> - http://www.redbluesquare.co.uk
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Ddcreports helper.
 */
class DdcbookitHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_DDCBOOKIT_TITLE_UNITS'),
			'index.php?option=com_ddcbookit&view=apartments',
			$vName == 'units'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_ddcbookit';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}