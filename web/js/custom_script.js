$(document).ready(function(){
    var country = $("#country");
    var city =  $("#city");
    var area = $("#area");
    var list_area = $("#list_area");
    var button_next = $("#button_next");
    var street = $("#street");
    var thing = $("#thing");

    country.on('change', function(){
        city.empty();
        list_area.empty();
        var country_id = $("#country").val();
        if(country_id == 0){
            city.hide();
            area.hide();
            button_next.hide();
        }else{
            city.show();
        }
        $.ajax({
            url: '/get_city/'+country_id,
            method: 'get',
            success: function(data){
                $(city).append("<option value='0'>Select city</option>");
                $.each(data, function(index, value){
                    $(city).append('<option value="'+value.id+'">'+value.city+'</option>')
                });

            }
        });
    });

    city.on("change", function(){
        area.val('');
        list_area.empty();
        var city_id = city.val();
        if(city_id == 0){
            area.hide();
            button_next.hide();
        }else{
            area.show();
        }

        $.ajax({
            url: '/get_area/'+city_id,
            method: 'get',
            success: function(data){
                $.each(data, function(index, value){
                    button_next.show();
                    $(list_area).append('<option value="'+value.area+'"></option>');

                });
            }
        });
    });

    button_next.on('click', function(){
        var area_name = area.val();
        var city_id = city.val();
        $.ajax({
            url: '/get_street',
            method: 'POST',
            data: {
                area_name: area_name,
                city_id: city_id
            },
            success: function(data){
                console.info(data);
            }
        });
    });
});