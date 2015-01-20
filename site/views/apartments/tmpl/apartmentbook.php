<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
$params = JComponentHelper::getParams('com_ddcbookit');
if ($this->apartments->state == 1)
{
	$bookheader = $params->get('book_confirmed');
	$terms = $params->get('terms_details_confirmed');
}
if ($this->apartments->state == 2)
{
	$bookheader = $params->get('request_booking');
	$terms = $params->get('terms_details_request');
}

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
if($this->_checkin==null)
{
	$checkin = JHtml::date("","Y-m-d");
}
else
{
	$checkin = $this->_checkin;
}
if($this->_checkout==null)
{
	$checkout = JHtml::date((time() + ($this->apartments->min_stay * 24 * 60 * 60)),"Y-m-d");
}
else
{
	$checkout = $this->_checkout;
}
$adults= $session->get('adults');
echo $adults."<br/>";
$children= $session->get('children');
$proptypes= $session->get('proptype');
	$ap = DdcbookitModelsDefault::apartment_price($this->apartments->ddcbookit_apartments_id,$checkin,$checkout);
	if($ap[2]==true)
	{
		$totalprice = $ap[0];
	}
	else
	{
		$totalprice = "POA";
	}


	if($ap[1] > 7)
	{
		$pricetext = JText::_('COM_DDCBOOKIT_PRICE_PER_WEEK');
		if($totalprice!="POA")
		{
			$partialprice = number_format($totalprice/$ap[1]*7,2);
			$totalprice = number_format($totalprice,2);
		}
		else
		{
			$partialprice=$totalprice;
		}
	}
	else
	{
		$pricetext = JText::_('COM_DDCBOOKIT_PRICE_PER_NIGHT');
		if($totalprice=="POA")
		{
			$partialprice=$totalprice;
		}
		else
		{
			$partialprice = number_format($totalprice/$ap[1],2);
			$totalprice = number_format($totalprice,2);
		}
	
	}	
?>
<div class="row-fluid">
	<div class="span7">
		<img class="img-rounded pull-right" src="<?php echo JRoute::_($this->apartments->main_image,false); ?>" hspace="9" width="80px" />
		<h2><?php echo $bookheader; ?></h2>
		<table width="80%">
			<tbody>
				<tr>
					<td width="33%"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_NAME_LABEL').': ';?></td>
					<td><?php echo $this->apartments->res_name;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_LABEL').': ';?></td>
					<td><?php echo $this->apartments->pt;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_CHECKIN').': ';?></td>
					<td style="font-weight:bold;"><?php echo JHTML::date($this->_checkin,'d-M-Y');?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_CHECKOUT').': ';?></td>
					<td style="font-weight:bold;"><?php echo JHTML::date($this->_checkout,'d-M-Y');?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_DURATION').': ';?></td>
					<td><?php echo $ap[1].' '.JText::_('COM_DDCBOOKIT_NIGHTS');?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_DDCBOOKIT_PRICE').': ';?></td>
					<td><span style="font-weight:bold;color:#088A4B;"><?php echo '&pound; '.$partialprice;?></span> <?php echo $pricetext; ?><br />
					<i><?php echo JText::_('COM_DDCBOOKIT_TOTAL_PRICE').": "; ?><?php echo '&pound; '.$totalprice;?></i></td>
				</tr>
			</tbody>
		</table>
		<hr />
		<h3><?php echo JText::_('COM_DDCBOOKIT_SERVICES_AND_FACILITIES')?></h3>
		<table class="table">
			<tbody>
		<?php $num_services=count($services);
			  $cols = 2;
			  $rows = ceil($num_services/$cols);
			  $i = 0;
			  for($r=0;$r<$rows;$r++)
			  {
			  	echo '<tr>';
				for($svce=0;$svce<$cols;$svce++)
				{
					if($i<$num_services): ?>
						<td><i class="icon-check"></i><?php echo ' '.$this->services[$services[$i]-1]->service_name; ?></td>
				<?php	$i++;	
					else:
						echo "<td></td>";
						$i++;
					endif;
				}
				echo '</tr>';
			  }
		
		?>
			</tbody>
		</table>
		<h3><?php echo JText::_('COM_DDCBOOKIT_TERMS'); ?></h3>
		<p><?php echo $terms; ?></p>
	</div>
	<div class="span5">
	<h4><?php echo JText::_('COM_DDCBOOKIT_PERSONAL_DETAILS'); ?></h4>
		<form class="form-validate" id="addBookingForm" action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=book') ?>" method="post">
			<label id="labelcontact_name" for=""><?php echo JText::_('COM_DDCBOOKIT_CONTACT_NAME');?></label><input name="contact_name" type="text" value="" class="required" /><br />
			<label id="labelcontact_tel" for=""><?php echo JText::_('COM_DDCBOOKIT_CONTACT_TEL');?></label><input name="contact_tel" type="text" value=""  class="required" /><br />
			<label id="labelcontact_email" for=""><?php echo JText::_('COM_DDCBOOKIT_CONTACT_EMAIL');?></label><input name="contact_email" type="email" value=""  class="required" /><br />
			<label id="labelcompany" for=""><?php echo JText::_('COM_DDCBOOKIT_COMPANY');?></label><input name="company" type="text" value="" /><br />
			<label id="labelcompany" for=""><?php echo JText::_('COM_DDCBOOKIT_NUM_ADULTS');?></label><select name="num_adults">
  					<?php if(($adults==0) Or (!isset($adults))){$adults=2;}
  					for($i=1;$i<9;$i++)
  					{
  						if($i==(int)$adults){$selected= "selected=\"selected\"";}else{$selected=null;}
  						echo "<option value=\"$i\" $selected >$i</option>";
  					}?>
				</select><br />
			<label id="labelcompany" for=""><?php echo JText::_('COM_DDCBOOKIT_NUM_CHILDREN');?></label><select name="num_children">
  					<?php if(($children==0) Or (!isset($children))){$children=0;}
  					for($i=0;$i<9;$i++)
  					{
  						if($i==(int)$children){$selected= "selected=\"selected\"";}else{$selected=null;}
  						echo "<option value=\"$i\" $selected >$i</option>";
  					}?>
				</select><br />
			
			<span class="btn" data-toggle="collapse" data-target="#travdetails">Enter Travel Details</span><br />
			<div id="travdetails" class="collapse">
				<label id="labelflight" for=""><?php echo JText::_('COM_DDCBOOKIT_FLIGHT');?></label><input name="flight" type="text" value="" /><br />
				<label id="labelairport" for=""><?php echo JText::_('COM_DDCBOOKIT_AIRPORT');?></label><input name="airport" type="text" value="" /><br />
				<label id="labelarrival_time" for=""><?php echo JText::_('COM_DDCBOOKIT_ARRIVAL_TIME');?></label><input name="arrival_time" type="text" value="" /><br />
			</div>
			<label id="labelnotes" for=""><?php echo JText::_('COM_DDCBOOKIT_NOTES');?></label><textarea name="notes" cols="10" rows="5"></textarea><br />
			<label id="labelrepresentative" for=""><?php echo JText::_('COM_DDCBOOKIT_REPRESENTATIVE');?></label><input name="representative" type="text" value="" /><br />
			<label id="labeleuracom_source" for=""><?php echo JText::_('COM_DDCBOOKIT_EURACOM_SOURCE');?></label><input name="euracom_source" type="text" value="" /><br />
			<a href="<?php echo $params->get('url_terms'); ?>" target="_BLANK"><label id="labelterms" for=""><?php echo JText::_('COM_DDCBOOKIT_TERMS');?></label></a>
			<select name="terms">
				<option value="0" selected="selected"><?php echo JText::_('COM_DDCBOOKIT_NOT_ACCEPT'); ?></option>
				<option value="1"><?php echo JText::_('COM_DDCBOOKIT_ACCEPT'); ?></option>
			</select> <br />
			<div style="display:none;"><?php echo JHTML::calendar($this->_checkin,'checkin','checkin','%Y-%m-%d');?></div>
			<div style="display:none;"><?php echo JHTML::calendar($this->_checkout,'checkout','checkout','%Y-%m-%d');?></div>
			<input name="booked_price" type="hidden" value="<?php echo $totalprice; ?>" />
			<input name="user_id" type="hidden" value="<?php echo JFactory::getUser()->id;?>" />
			<input name="table" type="hidden" value="<?php echo 'booking';?>" />
			<input name="apartment_id" type="hidden" value="<?php echo $this->apartments->ddcbookit_apartments_id; ?>" />
			<button class="btn btn-primary validate"><?php echo JText::_('COM_DDCBOOKIT_CONFIRM_BOOKING'); ?></button><br />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>
