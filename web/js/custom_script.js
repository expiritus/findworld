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

    $(document).on('click', '.dynamic_form #_submit', function(){
        var csrf_token = $(".dynamic_form input[type='hidden']");
        var csrf_token_name_attr = csrf_token.attr("name");
        var csrf_token_val = csrf_token.val();

        var user_name = $("#username");
        var user_name_name_attr = user_name.attr("name");
        var user_name_val = user_name.val();

        var password = $("#password");
        var password_name_attr = password.attr("name");
        var password_val = password.val();

        var remember_me = $("#remember_me");
        var remember_me_name_attr = remember_me.attr("name");
        var remember_me_val = remember_me.val();
        var obj = {};
            obj[csrf_token_name_attr] = csrf_token_val;
            obj[user_name_name_attr] = user_name_val;
            obj[password_name_attr] = password_val;
            obj[remember_me_name_attr] = remember_me_val;
        $.ajax({
            url: form_url,
            method: 'post',
            data: obj,
            success: function(data){
                if(data == 'true'){
                    location.reload();
                }else{
                    $(".dynamic_form").html(data);
                    $(".dynamic_form a[href='/login']").addClass('standard_login_link');
                    return false;
                }
            }
        });
        return false;
    });

    $(document).on('click', '.fos_user_registration_register input[type="submit"]', function(){
        var registration_email = $("#fos_user_registration_form_email");
        var registration_email_name_attr = registration_email.attr("name");
        var registration_email_val = registration_email.val();

        var registration_user_name = $("#fos_user_registration_form_username");
        var registration_user_name_attr = registration_user_name.attr("name");
        var registration_user_name_val = registration_user_name.val();

        var registration_password_first = $("#fos_user_registration_form_plainPassword_first");
        var registration_password_first_name_attr = registration_password_first.attr("name");
        var registration_password_first_val = registration_password_first.val();

        var registration_password_second = $("#fos_user_registration_form_plainPassword_second");
        var registration_password_second_name_attr = registration_password_second.attr("name");
        var registration_password_second_val = registration_password_second.val();

        var registration_token = $("#fos_user_registration_form__token");
        var registration_token_name_attr = registration_token.attr("name");
        var registration_token_val = registration_token.val();

        var obj = {};
            obj[registration_email_name_attr] = registration_email_val;
            obj[registration_user_name_attr] = registration_user_name_val;
            obj[registration_password_first_name_attr] = registration_password_first_val;
            obj[registration_password_second_name_attr] = registration_password_second_val;
            obj[registration_token_name_attr] = registration_token_val;
        $.ajax({
            url: form_url,
            method: 'post',
            data: obj,
            success: function(data){
                $(".dynamic_form").html(data);
                $(".dynamic_form a[href='/login']").addClass('standard_login_link');
                return false;
            }
        });
        return false;
    });

    $(document).on("click", ".fos_user_resetting_request input[type='submit']", function(){

        var resetting_form_username = $(".fos_user_resetting_request #username");
        var resetting_form_user_name_attr = resetting_form_username.attr("name");
        var resetting_form_username_val = resetting_form_username.val();
        var obj = {};
            obj[resetting_form_user_name_attr] = resetting_form_username_val;
        $.ajax({
            url: '/resetting/send-email',
            method: 'post',
            data: obj,
            success: function(data){
                $(".dynamic_form").html(data);
                $(".dynamic_form a[href='/login']").addClass('standard_login_link');
                return false;
            }
        });
        return false;
    });

    $("#find_lost_links a").on("click", function(){
        var action = "";
        if($(this).is("#lost")){
            action = "lost";
        }

        if($(this).is("#find")){
            action = "find";
        }
        if($(this).hasClass("start_link")){
            $.ajax({
                url: '/',
                method: 'get',
                success: function(data){
                    if(data == 'false'){
                        $(".dynamic_form").load("/register form", function(){
                            $(".popup_opacity_layer").show();
                        });
                    }else{
                        window.location.href = "/personal_area/"+action;
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