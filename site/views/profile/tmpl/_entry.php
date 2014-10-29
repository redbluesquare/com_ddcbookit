<tr>
<?php if(isset($this->lead)){?>
<td><small><?php echo $this->lead->project_title; ?></small></td>
<td><small><?php echo JHtml::_('date', $this->lead->duedate, $format = 'd-M-Y' ); ?></small></td>
<td><small><?php echo $this->lead->quotes." / ".$this->lead->noofquotes; ?></small></td>
<?php } else { echo JText::_('COM_DEVCLOUD_LEAD_NONE'); } ?>
</tr>