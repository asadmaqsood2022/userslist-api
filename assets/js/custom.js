jQuery(function($) {
    $("html").on("click", ".view-detials", function() {
        var id = $(this).data('id');
        $.ajax({ 
          data: {
              action: 'get_user_details',
              id:id,
              nounce: $('[name="_wpnonce"]').val()
             },
          type: 'post',
          url:ajax_params.ajax_url,
          success: function(data) { 
              console.log(data.data); 
             jQuery("#show-details").html(data.data.message);
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) { 
            jQuery("#show-details").html("Status: " + textStatus);
        }   
        });
    });

          
});