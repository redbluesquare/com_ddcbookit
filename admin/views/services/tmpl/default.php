<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=services'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_STATUS'); ?></th>
        				<th width="5%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_ID'); ?></th>
						<th width="40%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_SERVICE_NAME'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					
        				</td>
                		<td>
                	        <?php echo $item->ddcbookit_services_id; ?>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=services&layout=edit&service_id='.$item->ddcbookit_services_id); ?>"><?php echo $item->service_name; ?></a>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="services" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>