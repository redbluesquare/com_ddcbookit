<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>

<?php 
//$apartment_remove = array();
$app = JFactory::getApplication();
$session = JFactory::getSession();
$this->_ppl = $app->input->get('ppl',null);
if($app->input->get('datecheckin',null)==null){
	$this->_checkin = $session->get('checkin');
}else{$this->_checkin = JHtml::date($app->input->get('datecheckin', null),"Y-m-d");}
if($app->input->get('datecheckout',null)==null){
	$this->_checkout = $session->get('checkout');
}else{$this->_checkout = JHtml::date($app->input->get('datecheckout', null),"Y-m-d");}
if($app->input->get('location',null)==null){
	$this->_location = $session->get('location');
}else{$this->_location = $app->input->get('location',null);}
if($app->input->get('proptype',null)==null){
	$this->_proptype = $session->get('proptype');
}else{$this->_proptype = $app->input->get('proptype',null);}
$checkin = date_create($this->_checkin);
$checkout = date_create($this->_checkout);
$interval = date_diff($checkin, $checkout);
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

$totalresidences = count($this->residence);
for($i=0; $i<$totalresidences; $i++){
$pc = explode(' ',$this->residence[$i]->post_code);
$pc1 = trim($pc[0]);
$price = 454;
if($stayindays==0 || $stayindays==null){
	$stayindays=$this->residence[$i]->min_stay;
	}
?>
<div class="row-fluid" id="residenceEntry">
	<div class="span10">
		<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence[$i]->ddcbookit_residence_id;?>">
			<img class="img-rounded pull-left" src="<?php echo JRoute::_($this->residence[$i]->image_thumb); ?>" width="120px" hspace="8" vspace="10" />
		</a>
		<h3 style="line-height:20px;">
		<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence[$i]->ddcbookit_residence_id;?>">
			<?php echo strtoupper($this->residence[$i]->residence_name).' - '.strtoupper($this->residence[$i]->town).' '.$pc1; ?>
		</a>
		</h3>
		<p>
			<?php echo 'Apartment Type: '.$this->residence[$i]->pt.'<br />Max Guests: '.$this->residence[$i]->ppl; ?>
		</p>
	</div>
	<div class="span2 pull-right">
		<p class="std_apartment_price"><span class="pull-right" style="line-height:10px;font-size:10px;padding-left:5px;"><?php echo $timeframe; ?></span> <span class="price pull-right"><?php echo '&pound; '.number_format(($sidays*$this->residence[$i]->price),2); ?></span></p>
		<div class="clearfix"></div>
		<p class="std_apartment_price" style="text-align:right;line-height:12px;margin-top:5px;"><i style="font-size:12px;"><?php echo JText::_('COM_DDCBOOKIT_TOTAL_PRICE').": "; ?><?php echo '&pound; '.number_format(($stayindays*$this->residence[$i]->price),2)."<br>".JText::_('COM_DDCBOOKIT_FOR')." ".$stayindays." ".JText::_('COM_DDCBOOKIT_NIGHTS');?></i></p>
		<?php if($this->_checkin!=null):?>
			<a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$this->residence[$i]->apart_id); ?>" class="btn btn-primary pull-right"><?php echo JText::_('COM_DDCBOOKIT_CLICK_TO_BOOK');?></a>
		<?php endif; ?>
	</div>
</div>
<div class="clearfix"></div>
	
<?php 
$stayindays = $interval->format('%a');
}
?>