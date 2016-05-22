$(document).ready(function(){
    var country = $("#country");
    var city =  $("#city");
    var area = $("#area, #example_area");
    var list_area = $("#list_area");
    var list_street = $("#list_street");
    var list_thing = $("#list_thing");
    var button_next = $("#button_next");
    var button_next2 = $("#button_next2");
    var street = $("#street, #example_street");
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


    var form_url = "";
    $(document).on('click', "#greetings a, .popup .login_link, .popup .register_link", function(){
        if($(this).is(".login_link")){
            $('.dynamic_form').load('/login form', function(){
                $(".popup_opacity_layer").show();
                form_url = $(".dynamic_form form").attr('action');
            });
            return false;
        }else if($(this).is(".register_link")){
            $(".dynamic_form").load("/register form", function(){
                $(".popup_opacity_layer").show();
                form_url = $(".dynamic_form form").attr('action');
            });
            return false;
        }else if($(this).is(".forgot_password_link")){
            $(".dynamic_form").load("/resetting/request form", function(){
                $(".popup_opacity_layer").show();
                form_url = $(".dynamic_form form").attr('action');
            });
            return false;
        }
    });

    $(document).on('click', '#_submit', function(){
        var csrf_token = $(".dynamic_form input[type='hidden']").val();
        var user_name = $("#username").val();
        var password = $("#password").val();
        var remember_me = $("#remember_me").val();
        $.ajax({
            url: form_url,
            method: 'post',
            data: {
                '_csrf_token': csrf_token,
                '_username': user_name,
                '_password': password,
                '_remember_me': remember_me
            },
            success: function(data){
                $(".dynamic_form").html(data);
                return false;
            }
        });
        return false;
    });

    $(document).on('click', '.fos_user_registration_register input[type="submit"]', function(){
        var registration_email = $("#fos_user_registration_form_email").val();
        var registration_user_name = $("#fos_user_registration_form_username").val();
        var registration_password_firs = $("#fos_user_registration_form_plainPassword_first").val();
        var registration_password_second = $("#fos_user_registration_form_plainPassword_second").val();
        var registration_token = $("#fos_user_registration_form__token").val();
        $.ajax({
            url: form_url,
            method: 'post',
            data: {
                'fos_user_registration_form[email]': registration_email,
                'fos_user_registration_form[username]': registration_user_name,
                'fos_user_registration_form[plainPassword][first]': registration_password_firs,
                'fos_user_registration_form[plainPassword][second]': registration_password_second,
                'fos_user_registration_form[_token]': registration_token
            },
            success: function(data){
                $(".dynamic_form").html(data);
                return false;
            }
        });
        return false;
    });


    $("#find_lost_links a").on("click", function(){
        if($(this).hasClass("start_link")){
            $.ajax({
                url: '/',
                method: 'get',
                async: false,
                success: function(data){
                    if(data == 'false'){
                        $(".dynamic_form").load("/register form", function(){
                            $(".popup_opacity_layer").show();
                        });
                    }else{
                        window.location.href = "/personal_area";
                        return false;
                    }
                }
            });
        }
        return false;
    });

    $(".close_popup").on("click", function(){
        $(".popup_opacity_layer").hide();
    });
});