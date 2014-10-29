<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$checkin = date_create($this->booking->checkin);
$checkout = date_create($this->booking->checkout);
$interval = date_diff($checkin, $checkout);
$days = $interval->format('%a');
$name= explode(' ', $this->booking->contact_name);
?>
<h3><?php echo 'Confirmation of your Booking'; ?></h3>
<p><?php echo 'Dear '.ucfirst($name[0]); ?></p>
<table class="table borderless">
			<tbody>
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
					<td><?php echo $this->booking->num_adults.' adults and '.$this->booking->num_kids.' kids';?></td>
				</tr>
				<tr>
					<th><?php echo 'Duration: '; ?></th>
					<td><?php echo '<span class="price_green">'.JHtml::date($this->booking->checkin,'d-M-Y').'</span> to <span class="price_green">'.JHtml::date($this->booking->checkout,'d-M-Y').'</span> ('.$days.' nights)';?></td>
				</tr>
				<tr>
					<th><?php echo 'Price: '; ?></th>
					<td><?php echo '&pound; '.number_format($this->booking->booked_price,2); ?></td>
				</tr>
			</tbody>
		</table>