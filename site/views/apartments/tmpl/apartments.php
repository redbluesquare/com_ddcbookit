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

	<div class="offset1 span9">
		
	</div>
	<div class="clearfix"></div>
</div>
<div class="row-fluid">
<div class="span12" style="height:200px;">

  <!-- Wrapper for slides -->
  <div id="ddcresslideshow" class="span4 hidden-phone"  data-toggle="modal" data-target="#myModal">
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
<li><a href="#location" onclick="codeAddress()" data-toggle="modal" data-target="#mapModal"><?php echo JText::_('COM_DDCBOOKIT_MAP'); ?></a></li>
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

$checkin=$this->_checkin;
$checkout=$this->_checkout;
$this->_checkin = date_create($this->_checkin);
$this->_checkout = date_create($this->_checkout);
$interval = date_diff($this->_checkin, $this->_checkout);
$stayindays = $interval->format('%a');
if($stayindays>7)
{
	$sidays = 7;
	$timeframe = JText::_('COM_DDCBOOKIT_PRICE_PER_WEEK');
}
else
{
	$sidays = 1;
	$timeframe = JText::_('COM_DDCBOOKIT_PRICE_PER_NIGHT');
}
?>
<?php if($checkin==null): ?>
<div class="well ddcbookitsearchform">
	<div class="row-fluid">
		<form id="residencesearchForm" name="ddcbookitsearchform" class="residencesearchForm">
			<div class="span2"style="color:#ffffff;padding:3px;font-size:11px;"><?php echo 'Checkin date'; ?></div>
			<div class="span2">
				<?php echo JHTML::calendar('','checkin','checkin','%d-%m-%Y',array('class'=>'required validate-after-date afterElement:\'\'','placeholder'=>'dd-mm-yyyy'));?>
			</div>
			<div class="span2"style="color:#ffffff;padding:3px;font-size:11px;"><?php echo 'Checkout date'; ?></div>
			<div class="span2">
				<?php echo JHTML::calendar('','checkout','checkout','%d-%m-%Y',array('class'=>'required validate-after-date afterElement:\'datecheckinsearch\'','placeholder'=>'dd-mm-yyyy'));?>
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
		if(!in_array($this->apartments[$i]->ddcbookit_apartments_id, $apartment_remove)):
					$max_guests = $this->apartments[$i]->ppl;
					$proptype = $this->apartments[$i]->pt;
					$residence_id=$this->apartments[$i]->res_id;
					$price = $this->apartments[$i]->price;
					if($stayindays==0 || $stayindays == null){$stayindays=$this->apartments[$i]->min_stay;}
					$bking = new DdcbookitModelsBooking;
					$bking = $bking->listItems($this->apartments[$i]->ddcbookit_apartments_id,$checkin,$checkout);
					
					?>
					<tr>
						<td><img class="img-rounded" src="<?php echo JRoute::_($this->residence->image_thumb); ?>" width="25px" hspace="9" /><?php echo $proptype; ?></td>
						<td><?php echo $max_guests.' people'; ?></td>
						<td class="datesok"><?php if($checkin!=null){echo JHtml::date($checkin,'d M Y').' to '.JHtml::date($checkout,'d M Y');}?></td>
						<td><p style="display:block; width:100%;text-align:right;margin: 0 0 2px" class="std_apartment_price"><span style="line-height:10px;font-size:10px;padding-left:5px;"><?php echo $timeframe; ?></span><br/> <span class="price"><?php echo '&pound; '.number_format(($sidays*$price),2); ?></span></p>
							<p class="std_apartment_price" style="text-align:right;line-height:12px;margin-top:5px;"><i><?php echo JText::_('COM_DDCBOOKIT_TOTAL_PRICE').": "; ?><?php echo '&pound; '.number_format(($stayindays*$price),2)."<br>".JText::_('COM_DDCBOOKIT_FOR')." ".$stayindays." ".JText::_('COM_DDCBOOKIT_NIGHTS');?></i></p></td>
							<?php if($this->apartments[$i]->num_of_apartments>count($bking)):?>
						<td><?php if($checkin!=null): ?><a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$this->apartments[$i]->ddcbookit_apartments_id); ?>" class="btn btn-primary btn-book"><?php echo JText::_('COM_DDCBOOKIT_RESERVE'); ?></a><?php endif; ?></td>
						<?php else: ?>
						<td class="no_apartments" style="text-align:center;"><?php if($checkin!=null): ?><?php echo JText::_('COM_DDCBOOKIT_NO_APARTMENTS');?><?php endif; ?></td>
						<?php endif;?>
					</tr>
					<?php
		endif;
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
		<?php $num_services=count($this->services);
			  $cols = 2;
			  $rows = ceil($num_services/$cols);
			  $i = 0;
			  for($r=0;$r<$rows;$r++)
			  {
			  	echo '<tr>';
				for($svce=0;$svce<$cols;$svce++)
				{
					if($i<$num_services):
						if(in_array($this->services[$i]->ddcbookit_services_id,$services)): ?>
							<td><i class="icon-check"></i><?php echo ' '.$this->services[$i]->service_name; ?></td>
							<?php $i++;
						endif; ?>	
		<?php 		endif;
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

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="padding:10px;">
       	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
      	<div class="modal-body" id="location">
        	 <div id="map-canvas"></div>
  		</div>
	</div>
</div>
</div>
<script type="text/javascript">
var num=1;
<?php for($i=1;$i<$total_pics;$i++)
{
	echo 'img'.$i.'= new Image(); ';
	echo 'img'.$i.'.src = '.$images[$i].'; ';
}
?>
function slideshowUp()
{
	num=num+1
	if (num==<?php echo $total_pics-1; ?>)
	{num=1}
	document.mypic.src=eval("img"+num+".src")
}

function slideshowBack()
{
	num=num-1
	if (num==0)
	{<?php echo 'num='.$total_pics; ?>}
	document.mypic.src=eval("img"+num+".src")
}
</script>
		<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="padding:10px;">
       		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
      	<div class="modal-body">
      		<div id="slideclick">
			<?php for($i=0;$i<$total_pics-1;$i++)
			{
				echo '<div>';
				echo '<img class="img-polaroid" style="min-width:89%;max-height:90%" src="'.$images[$i].'" />';
				echo '</div>';

			}	
			?>
			<span class="slideback"><a href="JavaScript:slideshowBack()"> Back </a></span>

		<span class="slidenext"><a href="JavaScript:slideshowUp()"> Next </a></span>
			</div>

  		</div>
	</div>
</div>
</div>
