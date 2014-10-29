<div id="addTypeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDCBOOKIT_TYPE_ADD'); ?></h3>
  </div>
  <div class="modal-body">
	<div class="row-fluid">
		<form id="addTypeForm">
      		<div id="addtype-modal-info" class="media"></div>
			<input type="text" name="proptype_title" placeholder="<?php echo JText::_('COM_DDCBOOKIT_TYPE_TITLE'); ?>" /><br />
      		<textarea class="span12" placeholder="<?php echo JText::_('COM_DDCBOOKIT_TYPE_DESCRIPTION'); ?>" name="proptype_description" rows="10"></textarea>
      		<input type="text" name="check" value="typecheck" />
      		<input type="text" name="table" value="proptypes" />
		</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDCBOOKIT_CANCEL'); ?></button>
    <button class="btn btn-primary" onclick="addType()"><?php echo JText::_('COM_DDCBOOKIT_ADD'); ?></button>
  </div>
</div>