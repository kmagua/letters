
function getDataForm(url, header='<h3>Add Staff</h3>'){    
    $("#letters-sys-modal").modal('show');
    //console.log('here')
    //basePathWeb is defined in main.php layout file
    $('div#modalContent').html('<img src="' + basePathWeb + '/images/ajax-loader-blue.gif"/><p>Please wait ...</p>');
    //setTimeout(() => {  console.log("World!"); }, 5000);
    $.ajax({
        type: "GET",
        url: url,            
        success: function(result){
            //alert("huku ndani")
            $('#modalHeader').html(header);
            $('div#modalContent').html(result);
            //$( "#companystaff-dob" ).datepicker();
        },
        error:function(jqXHR){
            $('#modalHeader').html("Error Occured!");
            $('div#modalContent').html("<p style='color:red'>" + jqXHR.responseText + '</p>');
        }
    });
}

function saveDataForm(clickedButton, contentDivID='', tabToOpen = '', redirectUrl = ''){
    
    //console.log(clickedButton)
    var url = $(clickedButton.form).attr('action');
    var data = new FormData(clickedButton.form);
    //basePathWeb is defined in main.php layout file
    $('div#modalContent').html('<img src="' + basePathWeb + '/images/ajax-loader-blue.gif"/> <p>Please wait ...</p>');
    //console.log(data)
    //console.log(clickedButton.form.action)
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        contentType: false,       
        cache: false,             
        processData:false,
        success: function(result){
            if(contentDivID){
                $('div#' + contentDivID).html(result);
            }else{
                $('div#modalContent').html(result);
            }
            if(tabToOpen){
                $('.tabs-x  a[href="#' + tabToOpen + '"]').tab('show');
                $(".tabs-x").find("li.active a").click();
            }
            if(redirectUrl){
                $(location).attr('href', redirectUrl)
            }
        },
        error:function(jqXHR){
            $('#modalHeader').html("Error Occured!");
            $('div#modalContent').html("<p style='color:red'>" + jqXHR.responseText + '</p>');
        }
    });
}

function ajaxDeleteRecord(url, returnUrl,header){
    $.ajax({
        type: "POST",
        url: url,
        success: function(){
            $.ajax({
                type: "GET",
                url: returnUrl,
                success: function(result){
                    $('#modalHeader').html(header);
                    $('div#modalContent').html(result);
                },        
            });
        },        
    });
}

function navigateToTab(tabId){
    $('.tabs-x  a[href="#' + tabId + '"]').tab('show');
    $(".tabs-x").find("li.active a").click();
}

function hideShow(val, hide, clear){
    if( Number(val) == 1 ){
        $('div#'+hide).show('slow');
    }else{
        $('#'+clear).val('');
        $('div#'+hide).hide('slow');
    }  
}

function updateSession(val, path){
    $.ajax({
        type: "GET",
        url: path,
        data: {value:val},
        success: function(){
            location.reload();
        },        
    });
}

function  hideShowComment(val, model='devicecertificateapplication')
{
    if(val == 'Approved'){
        $('#' + model + '-rejection_comment').val('');
        $('div.field-' + model + '-rejection_comment').hide('slow');
    }else{
        $('div.field-' + model + '-rejection_comment').show('slow');
    }
}

function  hideShowRevocation(val, model='devicecertificateapplication')
{
    if(Number(val) != 4){
        $('#' + model + '-revocation_reason').val('');
        $('div.field-' + model + '-revocation_reason').hide('slow');
    }else{
        $('div.field-' + model + '-revocation_reason').show('slow');
    }
}