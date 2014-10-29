<?php
/**
 * @package     Joomla.Administrator
* @subpackage  com_ddcreports
*
* @copyright   Copyright (C) 2012 - 2013 Red Blure Square. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_ddcreports
 */
class DdcbookitTable_ extends JTable
{
	/**
	 * @param   JDatabaseDriver  A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__ddcbookit_types', 'type_id', $db);
	}
}