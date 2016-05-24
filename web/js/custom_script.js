$(document).ready(function(){
    var country = $("#country");
    var custom_country = $("#custom_country");
    var city =  $("#city");
    var area = $("#area, #example_area");
    var list_area = $("#list_area");
    var list_street = $("#list_street");
    var list_thing = $("#list_thing");
    var button_next0 = $("#button_next0");
    var button_next = $("#button_next");
    var button_next2 = $("#button_next2");
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
            button_next0.show();
        }else if(country_id == 0){
            city.hide();
            area.hide();
            street.hide();
            button_next.hide();
            button_next2.hide();
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
                console.info(data);
                $(city).append("<option value='0'>Select city</option>");
                $.each(data, function(index, value){
                    $(city).append('<option value="'+value.id+'">'+value.city+'</option>')
                });

            }
        });
    }

    country.on('change', function(){
        var country_id = country.val();
        country_id = parseInt(country_id);
        getCity(country_id);
    });

    button_next0.on('click', function(){
        var custom_country_val = custom_country.val();
        if(custom_country_val.length == 0){
            return false;
        }else{
            var country_id = custom_country.val();
            getCity(country_id);
            button_next0.hide();
        }
    });

    custom_country.on('keyup', function(){
        var custom_country_value = $(custom_country).val();
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
                console.info(data);
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
        console.info(obj);
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