<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');

?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=proptypes'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="15%"><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_PUBLISHED_LABEL'); ?></th>
        				<th width="15%"><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_ID_LABEL'); ?></th>
						<th width="70%"><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_TITLE_LABEL'); ?></th>
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
                	        <?php echo $item->ddcbookit_proptype_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=proptypes&layout=edit&proptypes_id='.$item->ddcbookit_proptype_id); ?>"><?php echo $item->proptype_title; ?></a>
                		</td>
                		<td>
                	        <?php //echo JPATH_COMPONENT; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <?php //echo JPATH_COMPONENT_ADMINISTRATOR; ?>
        <div>
                <input type="hidden" name="jform[table]" value="proptypes" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>