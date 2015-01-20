<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$item = null;
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=featuredaps'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PUBLISHED_LABEL'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_ID'); ?></th>
						<th width="20%" style="text-align: left;"><?php echo JText::_('COM_DDCBOOKIT_RESIDENCE_NAME_LABEL'); ?></th>
						<th width="20%" style="text-align: left;"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PROPTYPES'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_START_DATE_LABEL'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_END_DATE_LABEL'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_PRICE_PER_NIGHT_LABEL'); ?></th>
						<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_MIN_STAY_LABEL'); ?></th>
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
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=featuredaps&layout=edit&featured_id='.$item->ddcbookit_featuredapartment_id); ?>"><?php echo $item->ddcbookit_featuredapartment_id; ?></a>
                		</td>
                		<td>
                	        <?php echo $item->residence_name; ?>
                		</td>
                		<td>
                	        <?php echo $item->proptype_title; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo JHtml::date($item->startdate,"d F Y"); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo JHtml::date($item->enddate,"d F Y"); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo "&pound; ".number_format($item->price,2); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->min_stay; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="featuredaps" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>