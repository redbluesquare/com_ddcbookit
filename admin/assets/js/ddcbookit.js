function addType()
{
	var typeInfo = {};
	jQuery("#addTypeForm :input").each(function(idx,ele){
		typeInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbookit&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log(typeInfo);
			if ( data.success ){
				jQuery("#addTypeModal").append(data.html);
				jQuery("#addTypeModal").modal('hide');
			}else{
			}
		}
	});

}
function addResidence()
{
	var typeInfo = {};
	jQuery("#addResForm :input").each(function(idx,ele){
		typeInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbookit&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log(typeInfo);
			if ( data.success ){
				jQuery("#addResidenceModal").append(data.html);
				jQuery("#addResidenceModal").modal('hide');
			}else{
			}
		}
	});
}
function addService()
{
	var typeInfo = {};
	jQuery("#addServiceForm :input").each(function(idx,ele){
		typeInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbookit&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log(typeInfo);
			if ( data.success ){
				jQuery("#addServiceForm").append(data.html);
				jQuery("#addServiceModal").modal('hide');
			}else{
			}
		}
	});

}

function addApartment()
{
	var typeInfo = {};
	jQuery("#addApartmentForm :input").each(function(idx,ele){
		typeInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbookit&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log(typeInfo);
			if ( data.success ){
				jQuery("#addApartmentModal").append(data.html);
				jQuery("#addApartmentModal").modal('hide');
			}else{
			}
		}
	});

}
