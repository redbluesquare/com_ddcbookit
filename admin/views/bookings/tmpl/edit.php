<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('bootstrap.framework');
?>
<div class="span12">
	<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=bookings'); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_DDCBOOKIT_BOOKING_DETAILS' ); ?></legend>
                <div class="adminformlist">
					<div class="span9">
							<?php foreach($this->form->getFieldset('booking_top') as $field): ?>
								<?php if ($field->hidden):// If the field is hidden, just display the input.?>
									<?php echo $field->input;?>
								<?php else:?>
								<div class="span6">
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
								</div>
								<?php endif;?>
							<?php endforeach; ?>
						<div class="clearfix"></div>
					<div class="row-fluid">
						<div class="span6">
							<?php foreach($this->form->getFieldset('booking_main') as $field): ?>
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
						<div class="span6">
						<div class="row-fluid">
								<?php foreach($this->form->getFieldset('booking_dateinfo') as $field): ?>
								<?php if ($field->hidden):// If the field is hidden, just display the input.?>
									<?php echo $field->input;?>
								<?php else:?>
								<div class="span5">
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
								</div>
								<?php endif;?>
							<?php endforeach; ?>
							<div class="clearfix"></div>
							</div>
						</div>
						<div class="span6">
						<div class="row-fluid">
								<?php foreach($this->form->getFieldset('pplstaying') as $field): ?>
								<?php if ($field->hidden):// If the field is hidden, just display the input.?>
									<?php echo $field->input;?>
								<?php else:?>
								<div class="span5">
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
								</div>
								<?php endif;?>
							<?php endforeach; ?>
							<div class="clearfix"></div>
							</div>
						</div>
							<?php foreach($this->form->getFieldset('booking_resinfo') as $field): ?>
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
					</div>
					<div class="span3">
					<?php foreach($this->form->getFieldset('price') as $field): ?>
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
							<div>
								<p><span class="priceupdate"></span></p>
							</div>
				</div>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
	</div>
<<<<<<< HEAD
=======
<!-- 	<script> -->
// 	jQuery(document).ready(function(){
		
// 		//apartment check
// 		jQuery("#adminForm :input").on("blur change click",function(){
// 			if(jQuery("#jform_apartment_id").val()==""){
// 				jQuery(".priceupdate").html("Select an apartment").css("color","red");
// 			}
// 			else if(jQuery("#jform_checkin").val()==""){
				
// 				jQuery(".priceupdate").html("Enter a checkin date").css("color","red");
// 			}
// 			else if(jQuery("#jform_checkout").val()==""){
// 				jQuery(".priceupdate").html("Enter a checkout date").css("color","red");
// 			}
// 			else{
// 				var priceInfo = {};
// 				jQuery("#adminForm :input").each(function(idx,ele){
// 					priceInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
// 				});
>>>>>>> branch 'master' of https://github.com/redbluesquare/com_ddcbookit

<<<<<<< HEAD
=======
// 				jQuery.ajax({
// 					url:'index.php?option=com_ddcbookit&controller=bookings&format=raw&tmpl=component',
// 					type:'POST',
// 					data:priceInfo,
// 					dataType:'JSON',
// 					success:function(data)
// 					{

						
// 						if ( data.success ){
// 							jQuery(".priceupdate").html("");
// 							jQuery("#jform_booked_price").val(data.price);
// 						}
// 						//else{
// 						//}
// 					}
// 				});
				
// 			}
// 		});
		
// 	});
	</script>
>>>>>>> branch 'master' of https://github.com/redbluesquare/com_ddcbookit

