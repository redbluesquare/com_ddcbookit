<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHTML::_('behavior.calendar');
$session = JFactory::getSession();
$searchtext = null;
$startdate = null;
$enddate = null;
if($session->get('searchtext')!=null)
{
	$searchtext = $session->get('searchtext');
}
if($session->get('startdate')!=null)
{
	$startdate = $session->get('startdate');
}
if($session->get('enddate')!=null)
{
	$enddate = $session->get('enddate');
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_ddcbookit&controller=prices'); ?>" method="post" name="adminForm" id="adminForm"  enctype="multipart/form-data">
	<div class="row-fluid">
		<div class="span2"><?php echo "<h2>Filters:</h2>"; ?></div>
		<div class="span2"><?php echo 'Apartment: '; ?><br><input type="text" name="search_text" class="span10" value="<?php echo $searchtext; ?>" /></div>
		<div class="span2"><?php echo 'Start Date: '; ?><br><?php echo JHTML::calendar($startdate,'startdate','startdate','%d-%m-%Y',array('placeholder'=>'dd-mm-yyyy', 'class'=>'span9')); ?></div>
		<div class="span2"><?php echo 'End Date: '; ?><br><?php echo JHTML::calendar($enddate,'enddate','enddate','%d-%m-%Y',array('placeholder'=>'dd-mm-yyyy', 'class'=>'span9')); ?></div>
		<div class="span2"><?php echo 'File Upload: '; ?><br><input name="pricefile" id="pricefile" type="file" /></div>
		<div class="span2"><br><button onclick="Joomla.submitbutton('price.update')" class="btn pull-right"><?php echo JText::_("COM_DDCBOOKIT_UPDATE")." "; ?><i class="icon-refresh"></i></button></div>
	</div>
	<table class="adminlist table">
    	<thead>
           	<tr>
           		<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_PROPTYPE_ID_LABEL'); ?></th>
				<th width="40%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_APARTMENT_NAME_LABEL'); ?></th>
				<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_MIN_DAYS_LABEL'); ?></th>
				<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_MAX_DAYS_LABEL'); ?></th>
				<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_START_DATE_LABEL'); ?></th>
				<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDCBOOKIT_END_DATE_LABEL'); ?></th>
				<th width="10%"><?php echo JText::_('COM_DDCBOOKIT_PRICE'); ?></th>
			</tr>
    	</thead>
        <tfoot>
			
        </tfoot>
        <tbody>
        <?php foreach($this->items as $i => $item): ?>
   			<tr>
   				<td style="text-align:center;">
   					<?php echo $item->ddcbookit_apartment_price_id; ?>
   				</td>
           		<td style="text-align:left;">
           	        <a href="<?php echo JRoute::_('index.php?option=com_ddcbookit&view=prices&layout=edit&prices_id='.$item->ddcbookit_apartment_price_id); ?>"><?php echo $item->residence.', '.$item->proptype_title.', '.$item->category_title; ?></a>
           		</td>
           		<td style="text-align:center;">
           			<?php echo $item->min_days; ?>
           		</td>
                		<td style="text-align:center;">
                			<?php echo $item->max_days; ?>
                		</td>
                		<td style="text-align:left;">
                	        <?php echo JHtml::date($item->startdate,"d-m-Y"); ?>
                		</td>
                		<td style="text-align:left;">
                	        <?php echo JHtml::date($item->enddate,"d-m-Y"); ?>
                		</td>
                		<td style="text-align:center;">
                			<?php echo '&pound; '.number_format($item->price,2); ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="prices" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>

<script>

		jQuery("#enddate_img").click(function(){
			jQuery("#enddate").val(jQuery("#startdate").val());
		});

</script>