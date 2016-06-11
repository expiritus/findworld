$(document).ready(function(){
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