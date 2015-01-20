<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$checkin = date_create($this->booking->checkin);
$checkout = date_create($this->booking->checkout);
$interval = date_diff($checkin, $checkout);
$days = $interval->format('%a');
$params = JComponentHelper::getParams('com_ddcbookit');
$name= explode(' ', $this->booking->contact_name);
if($this->booking->booked_price==0)
{
	$booked_price = "TBC";
}else
{
	$booked_price = number_format($this->booking->booked_price,2);
}
if($this->booking->status==0)
{
	$booking_status = JText::_('COM_DDCBOOKIT_CANCELLED');
}
elseif($this->booking->status==1)
{
	$booking_status = JText::_('COM_DDCBOOKIT_REQUEST_PENDING');
}
elseif($this->booking->status==2)
{
	$booking_status = JText::_('COM_DDCBOOKIT_PAYMENT_DUE');
}
elseif($this->booking->status==3)
{
	$booking_status = JText::_('COM_DDCBOOKIT_CONFIRMED_COMPLETE');
}

?>
<h3><?php echo 'Confirmation of your Booking'; ?></h3>
<p><?php echo 'Dear '.ucfirst($name[0]); ?></p>
<div><?php echo $params->get('book_summary_request'); ?></div>
<table class="table borderless">
	<tbody>
		<tr>
			<th class="span3"><?php echo 'Booking Reference: '; ?></th>
			<td class="span9"><?php echo $this->booking->ddcbookit_bookings_id;?></td>
		</tr>
		<tr>
			<th class="span3"><?php echo 'Booking Status: '; ?></th>
			<td class="span9"><?php echo $booking_status;?></td>
		</tr>
		<tr>
			<th class="span3"><?php echo 'Contact Name: '; ?></th>
			<td class="span9"><?php echo $this->booking->contact_name;?></td>
		</tr>
		<tr>
			<th><?php echo 'Contact E-mail: '; ?></th>
			<td><?php echo $this->booking->contact_email;?></td>
		</tr>
		<tr>
			<th><?php echo 'Contact Telephone: '; ?></th>
			<td><?php echo $this->booking->contact_tel;?></td>
		</tr>
		<tr>
			<th><?php echo 'Apartment: '; ?></th>
			<td><span style="font-weight:bold;font-size:1.3em;color:#990099"><?php echo $this->booking->residence_name;?></span><br />
					<?php echo $this->booking->proptype_title;?></td>
		</tr>
		<tr>
			<th><?php echo 'Address: '; ?></td>
			<td><?php echo $this->booking->address1;?><br />
				<?php echo $this->booking->town;?><br />
				<?php echo $this->booking->post_code;?><br /></td>
		</tr>
		<tr>
			<th><?php echo 'Number of Guests: '; ?></th>
			<td><?php echo $this->booking->num_adults.' adults and '.$this->booking->num_kids.' children';?></td>
		</tr>
		<tr>
			<th><?php echo 'Duration: '; ?></th>
			<td><?php echo '<span class="price_green">'.JHtml::date($this->booking->checkin,'d-M-Y').'</span> to <span class="price_green">'.JHtml::date($this->booking->checkout,'d-M-Y').'</span> ('.$days.' nights)';?></td>
		</tr>
		<tr>
			<th><?php echo 'Price: '; ?></th>
			<td><?php echo '&pound; '.$booked_price; ?></td>
		</tr>
	</tbody>
</table>
<div><?php echo $params->get('terms_details_request'); ?></div>