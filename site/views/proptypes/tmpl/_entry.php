<tr>
<?php if(isset($this->proptypes)){ ?>
<td><small><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=proptypes&layout=proptypes&ddcbookit_proptype_id='.$this->proptypes->ddcbookit_proptype_id);?>"><?php echo $this->proptypes->ddcbookit_proptype_id; ?></a></small></td>
<td><small><?php echo $this->proptypes->proptype_title; ?></small></td>
<td><small><?php echo $this->proptypes->proptype_description; ?></small></td>
<?php } else { echo JText::_('COM_DDCREPORTS_TRANSFERS_NONE'); } ?>
</tr>