<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$app = JFactory::getApplication();
$resadd = $app->input->get('task',null);

ini_set('display_errors',1);
error_reporting(E_ALL);

?>
<div class="span12">
	<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=residences'); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_DDCBOOKIT_RESIDENCE_DETAILS' ); ?></legend>
                <div class="adminformlist">
					<div class="span9">
						<div class="span4">
							<?php foreach($this->form->getFieldset('res_left_top') as $field): ?>
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
						</div>
						<div class="span8">
							<?php foreach($this->form->getFieldset('res_left_top_name') as $field): ?>
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
						</div>
						<div class="clearfix"></div>
						<div class="span11">
							<?php foreach($this->form->getFieldset('res_left_main') as $field): ?>
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
						</div>
					</div>
					<div class="span3">
					<?php foreach($this->form->getFieldset('resside') as $field): ?>
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
					</div>
				</div>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="residence.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
	<?php if($resadd!='residence.add'):?>
	<a href="#addServiceModal" class="btn btn-success" data-toggle="modal" role="button" id="addServiceButton"><?php echo JText::_('COM_DDCBOOKIT_ADD_SERVICE'); ?></a>
	<?php //echo $this->_addserviceView->render(); ?>
	<?php endif; ?>
	<div></div>
</div>
