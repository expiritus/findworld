$(document).ready(function(){
    var country = $("#country");
    var city =  $("#city");
    var area = $("#area");
    var list_area = $("#list_area");
    var list_street = $("#list_street");
    var list_thing = $("#list_thing");
    var button_next = $("#button_next");
    var button_next2 = $("#button_next2");
    var street = $("#street");
    var thing = $("#thing");
    var custom_thing = $("#custom_thing");
    var image_thing = $("#image_thing");
    var description = $("#description");

    country.on('change', function(){
        city.empty();
        list_area.empty();
        var country_id = $("#country").val();
            city.hide();
            street.hide();
            button_next.hide();
            button_next2.hide();
            street.hide();
            thing.hide();
            image_thing.hide();
            custom_thing.hide();
            description.hide();
            city.show();
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
        street.val('');
        list_area.empty();
        var city_id = city.val();
        if(city_id == 0){
            area.hide();
            button_next.hide();
            button_next2.hide();
            street.hide();
            thing.hide();
            image_thing.hide();
            custom_thing.hide();
            description.hide();
        }else{
            area.show();
            button_next.show();
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

    button_next.on('click', function(){
        street.show();
        button_next.hide();
        button_next2.show();
        getStreet();
    });

    area.on('change', function(){
        getStreet();
    });

    button_next2.on('click', function(){
        thing.show().empty().append('<option value="0">choice thing</option>');
        custom_thing.val("");
        image_thing.show();
        custom_thing.show();
        description.show();
        button_next2.hide();
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
});