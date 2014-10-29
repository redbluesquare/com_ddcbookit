<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');

?>
<form>
	<div class="row-fluid">
		<div width="5%">1</div>
		<div width="30%">2</div>
		<div class="span2">3</div>
		<div class="span2">4</div>
		<div class="span2">5</div>
		<div class="span2"><button class="btn"><?php echo JText::_("COM_DDCBOOKIT_SEARCH")." "; ?><i class="icon-search"></i></button></div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</form>


<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=prices'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="5%"><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_ID_LABEL'); ?></th>
						<th width="30%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_NAME_LABEL'); ?></th>
						<th width="7%"><?php echo JText::_('COM_DDCBOOKIT_MIN_DAYS_LABEL'); ?></th>
						<th width="7%"><?php echo JText::_('COM_DDCBOOKIT_MAX_DAYS_LABEL'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_START_DATE_LABEL'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_END_DATE_LABEL'); ?></th>
						<th width="8%"><?php echo JText::_('COM_DDCBOOKIT_PRICE'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr>
        				<td style="text-align:center;">
        					<?php echo $item->ddcbookit_apartment_price_id; ?>
        				</td>
                		<td style="text-align:left;">
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=prices&layout=edit&prices_id='.$item->ddcbookit_apartment_price_id); ?>"><?php echo $item->residence.', '.$item->proptype_title.', '.$item->category_title; ?></a>
                		</td>
                		<td style="text-align:center;">
                			<?php echo $item->min_days; ?>
                		</td>
                		<td style="text-align:center;">
                			<?php echo $item->max_days; ?>
                		</td>
                		<td style="text-align:left;">
                	        <?php echo JHtml::date($item->startdate,"d-m-Y"); ?>
                		</td>
                		<td style="text-align:left;">
                	        <?php echo JHtml::date($item->enddate,"d-m-Y"); ?>
                		</td>
                		<td style="text-align:center;">
                			<?php echo '&pound; '.number_format($item->price,2); ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="prices" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>