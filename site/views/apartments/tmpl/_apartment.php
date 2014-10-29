<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

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
	if(!in_array($this->apartments->ddcbookit_apartments_id, $apartment_remove)):
		if($rescheck==null){
			if($this->residence->ddcbookit_residence_id == $this->apartments->residence_name){
				$max_guests = $this->apartments->ppl;
				$proptype = $this->apartments->pt;
				$rescheck = $this->apartments->residence_name;
				$price = $this->apartments->apartment_price;
				if($stayindays==0 || $stayindays == null){$stayindays=$this->apartments->min_stay;}
			}
		}
	endif;

?>

<tr>
	<td><img class="img-rounded" src="<?php echo JRoute::_($this->residence->image_thumb); ?>" width="25px" hspace="9" /><?php echo $this->apartments->pt; ?></td>
	<td><?php echo $this->apartments->ppl.' people'; ?></td>
	<td><?php echo JHtml::date($this->_checkin,'d-M-Y'); ?></td>
	<td><span style="color:#088A4B;font-weight:bold;"><?php echo number_format(($stayindays*$price),2); ?></span></td>
</tr>