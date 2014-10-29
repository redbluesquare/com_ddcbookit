<div class="span12">
<?php if(isset($this->apartments)){ ?>
	<img class="img-circle pull-left" src="<?php echo JRoute::_($this->apartments->main_image); ?>" />
	<h2><small><?php echo $this->apartments->residence_name; ?></small></h2>
<?php } else { echo JText::_('COM_DDCREPORTS_TRANSFERS_NONE'); } ?>
</div>