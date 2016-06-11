$(document).ready(function(){
    var country = $("#country");
    var custom_country = $("#custom_country");
    var custom_city = $("#custom_city");
    var city =  $("#city");
    var area = $("#area, #example_area");
    var list_city = $("#list_city");
    var list_area = $("#list_area");
    var list_street = $("#list_street");
    var list_thing = $("#list_thing");
    var button_next1 = $("#button_next1");
    var button_next2 = $("#button_next2");
    var button_next3 = $("#button_next3");
    var button_next4 = $("#button_next4");
    var street = $("#street, #example_street");
    var thing = $("#thing");
    var custom_thing = $("#custom_thing");
    var image_thing = $("#image_thing");
    var description = $("#description");


    function getCity(country_id){
        city.empty();
        list_area.empty();
        if(country_id == -1){
            custom_country.show();
            button_next1.show();
        }else if(country_id == 0){
            city.hide();
            area.hide();
            street.hide();
            button_next3.hide();
            button_next4.hide();
            street.hide();
            thing.hide();
            image_thing.hide();
            custom_thing.hide();
            description.hide();
        }else{
            city.show();
        }
        $.ajax({
            url: '/get_city/'+country_id,
            method: 'post',
            data: {
                'country_id': country_id,
                'country_name': country_id
            },
            success: function(data){
                city.append("<option value='0'>Select city</option><option value='-1'>Other city</option>");
                $.each(data, function(index, value){
                    city.append('<option value="'+value.id+'">'+value.city+'</option>');
                    list_city.append('<option value="'+value.city+'"></option>');
                });

            }
        });
    }

    country.on('change', function(){
        var country_id = country.val();
        list_city.empty();
        country_id = parseInt(country_id);
        getCity(country_id);
    });

    button_next1.on('click', function(){
        var custom_country_val = custom_country.val();
        if(custom_country_val.length == 0){
            return false;
        }else{
            var country_id = custom_country_val;
            getCity(country_id);
            button_next1.hide();
        }
    });

    custom_country.on('keyup', function(){
        var custom_country_value = custom_country.val();
        if(custom_country_value.length > 0){
            country.prop('disabled', true);
        }else{
            country.prop('disabled', false);
        }
    }).blur(function(){
        var custom_country_value = $(custom_country).val();
        if(custom_country_value.length > 0){
            country.prop('disabled', true);
        }else{
            country.prop('disabled', false);
        }
    });

    button_next2.on('click', function(){
        var custom_city_val = custom_city.val();
        if(custom_city_val.length == 0){
            return false;
        }else{
            button_next2.hide();
            custom_city.show();
            var city_id = custom_city_val;
            getArea(city_id);
        }
    });

    city.on("change", function() {
        var city_id = city.val();
        if(city_id > 0){
            list_city.empty();
            custom_city.hide();
        }
        getArea(city_id);
    });



    function getArea(city_id){
        area.val('');
        street.val('');
        list_area.empty();
        if(city_id == -1){
            area.hide();
            custom_city.show();
            button_next2.show();
            button_next3.hide();
            button_next4.hide();
        }else if(city_id == 0){
            area.hide();
            button_next3.hide();
            button_next4.hide();
            street.hide();
            thing.hide();
            image_thing.hide();
            custom_thing.hide();
            description.hide();
        }else{
            area.show();
            button_next3.show();
        }

        $.ajax({
            url: '/get_area/'+city_id,
            method: 'post',
            data:{
                'city_id': city_id,
                'city_name': city_id
            },
            success: function(data){
                $.each(data, function(index, value){
                    button_next3.show();
                    $(list_area).append('<option value="'+value.area+'"></option>');

                });
            }
        });
    }


    custom_city.on("keyup", function(){
        var custom_city_val = custom_city.val();
        if(custom_city_val.length > 0){
            city.prop('disabled', true);
        }else{
            city.prop('disabled', false);
        }
    }).blur(function(){
        var city_id = city.val();
        getArea(city_id);
    });

    function getStreet(){
        var area_name = area.val();
        var city_id = city.val();
        $.ajax({
            url: '/get_street',
            method: 'get',
            data: {
                area_name: area_name,
                city_id: city_id
            },
            success: function(data){
                list_street.empty();
                street.val('');
                $.each(data, function(index, value){
                    $(list_street).append('<option value="'+value.street+'"></option>');
                });
            }
        });
    }

    button_next3.on('click', function(){
        street.show();
        button_next3.hide();
        button_next4.show();
        getStreet();
    });

    area.on('change', function(){
        getStreet();
    });

    button_next4.on('click', function(){
        thing.show().empty().append('<option value="0">choice thing</option>');
        custom_thing.val("");
        image_thing.show();
        custom_thing.show();
        description.show();
        button_next4.hide();
        $.ajax({
            url: '/get_thing',
            method: 'get',
            success: function(data){
                $.each(data, function(index, value){
                    if(value.baseThing == true){
                        thing.append('<option value="'+value.id+'">'+value.thing+'</option>');
                    }
                    list_thing.append('<option value="'+value.thing+'"></option>');

                });
            }
        });
    });

    thing.on('change', function(){
        var value_thing = thing.val();
        custom_thing.val('');
        if(value_thing == 0){
            custom_thing.removeAttr('disabled');
        }else{
            custom_thing.attr('disabled', 'disabled');
        }
    });

    custom_thing.on('keyup', function(){
        var custom_thing_value = $(custom_thing).val();
        if(custom_thing_value.length > 0){
            thing.prop('disabled', true);
        }else{
            thing.prop('disabled', false);
        }
    });

    var lost_thing_id = $("#lost_section #lost_thing_id");
    $.each(lost_thing_id, function(index, value){
        var url = '/personal_area/search/lost/'+$(value).attr('value');
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'json',
            success: function(data){
                $(value).parent().find(".count_match").attr('href', url).text(data);
            }
        });
    });

    var find_thing_id = $("#find_section #find_thing_id");
    $.each(find_thing_id, function(index, value){
        var url = '/personal_area/search/find/'+$(value).attr('value');
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'json',
            success: function(data){
                $(value).parent().find(".count_match").attr('href', url).text(data);
            }
        });
    });
});