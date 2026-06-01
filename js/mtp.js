    function doActionsBeforeSend(){
        checkIsNumeric();
        fillCheckedAllCheckboxes();
        fillCustomValueGrp();
        fillCustomValueCoreCodenumber();
    }
    
    function checkIsNumeric() {
        var value = $("input[name=userGuideKm]").val();
        if(value != ""){
            if(!jQuery.isNumeric(value))
            {
                $("#odometerError").css("display","block");
                throw new Error("Kms value is not a number."); 
            } else {
                $("#odometerError").css("display","none");
                updateLinkToPdfFile(value);
            }
        } else {
            $("#odometerError").css("display","none");
            updateLinkToPdfFile("");
        }
    }
    
    function showAdjustedNotification() {
        $("#adjustedNotice").css("display","block");
        $("#adjustedNotice").animate({opacity: 1.0}, 2000).fadeOut("slow");
    }

    function updateLinkToPdfFile(newAdjustedValue) {
        if(newAdjustedValue == "") {
            newAdjustedValue = $("#defaultUserGuideKm").html();
        }
        //uncomment if you display the PDF link
        //var actualLink = $("#pdfByRegLookup").prop("href");
        //var newLink = actualLink.replace(/(userGuideKm=).*?(&grpCustomValeResult=)/,"$1" + newAdjustedValue + "$2");
        //$("#pdfByRegLookup").prop("href",newLink);
    }
    
    function fillCheckedAllCheckboxes() {
        var result = "";
        $('#associatedCarTable input:checked').each(function() {
            var checkboxId = $(this).prop('id');
             result += checkboxId + ',';
        });
        // all checkboxes put into form checkedAllCheckboxes field as string
        result = result.substring(0,result.length-1);
        $('#checkedAllCheckboxes').val(result);
        
        // update pdf link
        //var actualLink = $("#pdfByRegLookup").prop("href");
       // var newLink = actualLink.replace(/(checkedCheckboxes=).*?(&end=)/,"$1" + result + "$2");
       // $("#pdfByRegLookup").prop("href",newLink); 
    }
    
    function fillCustomValueGrp() {
        var grp = $('#grpCustomValeResult').html();
        $('#customValueGrp').val(grp);
        
        // update pdf link
        var actualLink = $("#pdfByRegLookup").prop("href");
        var newLink = actualLink.replace(/(grpCustomValeResult=).*?(&coreCodeNumber=)/,"$1" + grp + "$2");
        $("#pdfByRegLookup").prop("href",newLink);        
        
    }

    function fillCustomValueCoreCodenumber() {
        if($('#associatedCarTable input:checked').size() > 0) {
            var coreCodenumber = $('#associatedCarTable input:checked').get(0).name;
            coreCodenumber = coreCodenumber.substring(9,coreCodenumber.length);
            $('#coreCodenumberForCustomValue').val(coreCodenumber);
            
            // update pdf link
            var actualLink = $("#pdfByRegLookup").prop("href");
            var newLink = actualLink.replace(/(coreCodeNumber=).*?(&checkedCheckboxes=)/,"$1" + coreCodenumber + "$2");
            $("#pdfByRegLookup").prop("href",newLink);
        }
    }

$(document).ready(function() {
    $("#check_ri_field").keypress(function (e) {
        var key = e.which;
        if(key == 13) // the enter key code
        {
            $("#colorBoxLinkRegNumber").click();
            return false;
        }
    }); 
    $("#registation_no").keypress(function (e) {
        var key = e.which;
        if(key == 13) // the enter key code
        {
            $("#registation_no_button").click();
            return false;
        }
    });  
    
    $("#usedCarsMain").on({
        mouseenter: function () {
            $("#usedCarsSelect").css('display','none');
            $("#usedCarsCommSelect").css('display','none');
        },
        mouseleave: function () {
            $("#usedCarsSelect").css('display','none');
            $("#usedCarsCommSelect").css('display','none');
        }
    });
    
    $("#liUsedCars").on({
        mouseenter: function () {
            $("#usedCarsSelect").css('display','block');
            $("#liUsedCars").css("border-radius", 0);
            $("#liUsedCars").css("-webkit-border-radius", 0);
            $("#liUsedCars").css("-moz-border-radius", 0);
            
        },
        mouseleave: function () {
            $("#usedCarsSelect").css('display','none');
            $("#liUsedCars").css("border-bottom-left-radius", 5);
            $("#liUsedCars").css("-webkit-border-bottom-left-radius", 5);
            $("#liUsedCars").css("-moz-border-radius-bottomleft", 5);
        }
    });
    
    $("#liUsedCommCars").on({
        mouseenter: function () {
            $("#usedCarsCommSelect").css('display','block');
        },
        mouseleave: function () {
            $("#usedCarsCommSelect").css('display','none');
        }
    });
    
    $("#usedCarsSelect").on({
        mouseenter: function () {
            $("#liUsedCars").css('display','block');
        }
    });

    $("#usedCarsCommSelect").on({
        mouseenter: function () {
            $("#liUsedCommCars").css('display','block');
        }
    });   
});