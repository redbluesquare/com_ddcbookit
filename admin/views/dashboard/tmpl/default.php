<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<div class="row-fluid">
	<div class="span2 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=residences'); ?>" ><img src="<?php echo JRoute::_("components/com_ddcbookit/assets/images/aldgateimage3.jpg")?>" class="img-polaroid" style="width:80px;" /><br> <?php echo JText::_('COM_DDCBOOKIT_MANAGER_RESIDENCE_EDIT')?></a></div>
	<div class="span2 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments'); ?>"><img src="<?php echo JRoute::_("components/com_ddcbookit/assets/images/bayswater15.jpg")?>" class="img-polaroid" style="width:80px;" /><br><?php echo JText::_('COM_DDCBOOKIT_APARTMENTS_MANAGE')?></a></div>
	<div class="span2 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=prices'); ?>" ><img src="<?php echo JRoute::_("components/com_ddcbookit/assets/images/pricing.png")?>" style="width:60px;" /><br><?php echo JText::_('COM_DDCBOOKIT_PRICES_MANAGE')?></a></div>
	<div class="span2 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=bookings'); ?>"><img src="<?php echo JRoute::_("components/com_ddcbookit/assets/images/calendar2.png")?>" style="width:80px;" /><br><?php echo JText::_('COM_DDCBOOKIT_BOOKINGS_MANAGE')?></a></div>
	<div class="span2 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=proptypes'); ?>" ><img src="<?php echo JRoute::_("components/com_ddcbookit/assets/images/proptype.png")?>" style="width:80px;" /><br><br><?php echo JText::_('COM_DDCBOOKIT_MANAGER_PROPTYPE_EDIT')?></a></div>
</div>