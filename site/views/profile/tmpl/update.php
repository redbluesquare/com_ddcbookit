<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcreports&controller=update'); ?>" method="post">

<input type="text" readonly name="check" value="ltak">
<input type="submit" name="submit" value="Submit">
</form>

<form action="<?php echo JRoute::_('index.php?option=com_ddcreports&controller=update'); ?>" method="post">

<input type="text" readonly name="check" value="ltap">
<input type="submit" name="submit" value="Submit">
</form>