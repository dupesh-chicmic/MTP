function makeSublist(parent,child,isSubselectOptional,childVal,rodzicTego,fieldToUpdate)
{
    var parentValue = $('#'+parent).attr('value');
    var OLDparentValue = $('#'+parent).attr('value');
   // var rodzicTegoparentValue = 0;
    //alert("rodzic:"+rodzicTego+" rodzicTegoparentValue"+rodzicTegoparentValue);
    if(parentValue == 0){
        if(isSubselectOptional) $('#'+child).prepend("<option value='0' selected='selected'> -- wybierz -- </option>");
        $('#'+child).trigger("change");
    }


	$("body").append("<select style='display:none' id='"+parent+child+"' size='7'></select>");
	$('#'+parent+child).html($("#"+child+" option"));

	var parentValue = $('#'+parent).attr('value');
	$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());

	childVal = (typeof childVal == "undefined")? "" : childVal;
	$("#"+child).val(childVal).attr('selected','selected');

	$('#'+parent).change(function(){
		var parentValue = $('#'+parent).attr('value');
		$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());
		if(isSubselectOptional) $('#'+child).prepend("<option value='none' selected='selected'> -- wybierz -- </option>");
		$('#'+child).trigger("change");
		//$('#'+child).focus();

                    var singleValues = $('#'+parent).attr('value');
                    $("#"+fieldToUpdate).val(singleValues);

                    if(parentValue == 'none'){
                        var rodzicTegoparentValue = $('#'+rodzicTego).attr('value');
                        //dodaj stary id
                        //var staryValue = OLDparentValue;

                        $("#"+fieldToUpdate).val(rodzicTegoparentValue); //bierze 1wszy ID z listy != none

                    }

	});

        $('#'+parent).focus(function(){
		var parentValue = $('#'+parent).attr('value');
		$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());
		if(isSubselectOptional) $('#'+child).prepend("<option value='none' selected='selected'> -- wybierz -- </option>");
		$('#'+child).trigger("change");
		//$('#'+child).focus();

                    var singleValues = $('#'+parent).attr('value');
                    $("#"+fieldToUpdate).val(singleValues);

                    if(parentValue == 'none'){
                        var rodzicTegoparentValue = $('#'+rodzicTego).attr('value');

                        $("#"+fieldToUpdate).val(rodzicTegoparentValue); //bierze 1wszy ID z listy != none

                    }
	});

//        $('#'+parent).click(function(){
//		var parentValue = $('#'+parent).attr('value');
////		$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());
////		if(isSubselectOptional) $('#'+child).prepend("<option value='none' selected='selected'> -- wybierz -- </option>");
////		$('#'+child).trigger("change");
////		$('#'+child).focus();
//
//                    var singleValues = $('#'+parent).attr('value');
//                    $("#CmsCategory_parent_cat").val(singleValues);
//
//                    if(parentValue == 'none'){
//                        //dodaj stary id
//                        //var staryValue = OLDparentValue;
//                        $("#CmsCategory_parent_cat").val(OLDparentValue); //bierze 1wszy ID z listy != none
//
//                    }
//	});



}