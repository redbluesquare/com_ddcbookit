<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');

$pc = explode(" ", $this->residence->post_code);
$pc1 = strtoupper(trim($pc[0]));
$services = explode(",",$this->residence->services);
?>
<div class="row-fluid">

	<div class="offset1 span9">
		
	</div>
	<div class="clearfix"></div>
</div>
<div class="row-fluid">
<div class="span12">
<?php



?>
  <!-- Wrapper for slides -->
  <div id="ddcresslideshow" class="span4 hidden-phone">
	    <?php
	      define('IMAGEPATH', 'images/apartments/'.$this->residence->alias.'/');
	      foreach(glob(IMAGEPATH.'*') as $filename){
	      	echo '<div>';
			echo '<img class="img-polaroid" style="min-width:89%;max-height:90%" src="'.$filename.'" />';
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
	<span class="btn btn-warning pull-right resbtn" data-toggle="collapse" data-target="#resdetails">View details</span><br />
</div>
	<div id="resdetails" class="collapse row-fluid">
	<div class="span12">
		<?php echo $this->residence->description; ?>
		<h3><?php echo JText::_('COM_DDCBOOKIT_SERVICES_AND_FACILITIES')?></h3>
		<table class="table">
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
							<td><i class="icon-check"></i><?php echo ' '.$this->services[$i]->service_name; ?></td>
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
</div>
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

$checkin=$this->_checkin;
$checkout=$this->_checkout;
$this->_checkin = date_create($this->_checkin);
$this->_checkout = date_create($this->_checkout);
$interval = date_diff($this->_checkin, $this->_checkout);
$stayindays = $interval->format('%a');
?>
<?php if($checkin==null): ?>
<div class="well ddcbookitsearchform">
	<div class="row-fluid">
		<form id="residencesearchForm" name="ddcbookitsearchform" class="residencesearchForm">
			<div class="span2"style="color:#ffffff;padding:3px;font-size:11px;"><?php echo 'Checkin date'; ?></div>
			<div class="span2">
				<?php echo JHTML::calendar('','checkin','checkin','%Y-%m-%d',array('class'=>'required validate-after-date afterElement:\'\'',));?>
			</div>
			<div class="span2"style="color:#ffffff;padding:3px;font-size:11px;"><?php echo 'Checkout date'; ?></div>
			<div class="span2">
				<?php echo JHTML::calendar('','checkout','checkout','%Y-%m-%d',array('class'=>'required validate-after-date afterElement:\'datecheckinsearch\'',));?>
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
			<th width="35%"><?php echo 'Dates'; ?></th>
			<th width="12.5%"><?php echo 'Price'; ?></th>
			<th width="15%"><?php echo ''; ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($this->apartments as $apartment){
		if(DdcbookitModelsDefault::checkmybooking($apartment->ddcbookit_apartments_id, $this->_checkin, $this->_checkout)!=null){
			array_push($apartment_remove,DdcbookitModelsDefault::checkmybooking($apartment->ddcbookit_apartments_id, $this->_checkin, $this->_checkout));
		}
		if(!in_array($apartment->ddcbookit_apartments_id, $apartment_remove)):
				if(($this->featured->residence_id == $apartment->res_id) And ($this->featured->proptype_id == $apartment->pt_id)){
					
					$max_guests = $apartment->ppl;
					$proptype = $this->featured->proptype_title;
					$price = $this->featured->price;
					if($stayindays==0 || $stayindays == null){$stayindays=$this->featured->minstay;}
					?>
					<tr>
						<td><img class="img-rounded" src="<?php echo JRoute::_($this->residence->image_thumb); ?>" width="25px" hspace="9" /><?php echo $proptype; ?></td>
						<td><?php echo $max_guests.' people'; ?></td>
						<td class="datesok"><?php if($checkin!=null){echo JHtml::date($checkin,'d M Y').' to '.JHtml::date($checkout,'d M Y');}echo " (".$stayindays." nights)"?></td>
						<td><span style="color:#088A4B;font-weight:bold;"><?php echo number_format(($stayindays*$price),2); ?></span></td>
						<td><?php if($checkin!=null): ?><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$apartment->ddcbookit_apartments_id); ?>" class="btn btn-primary btn-book"><?php echo JText::_('COM_DDCBOOKIT_RESERVE'); ?></a><?php endif; ?></td>
					</tr>
					<?php
				}
		endif;
	}
	?>
	</tbody>
</table>
</div>