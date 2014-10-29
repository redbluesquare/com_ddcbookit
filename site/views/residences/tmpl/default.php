<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<?php
if(isset($this->apartments)){
	$num_of_units = count($this->apartments);
	$i = 0;
	for($t=0;$t<$num_of_units;$t++){
        $this->_apartmentListView->apartments = $this->apartments[$i];
        $this->_apartmentListView->type = 'apartments';
        echo $this->_apartmentListView->render();
        $i++;
	}
}
?>