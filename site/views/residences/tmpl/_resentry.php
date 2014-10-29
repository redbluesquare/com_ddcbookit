<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
$pc = explode(" ", $this->residence->post_code);
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
foreach($this->booking as $item){
	if($this->residence->ddcbookit_residence_id == $item->residence_id){
		if($item->checkin!=null){
			if((($this->_checkin >= $item->checkin) 
				And ($this->_checkin < $item->checkout))
				Or (($this->_checkin < $item->checkin) 
				And ($this->_checkout > $item->checkin)
				And ($this->_checkout <= $item->checkout))
				Or (($this->_checkin < $item->checkin) 
				And ($this->_checkout > $item->checkin)
				And ($this->_checkout >= $item->checkout))
				Or (($this->_checkout > $item->checkin)
				And ($this->_checkout <= $item->checkout))){
				array_push($apartment_remove, $item->apart_id);
			}
		}
	}
}
$this->_checkin = date_create($this->_checkin);
$this->_checkout = date_create($this->_checkout);
$interval = date_diff($this->_checkin, $this->_checkout);
$stayindays = $interval->format('%a');
foreach($this->apartments as $apartment){
	if(!in_array($apartment->ddcbookit_apartments_id, $apartment_remove)):
		if($rescheck==null){
			if($this->residence->ddcbookit_residence_id == $apartment->residence_name){
				$max_guests = $apartment->ppl;
				$proptype = $apartment->pt;
				$rescheck = $apartment->residence_name;
				$price = checkprice($apartment->residence_name,$apartment->pt_id,$stayindays);
				if($stayindays==0 || $stayindays == null){$stayindays=$apartment->min_stay;}
			}
		}
	endif;
}
if($this->residence->max_guests>=$this->_ppl And $rescheck!=null):
?>
<div class="row-fluid" id="residenceEntry">
<?php if(isset($this->residence)){ ?>
<div class="span10">
	<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence->ddcbookit_residence_id;?>">
		<img class="img-circle pull-left" src="<?php echo JRoute::_($this->residence->image_thumb); ?>" width="120px" hspace="8" vspace="10" />
	</a>
	<h3 style="line-height:20px;">
		<a style="text-decoration:none;" href="index.php?option=com_ddcbookit&view=apartments&layout=apartments&residence_id=<?php echo $this->residence->ddcbookit_residence_id;?>">
			<?php echo strtoupper($this->residence->residence_name).' - '.strtoupper($this->residence->town).' '.$pc1;; ?>
		</a>
	</h3>
	<p>
	<?php echo 'Apartment Type: '.$proptype.'<br />Max Guests: '.$max_guests; ?>
	</p>
</div>
<div class="span2 pull-right">
<p class="std_apartment_price"><?php echo 'Price for '.$stayindays.' nights<br/>';?><span><?php echo '&pound; '; ?><?php echo number_format(($stayindays*$price),2); ?></span></p>
</div>
<div class="span2">
<button class="btn btn-primary pull-right"><?php echo 'Click To Book';?></button>
</div>
<?php } else { echo JText::_('COM_DDCBOOKIT_RESIDENCE_NONE'); } ?>
<div class="clearfix"></div>
</div>
<?php endif; ?>
