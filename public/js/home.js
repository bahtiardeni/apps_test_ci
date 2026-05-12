var HOME = function(){
    var UrlimageLoading         = base_url + "/public/images/loader.gif";
    var pageUrl                 = base_url + "home/";
    var UIBlockOptions          = {
        message: "<div class='loading-animator'></div>",
        css: {
            border: "none",
            padding: "2px",
            backgroundColor: "none"
        },
        overlayCSS: {
            backgroundColor: "#fff",
            opacity: 0.8,
            cursor: "wait",
            "z-index": 49
        }
    };

    var handlePageIndex             = function () {
        var element     = $("#page-home");

        if (element.length)
        {
            handleGetData();
        }
    };
    var handleGetData               = function () {
        $.ajax({
            url         : pageUrl + "get_data",
            type        : "GET",
            dataType    : "JSON",
            beforeSend  : function () {
                $(".container-block").block(UIBlockOptions);
            },
            success     : function (res) {

                Highcharts.chart("chart_divisi", {
                    chart       : {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        style : {
                            fontSize : "12px",
                        }
                    },

                    title       : {
                        text: ''
                    },
                    tooltip     : {
                        valueSuffix: '%'
                    },
                    plotOptions : {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true
                            },
                            showInLegend: true
                        }
                    },
                    series      : [
                        {
                            name            : "Divisi",
                            colorByPoint    : true,
                            data            : res.chart_divisi
                        }
                    ]
                });
                Highcharts.chart("chart_jabatan", {
                    chart       : {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        style : {
                            fontSize : "12px",
                        }
                    },

                    title       : {
                        text: ''
                    },
                    tooltip     : {
                        valueSuffix: '%'
                    },
                    plotOptions : {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true
                            },
                            showInLegend: true
                        }
                    },
                    series      : [
                        {
                            name            : "Jabatan",
                            colorByPoint    : true,
                            data            : res.chart_jabatan
                        }
                    ]
                });
                Highcharts.chart("chart_gender", {
                    chart       : {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        style : {
                            fontSize : "12px",
                        }
                    },

                    title       : {
                        text: ''
                    },
                    tooltip     : {
                        valueSuffix: '%'
                    },
                    plotOptions : {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true
                            },
                            showInLegend: true
                        }
                    },
                    series      : [
                        {
                            name            : "Jenis Kelamin",
                            colorByPoint    : true,
                            data            : res.chart_gender
                        }
                    ]
                });


                $(".container-block").unblock();
                $(".highcharts-credits").remove();
            },
            error       : function (jqXHR, exception) {
                $(".container-block").unblock();
            }
        });
    };

    var handlePageUpdate            = function () {
        var element     = $("#page-barang-update");

        if (element.length)
        {
            $("#input_no_inventaris").mask("9.99.99.99.999.9999");
        }
    };

    var handlePageDetail            = function () {
        var element     = $("#page-barang-detail");

        if (element.length)
        {
            $(document).on("click", ".list-transaction", function () {
                var hash        = $(this).data("hash");
                handleGetTransaction(hash);
            });

            $(document).on("click", ".list-maintenance", function () {
                var hash        = $(this).data("hash");
                handleGetMaintenance(hash);
            });
            $(document).on("click", ".btn-form-maintenance", function () {
                var hash        = $(this).data("hash");
                var id_barang   = $(this).data("id_barang");
                handleGetFormMaintenance(id_barang, hash);
            });
            $(document).on("click", ".btn-save-maintenance", function () {
                $.confirm({
                    icon    : "fa fa-save",
                    title   : "Simpan Data",
                    content : "Apakah Anda yakin akan menyimpan data ini?",
                    buttons: {
                        info: {
                            btnClass: "btn-danger",
                            text: "<i class='fa fa-fw fa-undo'></i> Batal",
                            action: function(){

                            }
                        },
                        danger: {
                            btnClass: "btn-primary any-other-class",
                            text: "<i class='fa fa-fw fa-refresh'></i> Ya!!",
                            action: function(){
                                handleSaveFormMaintenance();
                            }
                        }
                    }
                });
            });

            $(document).on("click", ".list-movement", function () {
                var hash        = $(this).data("hash");
                handleGetMovement(hash);
            });
            $(document).on("click", ".btn-form-movement", function () {
                var hash        = $(this).data("hash");
                var id_barang   = $(this).data("id_barang");
                handleGetFormMovement(id_barang, hash);
            });
            $(document).on("click", ".btn-save-movement", function () {
                $.confirm({
                    icon    : "fa fa-save",
                    title   : "Simpan Data",
                    content : "Apakah Anda yakin akan menyimpan data ini?",
                    buttons: {
                        info: {
                            btnClass: "btn-danger",
                            text: "<i class='fa fa-fw fa-undo'></i> Batal",
                            action: function(){

                            }
                        },
                        danger: {
                            btnClass: "btn-primary any-other-class",
                            text: "<i class='fa fa-fw fa-refresh'></i> Ya!!",
                            action: function(){
                                handleSaveFormMovement();
                            }
                        }
                    }
                });
            });

            if ($('.iosblue').length)
            {
                var Switch2 = require('ios7-switch');
                var checkbox = document.querySelector('.iosblue');
                var mySwitch2 = new Switch2(checkbox);
                if ($("#is_verfified").is(":checked")){
                    mySwitch2.toggle();
                }
                mySwitch2.el.addEventListener('click', function(e){
                    e.preventDefault();
                    mySwitch2.toggle();

                    var hash        = $("#input_id").val();
                    var is_verified = $("#is_verfified").is(":checked") == true ? 1 : 0;

                    $.ajax({
                        url         : pageUrl + "update_verified",
                        type        : "POST",
                        dataType    : "JSON",
                        data        : {
                            hash        : hash,
                            is_verified : is_verified
                        },
                        beforeSend  : function () {

                        },
                        success     : function (res) {

                        },
                        error       : function (jqXHR, exception) {
                        }
                    });
                }, false);
            }

        }
    };
    var handleGetTransaction        = function (hash) {
        $.ajax({
            url         : base_url + "transaction/peminjaman/detail",
            type        : "GET",
            dataType    : "JSON",
            data        : {
                hash : hash
            },
            beforeSend  : function () {
                $("#modal-detail").modal("show");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
                $("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");

            },
            success     : function (res) {

                $("#modal-detail .modal-dialog").addClass("modal-70");
                $("#modal-detail .modal-dialog .modal-content .modal-body").addClass("pd-0");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
                $("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
                $("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);

                if (res.footer.length){
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
                }else{
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
                }
            },
            error       : function (jqXHR, exception) {
            }
        });
    };
    var handleGetMaintenance        = function (hash) {
        $.ajax({
            url         : pageUrl + "get_maintenance",
            type        : "GET",
            dataType    : "JSON",
            data        : {
                hash : hash
            },
            beforeSend  : function () {
                $("#modal-detail").modal("show");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
                $("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");

            },
            success     : function (res) {

                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
                $("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
                $("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);
                $("#modal-detail .modal-dialog .modal-content .modal-body").addClass("pd-10");

                if (res.footer.length){
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
                }else{
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
                }
            },
            error       : function (jqXHR, exception) {
            }
        });
    };
    var handleGetMovement           = function (hash) {
        $.ajax({
            url         : pageUrl + "get_movement",
            type        : "GET",
            dataType    : "JSON",
            data        : {
                hash : hash
            },
            beforeSend  : function () {
                $("#modal-detail").modal("show");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
                $("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
            },
            success     : function (res) {

                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
                $("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
                $("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);
                $("#modal-detail .modal-dialog .modal-content .modal-body").addClass("pd-10");

                if (res.footer.length){
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
                }else{
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
                }
            },
            error       : function (jqXHR, exception) {
            }
        });
    };

    var handleGetFormMaintenance    = function (id_barang, hash) {
        $.ajax({
            url         : pageUrl + "get_form_maintenance",
            type        : "GET",
            dataType    : "JSON",
            data        : {
                id_barang   : id_barang,
                hash        : hash
            },
            beforeSend  : function () {
                $("#modal-detail").modal("show");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
                $("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
            },
            success     : function (res) {
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
                $("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
                $("#modal-detail .modal-dialog .modal-content .modal-body").addClass("pd-20");
                $("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);

                if (res.footer.length){
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
                }else{
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
                }

                Common.handleElementForm();

            },
            error       : function (jqXHR, exception) {
                $(".container-block").unblock();
            }
        });
    };
    var handleSaveFormMaintenance   = function() {
        $.ajax({
            url         : pageUrl + "save_form_maintenance",
            type        : "POST",
            dataType    : "JSON",
            data        : $("#form-maintenance").serialize(),
            beforeSend  : function () {
                Common.handleLoadingScreen();
            },
            success     : function (res) {
                Common.handleCloseLoadingScreen();
                if (res.result == "success")
                {
                    location.reload();
                }
                else
                {
                    Common.handleNotificationError(res.message);
                }
            },
            error       : function (jqXHR, exception) {
            }
        });
    };

    var handleGetFormMovement       = function (id_barang, hash) {
        $.ajax({
            url         : pageUrl + "get_form_movement",
            type        : "GET",
            dataType    : "JSON",
            data        : {
                id_barang   : id_barang,
                hash        : hash
            },
            beforeSend  : function () {
                $("#modal-detail").modal("show");
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
                $("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
            },
            success     : function (res) {
                $("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
                $("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
                $("#modal-detail .modal-dialog .modal-content .modal-body").addClass("pd-20");
                $("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);

                if (res.footer.length){
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
                }else{
                    $("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
                }

                Common.handleElementForm();

            },
            error       : function (jqXHR, exception) {
                $(".container-block").unblock();
            }
        });
    };
    var handleSaveFormMovement      = function() {
        $.ajax({
            url         : pageUrl + "save_form_movement",
            type        : "POST",
            dataType    : "JSON",
            data        : $("#form-movement").serialize(),
            beforeSend  : function () {
                Common.handleLoadingScreen();
            },
            success     : function (res) {
                Common.handleCloseLoadingScreen();
                if (res.result == "success")
                {
                    location.reload();
                }
                else
                {
                    Common.handleNotificationError(res.message);
                }
            },
            error       : function (jqXHR, exception) {
            }
        });
    };



    return {
        initialize: function () {
            handlePageIndex();
            handlePageDetail();
            handlePageUpdate();
        }
    };
}();
jQuery(document).ready(function (e) {
    HOME.initialize();
});