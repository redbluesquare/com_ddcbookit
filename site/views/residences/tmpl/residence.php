<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>

<?php 
$app = JFactory::getApplication();
$session = JFactory::getSession();
$this->_ppl = $app->input->get('ppl',null);
if($app->input->get('datecheckin',null)==null){
	$this->_checkin = $session->get('checkin');
}else{$this->_checkin = JHtml::date($app->input->get('datecheckin', null),"Y-m-d");}
if($app->input->get('datecheckout',null)==null){
	$this->_checkout = $session->get('checkout');
}else{$this->_checkout = JHtml::date($app->input->get('datecheckout', null),"Y-m-d");}
if($app->input->get('proptype',null)==null){
	$this->_proptype = $session->get('proptype');
}else{$this->_proptype = $app->input->get('proptype',null);}


$totalresidences = count($this->residence);
for($i=0; $i<$totalresidences; $i++){
$pc = explode(' ',$this->residence[$i]->post_code);
$pc1 = trim($pc[0]);
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
	$checkout = JHtml::date((time() + ($this->residence[$i]->min_stay * 24 * 60 * 60)),"Y-m-d");
}
else
{
	$checkout = $this->_checkout;
}
$ap = DdcbookitModelsDefault::apartment_price($this->residence[$i]->apart_id,$checkin,$checkout);
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
<div class="row-fluid" id="residenceEntry">
	<div class="span10">
		<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence[$i]->ddcbookit_residence_id;?>">
			<div class="img-rounded pull-left" style="width:120px;margin-right:5px;overflow:hidden;"><img class="img-rounded" style="width: 90%" src="<?php echo JRoute::_($this->residence[$i]->image_thumb); ?>" hspace="8" vspace="10" /></div>
		</a>
		<h3 style="line-height:20px;">
		<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence[$i]->ddcbookit_residence_id;?>">
			<?php echo strtoupper($this->residence[$i]->residence_name).' - '.strtoupper($this->residence[$i]->town).' '.$pc1; ?>
		</a>
		</h3>
		<p>
		<?php 
		if($this->residence[$i]->cat_title=="tube stations")
		{?>
			<img src="<?php echo JRoute::_('images/icon-underground.png'); ?>" style="width:20px" />
		<?php 
		}
		?>
			<?php echo $this->residence[$i]->poi_title; ?>
		</p>
	</div>
	<div class="span2 pull-right">
		<p class="std_apartment_price" style="line-height:12px;"><span class="pull-right" style="line-height:5px;font-size:10px;padding-left:5px;"><?php echo $pricetext; ?></span><br><span style="line-height:12px;" class="price pull-right"><?php echo '&pound; '.$partialprice; ?></span></p>
		<div class="clearfix"></div>
		<p class="std_apartment_price" style="text-align:right;line-height:12px;margin-top:5px;"><i style="font-size:12px;"><?php echo JText::_('COM_DDCBOOKIT_TOTAL_PRICE').": "; ?><?php echo '&pound; '.$totalprice."<br>".JText::_('COM_DDCBOOKIT_FOR')." ".$ap[1]." ".JText::_('COM_DDCBOOKIT_NIGHTS');?></i></p>
		<?php if($this->_checkin!=null):?>
			<a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$this->residence[$i]->apart_id); ?>" class="btn btn-primary pull-right"><?php echo JText::_('COM_DDCBOOKIT_CLICK_TO_BOOK');?></a>
		<?php endif; ?>
	</div>
</div>
<div class="clearfix"></div>
	
<?php 

}
?>