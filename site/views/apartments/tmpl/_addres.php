<div id="addResidenceModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_ADD'); ?></h3>
  </div>
  <div class="modal-body">
	<div class="row-fluid">
		<form id="addResForm">
      		<div id="addresidence-modal-info" class="media"></div>
			<?php foreach($this->form->getFieldset('addres') as $field): ?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<div class="control-group">
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
		</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDCBOOKIT_CANCEL'); ?></button>
    <button class="btn btn-primary" onclick="addResidence()"><?php echo JText::_('COM_DDCBOOKIT_ADD'); ?></button>
  </div>
</div>