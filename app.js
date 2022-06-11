$('#linkver').on('click', function(){
    var link = $('#link').val();
    $.ajax(
        {
            type: "POST",
            url: 'backend.php',
            data: {'link':link},
            success: function (data)
                    {
                        $("#area").val(data);
                    },
        
        }
       );
});

