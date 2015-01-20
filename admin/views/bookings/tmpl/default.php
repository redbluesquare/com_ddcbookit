<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=bookings'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_BOOKING_STATUS'); ?></th>
        				<th width="10%" style="text-align:center;"><?php echo JText::_('COM_DDCBOOKIT_BOOKING_ID'); ?></th>
						<th width="20%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_BOOKING_NAME'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_CONTACT_NAME'); ?></th>
						<th width="8%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_NUM_GUESTS_LABEL'); ?></th>
						<th width="8%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_ID'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_CHECKIN'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_CHECKOUT'); ?></th>
						<th width="7%" style="text-align:right;"><?php echo JText::_('COM_DDCBOOKIT_PRICE'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<?php if($item->status==1){ echo 'Created';}elseif($item->status==2){echo 'Confirmed';}elseif($item->status==0){echo 'Cancelled';}elseif($item->status==3){echo '<a href="'.JRoute::_('index.php?option=com_ddcbookit&view=bookings&layout=payments&payment_id='.$item->ddc_payment_id).'">Payment Ready</a>';}elseif($item->status==4){echo '<a href="'.JRoute::_('index.php?option=com_ddcbookit&view=bookings&layout=payments&payment_id='.$item->ddc_payment_id).'">Payment Processed</a>';} ?>
        				</td>
                		<td style="text-align:center;">
                	        <?php echo $item->ddcbookit_bookings_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=bookings&layout=edit&booking_id='.$item->ddcbookit_bookings_id); ?>">
                	        	<?php echo $item->house_num.' '.$item->residence_name.', '.$item->proptype_title; ?>
                	        </a>
                	    </td>
                		<td>
                	        <?php echo $item->contact_name; ?></a>
                		</td>
                		<td>
                	        <?php echo $item->num_adults; ?></a>
                		</td>
                		<td>
                	        <?php echo $item->apartment_id; ?>
                		</td>
                		<td>
                	        <?php echo JHtml::date($item->checkin,'d-M-Y'); ?>
                		</td>
                		<td>
                	        <?php echo JHtml::date($item->checkout,'d-M-Y'); ?>
                		</td>
                		<td style="text-align:right">
                	        <?php echo number_format($item->booked_price,2); ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="bookings" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>