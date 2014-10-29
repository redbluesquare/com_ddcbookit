<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

for($q=0;$q<count($this->residence);$q++):
$pc = explode(" ", $this->residence[$q]->post_code);
$pc1 = strtoupper(trim($pc[0]));
$availibility = true;
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
$checkin = date_create($this->_checkin);
$checkout = date_create($this->_checkout);
$interval = date_diff($checkin, $checkout);
$stayindays = $interval->format('%a');
array_push($apartment_remove, DdcbookitModelsDefault::checkmybooking($this->residence[$q]->ddcbookit_apartment_id, $this->_checkin, $this->_checkout));

foreach($this->apartments as $apartment){
	if(!in_array($apartment->ddcbookit_apartments_id, $apartment_remove)):
	if($rescheck==null){
		if($this->residence[$q]->ddcbookit_residence_id == $apartment->residence_name){
			if($stayindays==0 || $stayindays == null){
				$stayindays=$apartment->min_stay;
			}
			$apartment_id = $apartment->ddcbookit_apartments_id;
			$max_guests = $apartment->ppl;
			$proptype = $apartment->pt;
			$rescheck = $apartment->residence_name;
			$price = DdcbookitModelsDefault::checkprice($apartment->residence_name,$apartment->pt_id,$stayindays);
		}
	}
	endif;
}
if($this->residence[$q]->min_stay>$stayindays){
	$rescheck=null;
}
if(($this->residence[$q]->max_guests>=$this->_ppl) And ($rescheck!=null)):
?>
	<div class="row-fluid" id="residenceEntry">
	<?php if(isset($this->residence[$q])){ ?>
		<div class="span10">
			<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence[$q]->ddcbookit_residence_id;?>">
				<img class="img-rounded pull-left" src="<?php echo JRoute::_($this->residence[$q]->image_thumb); ?>" width="120px" hspace="8" vspace="10" />
			</a>
			<h3 style="line-height:20px;">
			<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence[$q]->ddcbookit_residence_id;?>">
				<?php echo strtoupper($this->residence[$q]->residence_name).' - '.strtoupper($this->residence[$q]->town).' '.$pc1;; ?>
			</a>
			</h3>
			<p>
				<?php echo 'Apartment Type: '.$proptype.'<br />Max Guests: '.$max_guests; ?>
			</p>
		</div>
		<div class="span2 pull-right">
			<p class="std_apartment_price"><?php echo 'Price for '.$stayindays.' nights<br/>';?><span><?php echo '&pound; '; ?><?php echo number_format(($stayindays*$price),2); ?></span></p>
		<?php if($this->_checkin!=null):?>
			<a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=apartments&layout=apartmentbook&apartment_id='.$apartment_id); ?>" class="btn btn-primary pull-right"><?php echo JText::_('COM_DDCBOOKIT_CLICK_TO_BOOK');?></a>
		<?php endif; ?>
		</div>
	<?php } else { echo JText::_('COM_DDCBOOKIT_RESIDENCE_NONE'); } ?>
		<div class="clearfix"></div>
		</div>
	<?php endif; ?>
<?php endfor; ?>


