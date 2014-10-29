<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<div class="row-fluid">
	<div class="span4 well"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=residences'); ?>" ><?php echo JText::_('COM_DDCBOOKIT_MANAGER_RESIDENCE_EDIT')?></a></div>
	<div class="span4 well"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=proptypes'); ?>" ><?php echo JText::_('COM_DDCBOOKIT_MANAGER_PROPTYPE_EDIT')?></a></div>
	<div class="span4 well"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments'); ?>"><?php echo JText::_('COM_DDCBOOKIT_APARTMENTS_MANAGE')?></a></div>
</div>
<div class="row-fluid">
	<div class="span4 well"><?php echo JText::_('COM_DDCBOOKIT_CATEGORIES_MANAGE')?></div>
	<div class="span4 well"><?php echo JText::_('COM_DDCBOOKIT_CUSTOMERS_MANAGE')?></div>
	<div class="span4 well"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=bookings'); ?>"><?php echo JText::_('COM_DDCBOOKIT_BOOKINGS_MANAGE')?></a></div>
</div>