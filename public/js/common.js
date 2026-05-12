var ElLoading;
var MyEditor 			= [];
var Common 				= function () {
    return {
        handleClearNotification		: function() {
            $(".global-notification").html("");
        },
		handleNotificationError		: function(message) {
			$.alert({
				title: "<span class='text-danger'><i class='fa fa-warning'></i>&nbsp;&nbsp;Error!!!</span>",
				content: message,
				animationSpeed: 150
			});
		},
		handleNotificationSuccess	: function(message) {
			$.alert({
				title: "<span class='text-success'><i class='fa fa-check'></i>&nbsp;&nbsp;Success!!!</span>",
				content: message,
				animationSpeed: 150
			});
		},
		handleNotification			: function(title, message, columnClass, button) {
			var option	= {
				animationSpeed	: 150
			};

			option.title	= title;
			option.content	= message;

			if (columnClass.length){
				option.columnClass	= columnClass;
			}
			if (Object.keys(button).length){
				option.buttons		= button;
			}

			$.alert(option);
		},
		handleLoadingScreen 		: function(){
			$('body').Wload({text:' Silahkan tunggu...'})
		},
		handleCloseLoadingScreen 	: function(){
			$('body').Wload('hide',{time:5})
		},

        handleElementForm			: function (container, render_element) {
			var render_default	= [
				"input-select2",
				"input-datetimepicker",
				"input-datepicker",
				"input-timepicker",
				"input-daterangepicker",
				"input-timerangepicker",

				"input-number",
				"input-password",
				"input-html",
				"input-combotree",

				"checkbox"
			];
        	var is_mobile		= Common.handleIsMobile();
			var element_class	= "";

			if (render_element == undefined){
				render_element = render_default;
			}

			if (container == undefined){
				container	= "body";
			}
			element_class	= "input-select2";
            if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){
            	if (!is_mobile)
				{
					$("." + element_class).each(function(i, obj) {
						var tags		= $(obj).attr("tags");
						var readonly 	= $(obj).attr("readonly");
						var allowClear	= $(obj).data("allow-clear");

						if (allowClear == undefined || allowClear == "")
						{
							allowClear = true;
						}
						else if (allowClear == "0" || allowClear == 0)
						{
							allowClear = false;
						}

						if (!readonly)
						{
							var options	= {
								placeholder: "Select",
								dropdownAutoWidth : true,
								width: "resolve",
								allowClear: allowClear,
								dropdownAutoWidth: true,
								/*dropdownParent: $(this).parent()*/
							};


							if ($(obj).data("parent") != undefined && $(obj).data("parent") != "")
							{
								options.dropdownParent	= $(this).parent();
							}

							if ($(obj).data("show") != undefined && $(obj).data("show") != ""){
								options.templateResult = Common.handleFormatSelectDataShow;
							}
							if ($(obj).data("icons") != undefined && $(obj).data("icons") != ""){
								options.templateResult = Common.handleFormatSelectIcon;
							}
							if (tags){
								options.tags = true;
							}

							if ($(obj).data("select2")) {
								$(obj).select2("destroy");
							}

							$(obj).select2(options);
						}
						else
						{
							var options	= {
								placeholder: "Select",
								dropdownAutoWidth : true,
								width: "resolve",
								allowClear: allowClear,
								disabled: true,
								dropdownAutoWidth: true,
								/*dropdownParent: $(this).closest(".form-group")*/
							}

							if ($(obj).data("parent") != undefined && $(obj).data("parent") != "")
							{
								options.dropdownParent	= $(this).parent();
							}

							if ($(obj).data("show") != undefined && $(obj).data("show") != ""){
								options.templateResult = Common.handleFormatSelectDataShow;
							}
							if ($(obj).data("icons") != undefined && $(obj).data("icons") != ""){
								options.templateResult = Common.handleFormatSelectIcon;
							}
							if (tags){
								options.tags = true;
							}

							if ($(obj).data("select2")) {
								$(obj).select2("destroy");
							}

							$(obj).select2(options);

							var el_name  = $(obj).attr("name");
							var el_value = $(obj).val();

							$(obj).after("<input type='hidden' name='" + el_name + "' value='"  + el_value + "'>");
						}

						/*$(obj).on("select2:unselect", function (e) {

                            $(this).val("").trigger("change");
                        });*/
					});
					$(".select2-container").each(function (i) {
						$(this).css("width", "100%");
					});
				}
            }

			element_class	= "input-datetimepicker";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){

				$(".input-datetimepicker").each(function () {

					var date_min	= $(this).data("date_min");
					var date_max	= $(this).data("date_max");
					var options		= {
						format				: "Y-m-d H:i"
					};

					if (date_min != undefined && date_min != ""){
						options.minDate		= date_min;
					}
					if (date_max != undefined && date_max != ""){
						options.maxDate		= date_max;
					}

					$(this).datetimepicker(options);
				});

                /*$(".input-datetimepicker").datetimepicker({
					format		: "Y-m-h H:m:s",
					useCurrent	: false,
					widgetPositioning	: {
						vertical :"bottom"
					},
				});*/
            }

			element_class	= "input-datepicker";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){
				$(".input-datepicker").each(function () {

					var date_min	= $(this).data("date_min");
					var date_max	= $(this).data("date_max");
					var options		= {
						format				: "Y-m-d",
						timepicker			: false
					};

					if (date_min != undefined && date_min != ""){
						options.minDate		= date_min;
					}
					if (date_max != undefined && date_max != ""){
						options.maxDate		= date_max;
					}

					$(this).datetimepicker(options);
				});
            }

			element_class	= "input-timepicker";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){
				$(".input-timepicker").datetimepicker({
					format		: "H:i",
					useCurrent	: false,
					datepicker	: false,
					step		: 30,
					widgetPositioning	: {
						vertical :"bottom"
					}
				});
            }

			element_class	= "input-daterangepicker";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){

				$("input.input-daterangepicker").each(function () {
					$(this).daterangepicker({
						locale: {
							format: "YYYY-MM-DD"
						},
						autoUpdateInput: false
					});
				});


				$("input.input-daterangepicker").on("apply.daterangepicker", function(ev, picker) {
					$(this).val(picker.startDate.format("YYYY-MM-DD") + " - " + picker.endDate.format("YYYY-MM-DD"));
					$(this).trigger("change");
				});
            }

			element_class	= "input-timerangepicker";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){

                $(".input-timerangepicker").daterangepicker({
                    autoUpdateInput: false,
                    timePicker: true,
                    timePicker24Hour: true,
                    timePickerIncrement: 1,
                    timePickerSeconds: true,
                    locale: {
                        format: "HH:mm:ss"
                    }
                }).on("show.daterangepicker", function (ev, picker) {
                    picker.container.find(".calendar-table").hide();
                });


                $("input.input-timerangepicker").on("apply.daterangepicker", function(ev, picker) {
                    $(this).val(picker.startDate.format("HH:mm:ss") + " - " + picker.endDate.format("HH:mm:ss"));
                    $(this).trigger("change");
                });

            }

			element_class	= "input-number";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){

                $("input.input-number").each(function () {
                    var decimals        = $(this).data("decimal") == undefined ? 0 : parseInt($(this).data("decimal"));
                    var dec_point       = $(this).data("dec_point") == undefined ? "," : $(this).data("dec_point");
                    var thousands_sep   = $(this).data("thousands_sep") == undefined ? "." : $(this).data("thousands_sep");

                    $(this).number( true, decimals , dec_point, thousands_sep);
                });
            }

			element_class	= "input-password";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){

                $("input.input-password").passtrength({
                    minChars: 6,
                    passwordToggle: false,
                    tooltip: true,
                    eyeImg : base_url + "public/images/eye.svg"
                });
            }

			element_class	= "input-html";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){

				$("." + element_class).each(function(i, obj) {
					var tmp_id	= $(this).attr("id");

					var file_uploader	= "/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json";

					ClassicEditor
						.create( document.querySelector( "#" + tmp_id ), {
							toolbar: {
								items: [
									"exportPdf",
									"exportWord",
									"pageBreak",
									"|",
									"heading",
									"bold",
									"italic",
									"fontFamily",
									"fontSize",
									"fontColor",
									"link",
									"bulletedList",
									"numberedList",
									"alignment",
									"|",
									"superscript",
									"subscript",
									"strikethrough",
									"underline",
									"|",
									"outdent",
									"indent",
									"horizontalLine",
									"|",
									"CKFinder",
									"imageUpload",
									"imageInsert",
									"blockQuote",
									"insertTable",
									"mediaEmbed",
									"undo",
									"redo",
									"|",
									"htmlEmbed",
									"codeBlock",
									"code",
									"todoList",
									"findAndReplace"
								]
							},
							language: "en",
							image: {
								toolbar: [
									"resizeImage",
									"imageTextAlternative",
									"imageStyle:inline",
									"imageStyle:alignLeft",
									"imageStyle:alignCenter",
									"imageStyle:alignRight",
									"imageStyle:block",
									"imageStyle:alignBlockLeft",
									"imageStyle:alignBlockCenter",
									"imageStyle:alignBlockRight",
									"imageStyle:side",
									"toggleImageCaption",
								]
							},
							table: {
								contentToolbar: [
									"tableColumn",
									"tableRow",
									"mergeTableCells",
									"tableCellProperties",
									"tableProperties"
								]
							},
							licenseKey: "*T?V-*1**-K**W-*L**-*W**-K*F*-2**L",
							height: 200,
							ckfinder: {
								uploadUrl: file_uploader
							},
							PreserveSessionOnFileBrowser : true
						})
						.then( editor => {
							window.editor = editor;
							MyEditor[tmp_id] = editor;
						})
						.catch( error => {
							console.error( "Oops, something went wrong!" );
							console.error( "Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:" );
							console.warn( "Build id: 8hp4w5m93h39-ru7drs6ygib2" );
							console.error( error );
						});
				});
			}

			element_class	= "input-combotree";
			if ((jQuery.inArray(element_class, render_element) !== -1) && $(container + " ." + element_class).length){
				$(".input-combotree").each(function(i, obj)
				{
					var element_id		= $(this).attr("id");
					var multiple		= $(this).data("multiple");
					var listData		= $("#list_" + element_id).val();
					var valueData		= $("#data_" + element_id).val();
					listData			= JSON.parse(listData);

					var options			= {
						data			: listData,
						onLoadSuccess	: function () {
							setTimeout(function () {
								$(".tree-icon").removeClass("tree-file").addClass("tree-folder");

								$(".textbox.combo").css("width", "100%");
								$(".textbox.combo .textbox-text").removeAttr("style");
								$(".textbox.combo .textbox-text").css("width", "90%");

							}, 500);
						},
						onChange		: function (val) {
							$("#" + element_id).val(val).trigger("change");
							$("#data_" + element_id).val(val);
							$("#data_" + element_id).trigger("change");
						}
					};

					if (multiple != undefined && multiple != false)
					{
						options.multiple = true;
					}
					if (!$("#" + element_id).hasClass("combotree-f"))
					{
						$("#" + element_id).combotree(options);
					}

				});
			}

			if ((jQuery.inArray("checkbox", render_element) !== -1) && $("input[type='checkbox'], input[type='radio']").length){

				var options	= {
					checkboxClass: "icheckbox_flat-green",
					radioClass   : "iradio_flat-green"
				};

				/*var attr = $(this).attr("readonly");*/

				/*if (typeof attr !== 'undefined' && attr !== false) {
					options.
				}*/

				$("input[type='checkbox'], input[type='radio']").not('.no-icheck').iCheck(options);
			}

            $("form").on("change", ".form-group input, .form-group select, .form-group textarea", function () {
                $(this).closest(".form-group").removeClass("has-error");
                $(this).closest(".form-group").find(".help-block").html("");
            });
            $("input").on("ifChecked", function () {
                $(this).closest(".form-group").removeClass("has-error");
                $(this).closest(".form-group").find(".help-block").html("");
            });
        },
		handleFormatSelectDataShow	: function (data) {
			var data_show	= $(data.element).closest("select").data("show");

			if (data_show != undefined)
			{
				var content	= "";
				var width	= 100 / data_show.length;

				content	+= "<table style='width: 100%'>";
				content	+= "<tr>";

				for (var i = 0; i < data_show.length; i++)
				{
					var tmp			= $(data.element).data(data_show[i]);
					var tmp_width	= $(data.element).data(data_show[i] + "-width");

					if (tmp_width != undefined)
					{
						width	= tmp_width;
					}
					else
					{
						width	= width + "%";
					}

					content	+= "<td valign='top' width='" + width + "%' style='width: " + width + "; padding-left: 5px; padding-right: 5px;'>" + tmp + "</td>";
				}

				content	+= "</tr>";
				content	+= "</table>";

				return $(content);
			}
		},
		handleFormatSelectIcon		: function (state) {
			if (!state.id) {
				return state.text;
			}

			var content	= "";

			content	+= "<table>";
			content	+= "<tr>";
			content	+= "<td width='30'><i class='"+state.text+" font-size-14'></i></td>";
			content	+= "<td>" + state.text + "</td>";
			content	+= "</tr>";
			content	+= "</table>";

			return $(content);
		},

        handleGetUrlParameter		: function (param) {
        	if (param == undefined || param == "")
			{
				var str = window.location.search.substring(1);

				var match = str.match(/[^=&?]+\s*=\s*[^&#]*/g);
				var obj = {};

				for ( var i = match.length; i--; ) {
					var spl = match[i].split("=");
					var name = spl[0].replace("[]", "");
					var value = spl[1];

					name	= decodeURIComponent(name);

					obj[name] = obj[name] || [];
					obj[name].push(value);
				}
			}
        	else
			{
				var sPageURL = window.location.search.substring(1),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === param) {
						return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
					}
				}
			}



        },

        handleRandomString			: function (length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },

		handlePageEvent				: function() {
			Common.handleGetGlobalNotification();
		},
		handleRedirectSession		: function(res) {
			if (typeof res == "string")
			{
				try {
					res	= JSON.parse(res);
				}
				catch (e) {
				}
			}

			if (res.redirect != undefined && res.redirect != null)
			{
				location.href = res.redirect;
				$.confirm({
					icon: "fa fa-warning",
					title: "Session Expired",
					content: "Your session has timed out. Please Login again.",
					scrollToPreviousElement: false,
					scrollToPreviousElementAnimate: false,

					buttons: {
						info: {
							btnClass: "btn-info",
							text: "<i class='fa fa-fw fa-unlock'></i> Login",
							action: function(){
								location.href = res.redirect;
							}
						}
					}
				});

				return false;
			}
		},

		handleGetGlobalNotification	: function() {
			var element	= $(".global-notification");

			if (element.length)
			{
				$.ajax({
					url: base_url + "ajax/notification",
					type: "GET",
					dataType: "JSON",
					beforeSend : function(){
						element.removeClass("hidden");
						element.find(".global-notification-count").text("");
						element.find(".global-notification-list").html("");
					},
					success: function (res) {
						var content	= "";

						if (res.length)
						{
							$.each(res, function (i, data) {

								content	+= "<li>";
								content	+= "<a href='"+data.link+"'>"+data.text+"</a>";
								content	+= "</li>";

							});



							$(".global-notification-count").text(res.length);
							$(".global-notification-list").html(content);
						}
						else
						{
							element.addClass("hidden");
						}
					},
					error: function (jqXHR, exception) {

					}
				});
			}

		},

		handleTooltip				: function() {
			if ($(".tooltip-container").length)
			{
				$('.tooltip-container').tooltip({
					selector: "[data-toggle=tooltip]"
				});
			}

		},
		handleSearchArray			: function(dataArray, field, value, return_type) {
			var result;

			if (dataArray != undefined)
			{
				for( var i = 0, len = Object.keys(dataArray).length; i < len; i++ ) {

					if( dataArray[i][field] == value ) {

						if (return_type === 1){
							result = i;
						}else{
							result = dataArray[i];
						}

						break;
					}
				}
			}

			return result;

		},

		handleFileViewer			: function() {
			if ($(".files_3d_view").length)
			{
				$(".files_3d_view").each(function(i, obj) {
					var file 		= $(obj).data("file");
					var element_id	= $(obj).attr("id");

					var stl_viewer	= new StlViewer
					(
						document.getElementById(element_id),
						{
							auto_rotate:false,
							/*bgcolor:"#20FAAC",*/
							allow_drag_and_drop:true,
							view_edges:true,
							controls:1,
							models:
								[
									{filename:file}
								]
						}
					);

				});
			}

		},
		handleAjaxError				: function() {
			Common.handleNotificationError("Error. Please reload or Contact your Administrator");
		},
		handleIsMobile				: function () {
			var isMobile = false; //initiate as false
// device detection
			if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
				isMobile = true;
			}

			return isMobile;
		},
		handleDateTimePickerDestroy	: function () {
			if( $(".input-datepicker").data("xdsoft_datetimepicker") ){
				$(".input-datepicker").datetimepicker("destroy");
				this.value = "create";
			}else{
				$(".input-datepicker").datetimepicker();
				$(".input-datepicker").value = "destroy";
			}
		},

		handleShorCurrency			: function (value, presisi){

			var format_angka    = "";
			var simbol          = "";
			var plusmin			= "";

			if (presisi == undefined){
				presisi = 1;
			}

			if (value < 0){
				plusmin	= "-";
			}

			value	= Math.abs(value);

			if (value < 900) {
				format_angka = $.number(value, presisi);
				simbol = "";
			} else if (value < 900000) {
				format_angka = $.number(value / 1000, presisi);
				simbol = " Rb";
			} else if (value < 900000000) {
				format_angka = $.number(value / 1000000, presisi);
				simbol = " Jt";
			} else if (value < 900000000000) {
				format_angka = $.number(value / 1000000000, presisi);
				simbol = " M";
			} else {
				format_angka = $.number(value / 1000000000000, presisi);
				simbol = " T";
			}

			if ( presisi > 0 ) {
				var pisah      = "." + "0".repeat(presisi);
				format_angka   = format_angka.replace(pisah, "");
			}

			return plusmin + format_angka + simbol;
		},
		handleToggleFullscreen		: function () {
			var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
				(document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
				(document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
				(document.msFullscreenElement && document.msFullscreenElement !== null);

			var docElm = document.documentElement;
			if (!isInFullScreen) {
				if (docElm.requestFullscreen) {
					docElm.requestFullscreen();
				} else if (docElm.mozRequestFullScreen) {
					docElm.mozRequestFullScreen();
				} else if (docElm.webkitRequestFullScreen) {
					docElm.webkitRequestFullScreen();
				} else if (docElm.msRequestFullscreen) {
					docElm.msRequestFullscreen();
				}
			} else {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
			}
		},

		handleFileExist				: function (file_path) {
			$.ajax({
				url		:file_path,
				type	:"HEAD",
				error	: function()
				{
					return false;
				},
				success	: function()
				{
					return true;
				}
			});
		},
		handleGetDateRange			: function (startDate, endDate) {
			// we use UTC methods so that timezone isn't considered
			let start = new Date(startDate);
			const end = new Date(endDate).setUTCHours(12);
			const dates = [];
			while (start <= end) {
				// compensate for zero-based months in display
				const displayMonth = start.getUTCMonth() + 1;
				dates.push([
					start.getUTCFullYear(),
					// months are zero based, ensure leading zero
					(displayMonth).toString().padStart(2, '0'),
					// always display the first of the month
					'01',
				].join('-'));

				// progress the start date by one month
				start = new Date(start.setUTCMonth(displayMonth));
			}

			return dates;
		},

        init: function() {

        }
    };
}();
var DatatablePopup		= function () {
	return {
		handleSetModal				: function (param) {
			$.ajax({
				url				: base_url + "ajax/datatable_popup_table",
				type			: "GET",
				dataType		: "JSON",
				data 			: {
					param : param
				},
				beforeSend 		: function(){

					var UrlimageLoading = base_url + "/public/images/loader.gif";

					$("#modal-detail").modal("show");
					$("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
					$("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
				},
				success			: function (res) {
					$("#modal-detail .modal-dialog").addClass("modal-70");
					$("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
					$("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
					$("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);

					$("#modal-detail .modal-dialog .modal-content .modal-body").addClass("pd-0");

					if (res.footer.length){
						$("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
					}else{
						$("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
					}

					DatatablePopup.handleDatatable(param);

					$(".btn-datatable-header:not(.btn-datatable-clear_filter):not(.btn-datatable-refresh)").remove();
				},
				error			: function (jqXHR, exception) {
					Common.handleNotificationError("Ooops! Something went wrong.");
				}
			});
		},
		handleDatatable				: function (param) {
			Datatable.initializeDatatable();
		},

		init: function() {

		}
	};
}();

jQuery(document).ready(function () {
    Common.init();
    Common.handlePageEvent();
    Common.handleTooltip();


	DatatablePopup.init();
});
