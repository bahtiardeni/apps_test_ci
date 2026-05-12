var Auth = function(){

    var handlePageLogin         = function () {
        var page = $("#form-login");

        if (page.length)
        {
            page.on("click","#btn-sign", function(){
                handleLogin();
            });
            page.on("keypress", "#input_email", function(e) {
                if(e.which == 13) {
                    handleLogin();

                    e.preventDefault();
                    return false;
                }

            });
            page.on("keypress", "#input_password", function(e) {
                if(e.which == 13) {
                    handleLogin();

                    e.preventDefault();
                    return false;
                }
            });
            page.on("keyup", ".form-control", function(e) {
                $(this).closest(".container-input").find(".note").addClass("hidden").html("");
            });

            setTimeout(function () {
                page.find("#input_email").focus();
            }, 50);
        }
    };

    var handleLogin 	        = function () {
        var element = $("#form-login");

        $.ajax({
            url         : base_url + "auth/plogin",
            type        : "POST",
            dataType    : "JSON",
            beforeSend  : function() {
                Common.handleLoadingScreen();
                $(".alert").addClass("hidden");
            },
            data        : element.serialize(),
            success     : function (data) {
                setTimeout(function () {
                    Common.handleCloseLoadingScreen();

                    if (data.result == "success")
                    {
                        element.submit();

                        if (data.message != ""){
                            window.location.href   = data.message;
                        } else {
                            location.reload();
                        }
                    }
                    else
                    {
                        Common.handleNotificationError(data.message);
                    }

                }, 1000);
            },
            error       : function (request, status, error) {
                setTimeout(function () {
                    /*Common.handleCloseLoadingScreen();
                    handleNotificationError("ERROR!!!");*/
                }, 1000);
            }
        });

    };

    return {
        initialize: function () {
            handlePageLogin();

            $(document).on("click", ".show-password", function () {
                if ($(this).find("i").hasClass("fa-eye"))
                {
                    $(this).find("i").removeClass("fa-eye");
                    $(this).find("i").addClass("fa-eye-slash");
                    $(this).closest(".input-icon").find("input").attr("type", "text");
                }
                else
                {
                    $(this).find("i").removeClass("fa-eye-slash");
                    $(this).find("i").addClass("fa-eye");
                    $(this).closest(".input-icon").find("input").attr("type", "password");

                }
            });
        }
    };
}();
jQuery(document).ready(function (e) {
    setTimeout(function () {
        Auth.initialize();
    }, 1000);
});