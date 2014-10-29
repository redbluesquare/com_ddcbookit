<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');

$services = explode(",",$this->residence->services);
$app = JFactory::getApplication();
$session = JFactory::getSession();
$this->_ppl = $app->input->get('ppl',null);
if($app->input->get('datecheckin',null)==null){
	$this->_checkin = $session->get('checkin');
}else{$this->_checkin = $app->input->get('datecheckin',null);}
if($app->input->get('datecheckout',null)==null){
	$this->_checkout = $session->get('checkout');
}else{$this->_checkout = $app->input->get('datecheckout',null);}
$adults= $session->get('adults');
$kids= $session->get('kids');
$proptypes= $session->get('proptype');
$checkin = date_create($this->_checkin);
$checkout = date_create($this->_checkout);
$interval = date_diff($checkin, $checkout);
$stayindays = $interval->format('%a');
$price = DdcbookitModelsDefault::checkprice($this->apartments->res_id, $this->apartments->pt_id, $stayindays);
?>
<div class="row-fluid">
	<div class="span7">
		<img class="img-rounded pull-right" src="<?php echo JRoute::_($this->apartments->main_image,false); ?>" hspace="9" width="80px" />
		<h2><?php echo 'Apartment Booking'; ?></h2>
		<table width="80%">
			<tbody>
				<tr>
					<td width="33%"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_APARTMENT_NAME_LABEL').': ';?></td>
					<td><?php echo $this->apartments->res_name;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PROPTYPE_LABEL').': ';?></td>
					<td><?php echo $this->apartments->pt;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_CHECKIN').': ';?></td>
					<td style="font-weight:bold;"><?php echo JHTML::date($this->_checkin,'d-M-Y');?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_CHECKOUT').': ';?></td>
					<td style="font-weight:bold;"><?php echo JHTML::date($this->_checkout,'d-M-Y');?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_DURATION').': ';?></td>
					<td><?php echo $stayindays.' days';?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_NUM_ADULTS').': ';?></td>
					<td><?php echo $adults;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_NUM_KIDS').': ';?></td>
					<td><?php echo $kids;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PRICE').': ';?></td>
					<td style="font-weight:bold;color:#088A4B;"><?php echo '&pound; '.number_format(($stayindays*$price),2);?></td>
				</tr>
			</tbody>
		</table>
		<hr />
		<h3><?php echo JText::_('COM_DDCBOOKIT_SERVICES_AND_FACILITIES')?></h3>
		<table class="table"  style="font-size:11px;">
			<tbody>
		<?php $num_services=count($this->services);
			  $cols = 2;
			  $rows = ceil($num_services/$cols);
			  $i = 0;
			  for($r=0;$r<$rows;$r++)
			  {
			  	echo '<tr>';
				for($svce=0;$svce<$cols;$svce++)
				{
					if(in_array($this->services[$i]->ddcbookit_services_id,$services))
					{?>
						<?php if($i<$num_services):?>
							<td width="50%"><i class="icon-check"></i><?php echo ' '.$this->services[$i]->service_name; ?></td>
						<?php $i++;
						endif; ?>	
		<?php 		}
				}
				echo '</tr>';
			  }
		
		?>
			</tbody>
		</table>
	</div>
	<div class="span5">
	<h4><?php echo JText::_('COM_DDCBOOKIT_PERSONAL_DETAILS'); ?></h4>
		<form class="form-validate" id="addBookingForm" action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=book') ?>" method="post">
			<label id="labelcontact_name" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_CONTACT_NAME');?></label><input name="contact_name" type="text" value="" class="required" /><br />
			<label id="labelcontact_tel" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_CONTACT_TEL');?></label><input name="contact_tel" type="text" value=""  class="required" /><br />
			<label id="labelcontact_email" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_CONTACT_EMAIL');?></label><input name="contact_email" type="email" value=""  class="required" /><br />
			<label id="labelcompany" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_COMPANY');?></label><input name="company" type="text" value="" /><br />
			
			<span class="btn" data-toggle="collapse" data-target="#travdetails">Enter Travel Details</span><br />
			<div id="travdetails" class="collapse">
				<label id="labelflight" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_FLIGHT');?></label><input name="flight" type="text" value="" /><br />
				<label id="labelairport" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_AIRPORT');?></label><input name="airport" type="text" value="" /><br />
				<label id="labelarrival_time" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_ARRIVAL_TIME');?></label><input name="arrival_time" type="text" value="" /><br />
			</div>
			<label id="labelnotes" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_NOTES');?></label><textarea name="notes" cols="10" rows="5"></textarea><br />
			<label id="labelrepresentative" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_REPRESENTATIVE');?></label><input name="representative" type="text" value="" /><br />
			<label id="labeleuracom_source" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_EURACOM_SOURCE');?></label><input name="euracom_source" type="text" value="" /><br />
			<a href=""><label id="labelterms" for=""><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_TERMS');?></label></a>
			<select name="terms">
				<option value="0" selected="selected"><?php echo JText::_('COM_DDCBOOKIT_NO'); ?></option>
				<option value="1"><?php echo JText::_('COM_DDCBOOKIT_YES'); ?></option>
			</select> <br />
			<div style="display:none;"><?php echo JHTML::calendar($this->_checkin,'checkin','checkin','%Y-%m-%d');?></div>
			<div style="display:none;"><?php echo JHTML::calendar($this->_checkout,'checkout','checkout','%Y-%m-%d');?></div>
			<input name="num_adults" type="hidden" value="<?php echo $adults; ?>" /><br />
			<input name="num_kids" type="hidden" value="<?php echo $kids; ?>" />
			
			<input name="residence_id" type="hidden" value="<?php echo $this->apartments->residence_name; ?>" />
			<input name="booked_price" type="hidden" value="<?php echo number_format(($stayindays*$price),2); ?>" />
			<input name="user_id" type="hidden" value="<?php echo JFactory::getUser()->id;?>" />
			<input name="table" type="hidden" value="<?php echo 'booking';?>" />
			<input name="apartment_id" type="hidden" value="<?php echo $this->apartments->ddcbookit_apartments_id; ?>" />
			<button class="btn btn-primary validate"><?php echo JText::_('COM_DDCBOOKIT_CONFIRM_BOOKING'); ?></button><br />
		</form>
	</div>
</div>
