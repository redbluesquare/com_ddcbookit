<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

   <h3><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_PROPTYPES'); ?></h3>
   <?php $user =& JFactory::getUser();
		$groups = isset($user->groups) ? $user->groups : array();
		if(in_array(7,$groups)):?>
		
		<div>
		<a href="#addTypeModal" class="btn pull-right" data-toggle="modal" role="button" id="addButton"><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_ADD'); ?></a>
		</div>
		<table class="table">
			<thead>
				<tr>
					<td><?php echo JTEXT::_('COM_DDCBOOKIT_PROPTYPE_ID'); ?></td>
					<td><?php echo JTEXT::_('COM_DDCBOOKIT_PROPTYPE_TITLE'); ?></td>
					<td><?php echo JTEXT::_('COM_DDCBOOKIT_PROPTYPE_DESCRIPTION'); ?></td>
				</tr>
			</thead>
			<tbody>
				<?php
					$num_of_units = count($this->proptypes);
					$num_of_cols = 1;
					$unit_rows = ceil($num_of_units/$num_of_cols);
					$i = 0;
					for($t=0;$t<$unit_rows;$t++){
						for($e=0;$e<=$num_of_cols;$e++){
							if($i<$num_of_units){ 
						        $this->_proptypeListView->proptypes = $this->proptypes[$i];
						        $this->_proptypeListView->type = 'proptypes';
						        echo $this->_proptypeListView->render();
						        $i++;
							}
						}
					} 
				?>
			</tbody>
		</table>
		
	<?php endif; ?>
<?php if($this->profile->id==NULL):?>
	<p><?php echo JText::_('COM_DEVCLOUD_GUEST');?></p>
<?php endif; ?>

<?php echo $this->_addProptypesView->render(); ?>

