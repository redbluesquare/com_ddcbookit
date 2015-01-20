<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$item = null;
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=apartments'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_PUBLISHED_LABEL'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_ID_LABEL'); ?></th>
						<th width="15%" style="text-align: left;"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_NAME_LABEL'); ?></th>
						<th width="10%" style="text-align: left;"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PROPTYPES'); ?></th>
						<th width="10%" style="text-align: left;"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_CATEGORY'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_NO_OF_APARTMENTS'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_MIN_STAY_LABEL'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_NO_OF_BEDS'); ?></th>
						<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_HITS'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
        				<td style="text-align: center;">
        					<?php echo JHtml::_('jgrid.published', $item->state, $i); ?>
        				</td>
                		<td style="text-align: center;">
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=edit&apartment_id='.$item->ddcbookit_apartments_id); ?>"><?php echo $item->ddcbookit_apartments_id; ?></a>
                		</td>
                		<td>
                	        <?php echo $item->res_name; ?>
                		</td>
                		<td>
                	        <?php echo $item->proptype_title; ?>
                		</td>
                		<td>
                	        <?php echo $item->category_title; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->num_of_apartments; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->min_stay; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->num_of_beds; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->hits; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="apartments" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>