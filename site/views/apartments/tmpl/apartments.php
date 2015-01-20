<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
$params = JComponentHelper::getParams('com_ddcbookit');
$pc = explode(" ", $this->residence->post_code);
$pc1 = strtoupper(trim($pc[0]));
$services = explode(",",$this->residence->services);
?>


<div class="row-fluid">
<div class="span12" style="height:200px;">

  <!-- Wrapper for slides -->
  <div id="ddcresslideshow" class="span4">
	    <?php
	      define('IMAGEPATH', 'images/apartments/'.$this->residence->alias.'/');
	      $total_pics = count(glob(IMAGEPATH.'*'));
	      $images = array();
	      foreach(glob(IMAGEPATH.'*') as $filename){
			array_push($images, $filename);
	      	echo '<div>';
			echo '<img class="img-polaroid" style="min-width:89%;max-height:180px" src="'.$filename.'" />';
			echo '</div>';
	      }
		?>
	  </div>
	  <script type="text/javascript">
	  jQuery(document).ready(function(){
			jQuery("#ddcresslideshow > div:gt(0)").hide();
			
			setInterval(function() { 
			  jQuery('#ddcresslideshow > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(1000)
			    .end()
			    .appendTo('#ddcresslideshow');
			},  5000);
		});
	  </script>
	<div class="span8">
		<h2><?php echo strtoupper($this->residence->residence_name).' - '.strtoupper($this->residence->town).' '.$pc1; ?></h2>
		<p><?php echo $this->residence->address1 .', '.$this->residence->town .', '.strtoupper($this->residence->post_code); ?></p>
		<p></p>
	</div>
</div>
<div class="clearfix"></div>
<ul class="nav nav-tabs" role="tab-list">
<li class="active"><a href="#apartmentprices" data-toggle="tab"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PRICES'); ?></a></li>
<li><a href="#apartmentdetails" data-toggle="tab"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_DETAILS'); ?></a></li>
<li><a href="#location" onclick="codeAddress()" data-toggle="tab"><?php echo JText::_('COM_DDCBOOKIT_MAP'); ?></a></li>
</ul>
<div class="tab-content" style="display:block;">
<div id="apartmentprices" class="tab-pane active">
<div class="row-fluid">
<?php 
$rescheck = null;
$apartment_remove = array();
$app = JFactory::getApplication();
$session = JFactory::getSession();
$this->_ppl = $app->input->get('ppl',null);
if($app->input->get('datecheckin',null)==null){
$this->_checkin = $session->get('checkin');
}else{$this->_checkin = $app->input->get('datecheckin',null);}
if($app->input->get('datecheckout',null)==null){
$this->_checkout = $session->get('checkout');
}else{$this->_checkout = $app->input->get('datecheckout',null);}
?>
<?php if($this->_checkin==null): ?>
<div class="well ddcbookitsearchform">
	<div class="row-fluid">
		<form id="residencesearchForm" name="ddcbookitsearchform" class="residencesearchForm">
			<div class="span2"style="color:#ffffff;padding:3px;font-size:11px;"><?php echo 'Checkin date'; ?></div>
			<div class="span2">
				<?php echo JHTML::calendar('','datecheckin','datecheckin','%d-%m-%Y',array('class'=>'required validate-after-date afterElement:\'\'','placeholder'=>'dd-mm-yyyy'));?>
			</div>
			<div class="span2"style="color:#ffffff;padding:3px;font-size:11px;"><?php echo 'Checkout date'; ?></div>
			<div class="span2">
				<?php echo JHTML::calendar('','datecheckout','datecheckout','%d-%m-%Y',array('class'=>'required validate-after-date afterElement:\'datecheckinsearch\'','placeholder'=>'dd-mm-yyyy'));?>
			</div>
			<div class="span2">
				<input type="hidden" name="apartmentdatecheck" value="1">
			</div>
		</form>
	</div>
	<button onclick="checkdates()" class="btn validate">Search</button>
</div>
<?php endif; ?>

<table class="table table-striped">
	<thead>
		<tr style="background:#163bb2;color:#ffffff;">
			<th width="25%"><?php echo 'Apartment Type'; ?></th>
			<th width="12.5%"><?php echo 'Max Guests'; ?></th>
			<th width="30%"><?php echo 'Dates'; ?></th>
			<th width="17.5%"><?php echo 'Price'; ?></th>
			<th width="15%"><?php echo ''; ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	for($i=0;$i<count($this->apartments);$i++){
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
	$checkout = JHtml::date((time() + ($this->apartments[$i]->min_stay * 24 * 60 * 60)),"Y-m-d");
}
else
{
	$checkout = $this->_checkout;
}
	$ap = DdcbookitModelsDefault::apartment_price($this->apartments[$i]->ddcbookit_apartments_id,$checkin,$checkout);
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
					$max_guests = $this->apartments[$i]->max_guests;
					$min_stay = $this->apartments[$i]->min_stay;
					$proptype = $this->apartments[$i]->pt;
					$residence_id=$this->apartments[$i]->res_id;
					$category=$this->apartments[$i]->title;
					$bking = new DdcbookitModelsBooking;
					$bking = $bking->listItems($this->apartments[$i]->ddcbookit_apartments_id,$checkin,$checkout);
					
					?>
					<tr>
						<td><div class="pull-left" style="width:70px;margin-right:5px;overflow:hidden;"><img style="width:90%" class="img-rounded" src="<?php echo JRoute::_($this->apartments[$i]->thumbnail_image); ?>" width="50px" hspace="9" vspace="5" /></div><?php echo $proptype."<br>".$category; ?></td>
						<td style="text-align:center"><?php echo $max_guests; ?></td>
						<td class="datesok"><?php if($checkin!=null){echo JHtml::date($checkin,'d M Y').' to '.JHtml::date($checkout,'d M Y');}else{ echo JText::_('COM_DDCBOOKIT_MINIMUM_STAY').'<br> '.$min_stay.' '.JText::_('COM_DDCBOOKIT_NIGHTS');} ?></td>
						<td><p style="display:block; width:100%;text-align:right;margin: 0 0 2px" class="std_apartment_price"><span style="line-height:10px;font-size:10px;padding-left:5px;"><?php echo $pricetext; ?></span><br/> <span class="price"><?php echo '&pound; '.$partialprice; ?></span></p>
							<p class="std_apartment_price" style="text-align:right;line-height:12px;margin-top:5px;"><i><?php echo JText::_('COM_DDCBOOKIT_TOTAL_PRICE').": "; ?><?php echo '&pound; '.$totalprice."<br>".JText::_('COM_DDCBOOKIT_FOR')." ".$ap[1]." ".JText::_('COM_DDCBOOKIT_NIGHTS');?></i></p></td>
							<?php if($this->apartments[$i]->num_of_apartments>count($bking)):?>
						<?php if($this->_checkin!=null): ?><td><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$this->apartments[$i]->ddcbookit_apartments_id); ?>" class="btn btn-primary btn-book"><?php echo JText::_('COM_DDCBOOKIT_RESERVE'); ?></a></td><?php endif; ?>
						<?php if($this->_checkin==null): ?><td><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$this->apartments[$i]->ddcbookit_apartments_id).'&datecheckin='.$checkin.'&datecheckout='.$checkout; ?>" class="btn btn-primary btn-book"><?php echo JText::_('COM_DDCBOOKIT_RESERVE'); ?></a></td><?php endif; ?>
						<?php else: ?>
						<td class="no_apartments" style="text-align:center;"><?php if($checkin!=null): ?><?php echo JText::_('COM_DDCBOOKIT_NO_APARTMENTS');?><?php endif; ?></td>
						<?php endif;?>
					</tr>
					<?php
	}
	?>
	</tbody>
</table>

</div>
</div>
<div id="apartmentdetails" class="tab-pane">
<div class=" row-fluid">
	<div class="span12">
		<?php echo $this->residence->description; ?>
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
				<?php 
						$i++;	
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
	</div>
</div>
</div>
	<div id="location" class="tab-pane" style="height:450px;">
		<div id="map-canvas"></div>
	</div>
</div>

<script>
jQuery("#datecheckout_img").click(function(){
	jQuery("#datecheckout").val(jQuery("#datecheckin").val());
});
</script>


