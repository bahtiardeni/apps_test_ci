var Form = function(){
	var Ajax, AjaxMeta;
	var UrlimageLoading = base_url + "public/images/loader.gif";

	var handleEvent 			= function () {
		var element = $("#update-datatable");

		if (element.length)
		{
			element.on("click", "#btn-save", function () {

				if ($(".input-html").length){
					$(".input-html").each(function(i, obj) {
						var tmp_id	= $(this).attr("id");
						$(this).val(MyEditor[tmp_id].getData());

						console.log($(this).val());
					});
				}

				$.confirm({
					icon: "fa fa-save",
					title: "Simpan Data",
					content: "Apakah Anda yakin akan menyimpan data ini?",
					scrollToPreviousElement: false,
					scrollToPreviousElementAnimate: false,

					buttons: {
						info: {
							btnClass: "btn-danger",
							text: "<i class='fa fa-fw fa-undo'></i> Batal",
							action: function(){

							}
						},
						danger: {
							btnClass: 'btn-primary any-other-class',
							text: "<i class='fa fa-fw fa-check-circle'></i> Ya, Simpan!!",
							action: function(){

								$.ajax({
									url: element.data("url") + "/update",
									type: "POST",
									dataType: "JSON",
									data: element.serialize(),
									beforeSend: function () {
										Common.handleLoadingScreen();

										element.find(".form-group").removeClass("has-error");
										element.find(".form-group").find(".help-block").text("");
									},
									success: function (res) {
										Common.handleCloseLoadingScreen();

										if (res.result == CONFIG.AJAX_RESULT_ERROR)
										{
											$.each(res.message, function(field, message){
												element.find(".form-field-input_" + field).addClass("has-error");
												element.find(".form-field-input_" + field).find(".help-block").html("<i class='fa fa-warning'></i>&nbsp;&nbsp;" + message);
											});

											$('html, body').animate({
												scrollTop: ($('.has-error').first().offset().top - 80)
											},500);

										}
										else if (res.result == CONFIG.AJAX_RESULT_SUCCESS)
										{
											if (res.url != undefined && res.url != "")
											{
												document.location = res.url;
											}
											else
											{
												if (document.location.href == element.find(".btn-cancel").attr("href")){
													$("html, body").animate({ scrollTop: 0 }, "fast");
													$.dialog({
														icon: "fa  fa-check",
														title: "Success",
														content: res.message,
													});
												}else{
													document.location = element.data("url");
											}

										}
									}
									},
									error: function (jqXHR, exception) {
										Common.handleCloseLoadingScreen();
									}
								});

							}
						},
					}
				});
			});
		}

		var element_meta	= $("#container-form-metadata");

		if (element_meta.length)
		{
			$(document).on("change", ".el-term-conditions", function (){
				handleGetFormMeta();
			});

			setTimeout(function(){
				handleGetFormMeta();
			}, 500);
		}

		$(document).on("click", ".btn-file", function () {
			var el          = $(this);
			var el_form		= el.data("id");

			$("." + el_form).find(".input-file").click();
		});
		$(document).on("change", ".input-file", function (e) {

			var el          = $(this);
			var type        = el.attr("data-type");
			var field       = el.attr("data-field");
			var url			= el.closest("form").data("url");
			var method		= el.closest("form").data("method");

			if (method != undefined && method != "")
			{
				url	= url + "/" + method + "/";
			}
			else
			{
				url	= url + "/upload/";
			}

			var file_data   = el.prop('files')[0];
			var form_data   = new FormData();
			form_data.append('file', file_data);

			el.parent().parent().removeClass("has-error");
			el.parent().parent().find(".help-block").text("");

			$.ajax({
				url: url + field,
				type: "POST",
				dataType: "JSON",
				data: form_data,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$(".form-field-input_" + field).find(".well").removeClass("hidden");
					$(".form-field-input_" + field).find(".file-loading").removeClass("hidden");
				},
				success: function (res) {


					if (res.result == "success")
					{
						$(".form-field-input_" + field).find(".file-list").html(res.message.content);
						$("#input_" + field).val(res.message.id);
					}
					else
					{
						$(".form-field-input_" + field).addClass("has-error");
						$(".form-field-input_" + field).find(".help-block").html('<i class="fa fa-warning"></i>&nbsp;&nbsp;' + res.message);
					}

					$(".form-field-input_" + field).find(".file-loading").addClass("hidden");

					if (!$(".form-field-input_" + field).find(".file-item").length)
					{
						$(".form-field-input_" + field).find(".well").addClass("hidden");
					}
					else
					{
						$(".form-field-input_" + field).find(".well").removeClass("hidden");
						$(".form-field-input_" + field).find(".file-list").removeClass("hidden");

					}
				},
				error: function (res) {

				}
			});
		});
		$(document).on("click", ".btn-generate-password", function (e) {

			var string = Common.handleRandomString(10);

			$(this).parent().parent().find(".input-password").val(string);


		});
		$(document).on("click", ".btn-file-dynamic", function () {
			var el          = $(this);
			var el_form		= el.data("id");

			$("." + el_form).find(".input-file-dynamic").click();
		});
		$(document).on("change", ".input-file-dynamic", function (e) {

			var el          = $(this);
			var type        = el.attr("data-type");
			var field       = el.attr("data-field");
			var url			= el.closest("form").data("url");

			var file_data   = el.prop('files')[0];
			var form_data   = new FormData();
			form_data.append('file', file_data);

			el.parent().parent().removeClass("has-error");
			el.parent().parent().find(".help-block").text("");

			$.ajax({
				url: url + "/upload/" + field,
				type: "POST",
				dataType: "JSON",
				data: form_data,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$(".form-field-input_" + field).find(".well").removeClass("hidden");
					$(".form-field-input_" + field).find(".file-loading").removeClass("hidden");
				},
				success: function (res) {

					if (res.result == "success")
					{
						$(".form-field-input_" + field).find(".file-list").append(res.message.content);

						var new_value	= [];
						var old_value	= $("#input_" + field).val();

						old_value	= old_value.split(",");

						if (old_value.length)
						{
							$.each(old_value, function (i, item) {
								if (parseInt(item)){
									new_value.push(parseInt(item));
								}
							});
						}

						new_value.push(res.message.id);

						$("#input_" + field).val(new_value.join(","));
					}
					else
					{
						$(".form-field-input_" + field).addClass("has-error");
						$(".form-field-input_" + field).find(".help-block").html('<i class="fa fa-warning"></i>&nbsp;&nbsp;' + res.message);
					}

					$(".form-field-input_" + field).find(".file-loading").addClass("hidden");

					if (!$(".form-field-input_" + field).find(".file-item").length)
					{
						$(".form-field-input_" + field).find(".well").addClass("hidden");
					}
					else
					{
						$(".form-field-input_" + field).find(".file-list").removeClass("hidden");

					}

				},
				error: function (res) {

				}
			});
		});
		$(document).on("click", ".btn-file-delete", function () {

			var thiselement	= $(this);


			$.confirm({
				icon: "fa fa-warning",
				title: "Delete File Data",
				content: "Are you sure delete this file?",
				scrollToPreviousElement: false,
				scrollToPreviousElementAnimate: false,

				buttons: {
					info: {
						btnClass: "btn-danger",
						text: "<i class='fa fa-fw fa-undo'></i> Batal",
						action: function(){

						}
					},
					danger: {
						btnClass: 'btn-primary any-other-class',
						text: "<i class='fa fa-fw fa-check-circle'></i> Yes, Delete!!",
						action: function(){

							var data_id		= thiselement.data("id");
							var count_file	= thiselement.closest(".form-group").find(".file-list  .file-item").length;
							var values		= thiselement.closest(".form-group").find("input[type=hidden]").val();
							var new_values	= [];
							values			= values.split(",");


							$.each(values, function (i, val) {
								if (val != data_id){
									new_values.push(val);
								}
							});


							if (new_values.length >= 1){
								new_values	= new_values.join(",");
							}else{
								new_values	= "";
							}

							if (count_file == 1){
								thiselement.closest(".well").addClass("hidden");
							}else{
								thiselement.closest(".well").removeClass("hidden");
							}

							thiselement.closest(".form-group").find("input[type=hidden]").val(new_values);
							thiselement.closest(".file-item").remove();

						}
					},
				}
			});

		});

		$(document).on("click", ".btn-file-view", function () {

			var element	= $(this);
			var id		= element.data("id");
			var type	= element.data("type");

			$.ajax({
				type: "GET",
				dataType : "JSON",
				url: base_url + "files/get_file",
				beforeSend : function(){
					$("#modal-viewer").modal("show");
					$("#modal-viewer .modal-dialog .modal-content .modal-title").html("Please wait...");
					$("#modal-viewer .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
				},
				data : {
					id : id,
					type : type
				},
				success: function (res) {
					$("#modal-viewer .modal-dialog .modal-content .modal-title").html(res.title);
					$("#modal-viewer .modal-dialog .modal-content .modal-body").html(res.content);

					Common.handleFileViewer();

				},
				error: function (jqXHR, exception) {
					$("#modal-viewer").modal("hide");
					Common.handleNotificationError("The file cannot be previewed");
				}
			});


		});

		$(document).on("click", ".list-field-list-custom", function () {
			var el_value	= null;
			var el          = $(this);
			var multiple	= el.closest(".container-field-list-custom").data("multiple");

			if (multiple)
			{
				if (el.hasClass("active")){
					el.removeClass("active");
					/*el.find("i").addClass("hidden");*/
				}else{
					el.addClass("active");
					/*el.find("i").removeClass("hidden");*/
				}
			}
			else
			{
				el.closest(".container-field-list-custom").find(".list-field-list-custom").removeClass("active");
				/*el.closest(".container-field-list-custom").find(".list-field-list-custom i").addClass("hidden");*/
				el.addClass("active");
				/*el.find("i").removeClass("hidden");*/
			}


			el.closest(".container-field-list-custom").find(".list-field-list-custom").each(function(i, obj) {
				if ($(obj).hasClass("active") && multiple){
					if (el_value == null){
						el_value	= [];
					}

					el_value.push($(obj).data("value"));
				}else if ($(obj).hasClass("active")){
					el_value	= $(obj).data("value");
				}
			});
			el.closest(".element-input-container").find("input").val(el_value);
		});

		// Block Text in Textbox
		/*$(document).on("click", "input[type='Text'], input[type='text']", function () {
			$(this).select();
		});*/
	};
	var handleGetFormMeta		= function () {

		if(AjaxMeta) AjaxMeta.abort();
		AjaxMeta = $.ajax({
			type: "GET",
			dataType : "JSON",
			url: $("#update-datatable").data("url") + "/get_form_meta",
			beforeSend : function(){
				$("#container-form-metadata").html("<div class='text-center'><img src='" + UrlimageLoading + "' style='width: 100px;'></div>");
			},
			data : $("#update-datatable").serialize(),
			success: function (data) {

				if (data.length)
				{
					var content	= "<div class='' style='border-left: 1px dotted #ccc; padding-left: 15px; padding-bottom: 15px;'>";
					$.each(data, function(key, row_data) {
						content	+= row_data;
					});
					content	+= "</div>";

					$("#container-form-metadata").html(content);
					Common.handleElementForm();
				}
				else
				{
					$("#container-form-metadata").html("");
				}

			},
			error: function (jqXHR, exception) {
				$("#container-form-metadata").html("");

			},
		});

	};

	return {
		initializeForm: function (){
			handleEvent();
		}
	};
}();
jQuery(document).ready(function (e) {
	Form.initializeForm();
});
