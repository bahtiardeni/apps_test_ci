var Public = function(){
    var UrlimageLoading = base_url + "/public/images/loader.gif";

    var handleCheckCode             = function (form, config, source, target) {
        var elementCode	= target.attr("readonly");

        if (elementCode === "readonly") {
            $.ajax({
                type		: "GET",
                url			: base_url + "ajax/ajax_check_code/" + config,
                dataType 	: "JSON",
                data		: form.serialize(),
                beforeSend 	: function(){},
                success		: function (res) {
                    if (res.result == "success"){
                        target.val(res.code);
                        source.val(res.code_tmp);
                    }
                },
                error		: function (jqXHR, exception) {
                    Common.handleNotificationError("Error. Please reload or Contact your Administrator");
                }
            });
        }
    };

    return {
        initialize: function () {

            // for Code Generator
            var elementTmpCode      = $("#input_tmp_code, #input_tmp_number, #input_number_tmp, .tmp_code_generator");
            var elementFormTmpCode  = elementTmpCode.closest("form");

            if (elementTmpCode.length && elementFormTmpCode != undefined)
            {
                var target          = elementTmpCode.data("target");
                var config_name     = elementTmpCode.data("config");
                var target_element  = $("#input_" + target);

                elementFormTmpCode.on("change", "input, select", function () {
                    handleCheckCode(elementFormTmpCode, config_name, elementTmpCode, target_element);
                });

                setTimeout(function () {
                    handleCheckCode(elementFormTmpCode, config_name, elementTmpCode, target_element);
                }, 1000);
            }

            // Event Close Modal
            $("#modal-detail").on("shown.bs.modal", function () {

                setTimeout(function () {

                    var footer_content  = $("#modal-detail .modal-dialog .modal-content .modal-footer").text().trim().length;

                    if (footer_content == 0)
                    {
                        $("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
                    }
                    else
                    {
                        $("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
                    }
                }, 500);

            });
            $("#modal-detail").on("hidden.bs.modal", function () {
                $("#modal-detail .modal-dialog").removeClass("modal-lg");
                $("#modal-detail .modal-dialog").removeClass("modal-90");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html("");
                $("#modal-detail .modal-dialog .modal-content .modal-header button").removeClass("hidden");
                $("#modal-detail .modal-dialog .modal-content .modal-body").html("");
                $("#modal-detail .modal-dialog .modal-content .modal-footer").html("");
                $("#modal-detail .modal-dialog .modal-content .modal-body").removeAttr("style");

            });
            $("#modal-other").on("hidden.bs.modal", function () {
                $("#modal-other .modal-dialog").removeClass("modal-lg");
                $("#modal-other .modal-dialog .modal-content .modal-header h4").html("");
                $("#modal-other .modal-dialog .modal-content .modal-header button").removeClass("hidden");
                $("#modal-other .modal-dialog .modal-content .modal-body").html("");
                $("#modal-other .modal-dialog .modal-content .modal-footer").html("");
            });
            $("#modal-viewer").on("hidden.bs.modal", function () {
                $("#modal-viewer .modal-dialog").removeClass("modal-lg");
                $("#modal-viewer .modal-dialog .modal-content .modal-header h4").html("");
                $("#modal-viewer .modal-dialog .modal-content .modal-header button").removeClass("hidden");
                $("#modal-viewer .modal-dialog .modal-content .modal-body").html("");
                $("#modal-viewer .modal-dialog .modal-content .modal-footer").html("");
            });

            if ($(".ck-content img").length)
            {
                $(".ck-content img").each(function () {
                    var image_element   = $(this);
                    var image_url       = image_element.attr("src");

                    if (image_url != undefined)
                    {
                        image_element.addClass("link-lighter");
                        image_element.attr("href", image_url);
                    }
                });
            }
        },
        handleGetCart : function () {
            var element     = $("#container-cart");

            if (element.length)
            {
                $.ajax({
                    type		: "GET",
                    url			: base_url + "home/get_cart",
                    dataType 	: "JSON",
                    success		: function (res) {
                        var content     = "";
                        var count       = "";

                        if (res.length)
                        {
                            count   = res.length;

                            $.each(res, function (i, item) {
                                content += "<li>";
                                content += "<a href='javascript:void(0)' class='' style='padding: 5px 10px !important;'>";

                                content += "<table width='100%'>";
                                content += "<tr>";
                                content += "<td width='40' valign='top'><img src='" + item.thumbnail + "' width='30' class='mr-10'></td>";
                                content += "<td valign='top'>";

                                content += "<div class='muted font-size-10' style='line-height: 10px;'>" + item.no_inventaris + "</div>";
                                content += "<div>" + item.name + "</div>";
                                content += "</td>";
                                content += "</tr>";
                                content += "</table>";


                                content += "</a>";
                                content += "</li>";
                                content += "<li class='divider'></li>";
                            });


                            content += "<li><a href='" + base_url + "transaction/peminjaman/update' class='btn btn-small btn-block' style='width: 96%; text-align: center;'>LIHAT KERANJANG</a></li>";
                        }
                        else
                        {
                            content = "<li><a href='javascript:void(0)' class='text-warning'>Tidak ada barang</a></li>";
                        }

                        element.find(".dropdown-menu").html(content);
                        element.find(".cart-header").text(count);
                    },
                    error		: function (jqXHR, exception) {
                    }
                });
            }
        }
    };
}();
jQuery(document).ready(function (e) {
    Public.initialize();
    Public.handleGetCart();
});
function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}
