<?php 
// No direct access
defined('_JEXEC') or die('Restricted access');
$services = explode(",",$this->residence->services);
$num_services=count($this->services);

?>
<div id="addServiceModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDCBOOKIT_ADD_SERVICES'); ?></h3>
  </div>
  <div class="modal-body">
	<div class="row-fluid">
		<form id="addServiceForm">
	      <div id="book-modal-info" class="media"></div>
	      	
	      <?php if($num_services==0){
	      			echo JText::_('COM_DDCBOOKIT_NO_SERVICES'); 
	      		}
	      		else{
					for($svce=0;$svce<$num_services;$svce++){?>
					<div class="row-fluid">
						<div class="span3">
							<select class="span12" name="<?php echo 'service'.$svce; ?>" id="<?php echo 'service'.$svce; ?>">
								<option value="<?php echo $this->services[$svce]->ddcbookit_services_id; ?>" 
									<?php if(in_array($this->services[$svce]->ddcbookit_services_id,$services)){echo 'selected="selected"';}?>>
									<?php echo JText::_('COM_DDCBOOKIT_YES'); ?></option>
								<option value="" 
									<?php if(!in_array($this->services[$svce]->ddcbookit_services_id,$services)){echo 'selected="selected"';}?>><?php echo JText::_('COM_DDCBOOKIT_No'); ?></option>
							</select>
						</div>
						<div class="span9"><?php echo $this->services[$svce]->service_name; ?></div>
					</div>
		<?php		}
				}
		?>
			</tbody>
	      </table>
	      <input type="hidden" name="residence_id" value="<?php echo $this->residence->ddcbookit_residence_id; ?>">
	      <input type="hidden" name="checkservice" value="1">
		</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDCBOOKIT_CLOSE'); ?></button>
    <button class="btn btn-primary" onclick="addService();"><?php echo JText::_('COM_DDCBOOKIT_ADD_SERVICES'); ?></button>
  </div>
</div>
