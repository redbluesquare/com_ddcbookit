function residencesearch()
{
	var typeInfo = {};
	jQuery("#residencesearchForm :input").each(function(idx,ele){
		typeInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbookit',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log(typeInfo);
			if ( data.success ){
				jQuery("#residenceEntry").add(data.html);
			}else{
			}
		}
	});

}



function checkdates()
{
	var checkdatesInfo = {};
	jQuery(".residencesearchForm :input").each(function(idx,ele){
		checkdatesInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbookit&controller=apartmentcheck&format=raw&tmpl=component',
		type:'POST',
		data:checkdatesInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log('Hello');	

		}
	});
	setTimeout(
    	function() 
      {
      	location.reload();
      }, 0500); 
}



