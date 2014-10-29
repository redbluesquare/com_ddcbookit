<div id="addApartmentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addApartmentModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_ADD'); ?></h3>
  </div>
  <div class="modal-body">
	<div class="row-fluid">
		<form id="addApartmentForm">
      		<div id="addapartment-modal-info" class="media"></div>
			<?php foreach($this->form->getFieldset('addapartment') as $field): ?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<div class="control-group span5">
					<div class="control-label">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
						<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
					</div>
					<div class="controls">
						<?php echo $field->input;?>
					</div>
				</div>
			<?php endif;?>
			<?php endforeach; ?>
			<?php foreach($this->form->getFieldset('addapartmain') as $field): ?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<div class="control-group span6">
					<div class="control-label">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
						<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
					</div>
					<div class="controls">
						<?php echo $field->input;?>
					</div>
				</div>
			<?php endif;?>
			<?php endforeach; ?>
			<input name="jform[residence_id]" id="jform_residence_id" value="<?php echo $this->residence->ddcbookit_residence_id; ?>" type="hidden" />
		</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDCBOOKIT_CANCEL'); ?></button>
    <button class="btn btn-primary" onclick="addApartment()"><?php echo JText::_('COM_DDCBOOKIT_ADD'); ?></button>
  </div>
</div>