<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=residences'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_STATUS'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_ID'); ?></th>
						<th width="40%"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_NAME'); ?></th>
						<th width="35%"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_NO_OF_APARTMENTS'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<?php echo JHtml::_('jgrid.published', $item->state, 'ddcbookit_proptypes'); ?>
        				</td>
                		<td>
                	        <?php echo $item->ddcbookit_residence_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=residences&layout=edit&residence_id='.$item->ddcbookit_residence_id); ?>"><?php echo $item->residence_name; ?></a>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->num_apartments; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="residences" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>