var elDatatable;
var elTreeTable;
var base_url;
var Datatable = function(){
	var Ajax, datatable, tmpImport, tmpSearch;
	var UrlimageLoading = base_url + "/public/images/loader.gif";

	var tmpImportHeader;
	var tmpImportData;
	var tmpImportFields;
	var is_popup;

	var handleDataTable 			= function () {
		var element = $("#form-datatable");

		if (element.length)
		{
			if (element.closest("#modal-detail").length) {
				is_popup	= true;
			} else {
				is_popup	= false;
			}

			// Default Sort
			var sort        	= element.find("#datatable_sort").val();
			var sort_type   	= element.find("#datatable_sort_type").val();
			var start       	= parseInt(element.find("#datatable_start").val());
			var length      	= parseInt(element.find("#datatable_size").val());
			var el_th       	= element.find("#datatable thead tr")[1];
			var disabled_sort   = [];
			var cell_wrap   	= [];
			var columns_options	= [];
			var protocol	= element.attr("data-method");

			$(el_th).find("th").each(function (column_index, el) {
				columns_options[column_index] = {};
				var index_datatable = $(el).data("index");


				if (sort == index_datatable){
					sort = column_index;
				}

				if (!$(el).data("sort"))
				{
					disabled_sort.push(index_datatable);
				}

				if ($(el).data("freeze"))
				{
					freeze.push(index_datatable);
				}

				if ($(el).data("wrap"))
				{
					cell_wrap.push(index_datatable);
				}

				var column_class	= $(el).data("class-column");
				var column_width	= $(el).data("width");

				if (column_width != "")
				{
					columns_options[column_index].width 	= column_width + "px";
				}

				var column_wrap		= $(el).data("wrap");

				if (column_wrap != undefined && column_wrap == 1)
				{
					column_class	+= " column_wrap ";
				}
				columns_options[column_index].className = column_class;
			});

			sort            		= parseInt(sort);
			var datatableUrl		= element.data("url");
			var datatableUrlMethod	= element.data("url-method");

			if (datatableUrlMethod != undefined && datatableUrlMethod != "")
			{
				datatableUrl	= datatableUrl + "/" + datatableUrlMethod;
			}
			else
			{
				datatableUrl	= datatableUrl + "/ajax_data";
			}

			var options     = {
				"ajax"				: {
					"url"	: datatableUrl,
					"data"	: function(d){
						d.filters	= handleDatatableFilters()
					},
					"type"	: protocol
				},
				"deferLoading"      : true,
				"processing"		: true,
				"serverSide"		: true,
				"searching"			: true,
				"info"				: true,
				"scrollY"			: "50vh",
				"scrollX"			: true,
				"scrollCollapse"	: true,
				/*"dom"				: '<"datatable_info"i><"top">rt<"bottom pd-10 mt-5"<"row"<"col-lg-4 col-md-4 mb-10"l><"col-lg-8 col-md-8 mb-10"p>>><"clear">',*/
				"order"				: [[ sort, sort_type ]],
				"columnDefs"		: [
					{ "orderable": false, "targets": disabled_sort }
				],
				"columns"			: columns_options,
				"displayStart"		: start,
				"pageLength"		: length,
				"autoWidth"			: false,
				"language"			: {
					"processing": "<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>",
					"sInfoFiltered": "(filtered from _MAX_ total records)",
					"info": "Showing _START_ to _END_ of _TOTAL_ entries",
					"lengthMenu": "_MENU_"
				},
				"drawCallback"		: function (settings) {
					var response = settings.json;
					handleDataTableFormatter(response);

					$("#datatable").find("tbody tr").each(function () {
						var hash	= $(this).find(".btn-datatable-action").attr("data-hash");
						$(this).attr("data-hash", hash);
					});

					if (is_popup) {
						$(".btn-datatable-action").remove();
					}

				}
			};

			if (is_popup){
				options.dom		= '<"datatable_info"i><"top">rt<"bottom pd-5"<"row"<"col-lg-4 col-md-4 mb-0"l><"col-lg-8 col-md-8 mb-0"p>>><"clear">';
			} else {
				options.dom		= '<"datatable_info"i><"top">rt<"bottom pd-10 mt-5"<"row"<"col-lg-4 col-md-4 mb-10"l><"col-lg-8 col-md-8 mb-10"p>>><"clear">';
			}

			datatable   	= $("#datatable").DataTable(options);

			handleEventDatatable(element);
			handleDatatableDraw(element, false);

			elDatatable = datatable;
		}
	};
	var handleDatatableFilters		= function () {
		var filters			= {};

		if ($("#datatable_filters").length){
			filters	= $("#datatable_filters").val();
		}

		return filters;
	};
	var handleDatatableDraw 		= function (element, clear_all) {
		$("div.dataTables_length select").addClass( "form-control input-sm" );

		element.find(".dataTables_scrollHead thead tr.tr-filter th").each(function()
		{
			var cel_index	= $(this).data("index");
			var cel_field	= $(this).data("field");
			var cel_value	= "";


			if ($(this).find("input").length)
			{
				cel_index	= $(this).find("input").data("index");

				if (clear_all == true)
				{
					cel_value	= "";
					$(this).find("input").val("");
				}
				else
				{
					cel_value	= $(this).find("input").val();
				}
			}
			else if ($(this).find("select").length)
			{
				cel_index	= $(this).find("select").data("index");

				if (clear_all == true)
				{
					cel_value	= "";
					$(this).find("select").val("").trigger('change.select2');
				}
				else
				{
					cel_value	= $(this).find("select").val();
				}
			}

			if (cel_value != "" && cel_value != undefined && cel_value != null && cel_index != undefined)
			{
				datatable
					.column(cel_index)
					.search(cel_value);
			}
			else
			{
				datatable
					.column(cel_index)
					.search("");
			}
		});

		datatable.draw();
		setTimeout(function () {
			datatable.columns.adjust();
			$(".dataTables_scrollHead thead tr.tr-filter th input").attr("style", "width: 100%");

		}, 500);

	};
	var handleEventDatatable		= function (element) {

		datatable.on("preXhr.dt", function ( e, settings, data ) {
			var table_height = $(".dataTables_scrollBody").height();
			$(".dataTables_processing").css("height", (table_height) + "px");
			$(".dataTables_processing").css("margin-top", "16px");
			$(".dataTables_processing").css("padding-top", ((table_height / 2) - 20)+ "px");
		} );
		datatable.on("draw.dt", function () {
			var info_content    = $(".datatable_info");

			var datatable_order     = datatable.order()[0];
			var datatable_info      = datatable.page.info();
			var datatable_data      = datatable.page.info();

			element.find(".datatable-info").addClass("hidden-xs").text(info_content.text());
			element.find("#datatable_sort").val(datatable_order[0]);
			element.find("#datatable_sort_type").val(datatable_order[1]);
			element.find("#datatable_start").val(datatable_info.start);
			element.find("#datatable_size").val(datatable_info.length);
			info_content.addClass("hidden");

			$(".dataTables_scrollBody").find("thead tr.tr-filter").remove();

			var url_param	= element.serialize();
			var new_url = document.location.origin + document.location.pathname + "?" + url_param;
			history.pushState({}, "", new_url);
			var new_url	= $("#form-datatable").data("url") + "/export?" + url_param;
			$(".btn-export").attr("href", new_url);

			setTimeout(function () {
				datatable.columns.adjust();
			}, 500);
			handleDatatableButtonAction();

		} );
		datatable.on("click", "tbody tr", function (e) {
			if (is_popup) {
				e.currentTarget.classList.toggle("selected");
			}
		});

		element.on("click", ".btn-clear-filter", function () {

			var sort_default 		= $("#datatable_sort_default").val();
			var sort_type_default 	= $("#datatable_sort_type_default").val();

			element.find("#datatable_sort").val(sort_default);
			element.find("#datatable_sort_type").val(sort_type_default);
			element.find("#datatable_start").val(0);
			element.find("#datatable_size").val(10);

			datatable.order([sort_default, sort_type_default]);

			handleDatatableDraw(element, true);
		});
		element.on("click", ".btn-datatable-refresh", function () {
			handleDatatableDraw(element);
		});
		/*element.find("tbody").on( 'click', 'tr', function () {
			$(this).toggleClass('selected');
		} );*/
		$(document).on("click", ".btn-delete", function () {

			var type    = $(this).data("type");
			var hash    = $(this).data("id");
			var url     = "";

			if (type == "tree"){
				url = $("#form-datatable-tree").data("url") + "/delete";
			}else{
				url = $("#form-datatable").data("url") + "/delete";
			}

			$.confirm({
				icon: "fa fa-warning",
				title: "Hapus Data",
				content: "Apakah Anda yakin akan menghapus data ini?",
				buttons: {
					info: {
						btnClass: "btn-default",
						text: "<i class='fa fa-fw fa-undo'></i> Batal",
						action: function(){

						}
					},
					danger: {
						btnClass: "btn-primary any-other-class",
						text: "<i class='fa fa-fw fa-trash-o'></i> Ya, Hapus!!",
						action: function(){
							Common.handleClearNotification();
							$.ajax({
								url: url,
								type: "POST",
								dataType: "JSON",
								data: {
									id : hash
								},
								beforeSend : function () {
									Common.handleLoadingScreen();
								},
								success: function (res) {
									Common.handleCloseLoadingScreen();

									if (res.result == "success"){
										Common.handleNotificationSuccess(res.message);

										if (type == "tree"){
											elTreeTable.treegrid("reload");
											/*handleTreeTable();*/
										}else{
											datatable.draw();
										}

									}else{
										Common.handleNotificationError(res.message);
									}


								},
								error: function (jqXHR, exception) {

								}
							});

						}
					},
				}
			});
		});
		$(document).on("click", ".btn-datatable-detail", function () {

			var hash    = $(this).data("id");
			var url     = $("#form-datatable").data("url") + "/detail";

			$.ajax({
				url: url,
				type: "GET",
				dataType: "JSON",
				data: {
					hash : hash
				},
				beforeSend : function () {
					$("#modal-detail").modal("show");
					$("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
					$("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
				},
				success: function (res) {

					$("#modal-detail .modal-dialog").addClass("modal-lg");
					$("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
					$("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
					$("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);

					if (res.footer.length){
						$("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
					}else{
						$("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
					}

				},
				error: function (jqXHR, exception) {

				}
			});

		});

		$(datatable.table().container()).on("keyup", "thead tr th input", delay(function (e) {
			handleDatatableDraw(element, false);
		}, 1000));
		$(datatable.table().container()).on("apply.daterangepicker", "thead tr th input.input-daterangepicker", function (ev, picker) {
			$(this).val(picker.startDate.format("YYYY-MM-DD") + " - " + picker.endDate.format("YYYY-MM-DD"));
			handleDatatableDraw(element, false);
		});
		$(datatable.table().container()).on("apply.daterangepicker", "thead tr th input.input-timerangepicker", function (ev, picker) {

			$(this).val(picker.startDate.format("HH:ii:ss") + " - " + picker.endDate.format("HH:ii:ss"));
			handleDatatableDraw(element, false);
		});
		$(datatable.table().container()).on("change", "thead tr th select", function (e) {
			handleDatatableDraw(element, false);
		});

		$(".dataTables_scrollBody").find("thead tr.tr-filter th").each(function () {
			$(this).find("input").removeAttr("id");
			$(this).find("select").removeAttr("id");
		});
		/*$(".dataTables_scrollBody").find("thead tr.tr-filter").remove();*/
	};
	var handleDatatableButtonAction	= function () {
		$(".material-menu").remove();
		$.each($(".btn-datatable-action"), function (i, element) {

			var dataContent	= $(element).parent().find("input").val();

			if (dataContent != undefined)
			{
				dataContent		= JSON.parse(dataContent);
				var itemMenu	= [];
				var items		= [];

				$.each(dataContent, function (i, item) {

					var attr_element	= "";

					$.each(item.attr, function (attr, attrvalue) {
						attr_element	+= attr + "='" + attrvalue + "'";
					});
					var contentItem	= "<a href='" + item.url + "' class='" + item.class + "' " + attr_element + "><i class='" + item.icon + "'></i>&nbsp;&nbsp;" + item.label + "</a>";

					items.push({
						type	: "normal",
						text	: contentItem
					});
				});

				$(element).materialMenu('init', {
					position: 'overlay',
					items: items,
					animationSpeed : 0
				}).click(function () {
					$(this).materialMenu('open');
				});
			}


		});

	};
	var handleDataTableFormatter	= function (res) {
		// Background columns Color
		if (res != undefined && res.other.bgcolor != undefined)
		{
			$.each(res.other.bgcolor, function (i, item) {
				$($(".dataTables_scrollBody #datatable tbody tr").get(i)).attr("style", "background-color: #"+item.bgcolor+" !important;");
			});
		}
	};


	var handleTreeTable				= function () {
		var element 			= $("#form-treetable");

		if (element.length)
		{
			var element_id			= element.find("table").attr("id");
			var element_table		= $("#" + element_id);

			$(document).on("click", ".btn-datatable-refresh", function () {
				element_table.treegrid('reload');
			});
			$(document).on("click", ".btn-clear-filter", function () {
				element_table.treegrid("removeFilterRule");
				element_table.treegrid("load");
			});
			$(document).on("click", ".btn-tree-expand", function () {
				element_table.treegrid("expandAll");
			});
			$(document).on("click", ".btn-tree-collapse", function () {
				element_table.treegrid("collapseAll");
			});
			$(document).on("click", ".btn-datatable-detail", function () {

				var hash    = $(this).data("id");
				var url     = element.data("url") + "/detail";

				$.ajax({
					url: url,
					type: "GET",
					dataType: "JSON",
					data: {
						hash : hash
					},
					beforeSend : function () {
						$("#modal-detail").modal("show");
						$("#modal-detail .modal-dialog .modal-content .modal-header h4").html("Please wait...");
						$("#modal-detail .modal-dialog .modal-content .modal-body").html("<center class='image-loading'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></center>");
					},
					success: function (res) {

						$("#modal-detail .modal-dialog").addClass("modal-lg");
						$("#modal-detail .modal-dialog .modal-content .modal-header h4").html(res.title);
						$("#modal-detail .modal-dialog .modal-content .modal-body").html(res.content);
						$("#modal-detail .modal-dialog .modal-content .modal-footer").html(res.footer);

						if (res.footer.length){
							$("#modal-detail .modal-dialog .modal-content .modal-footer").removeClass("hidden");
						}else{
							$("#modal-detail .modal-dialog .modal-content .modal-footer").addClass("hidden");
						}

					},
					error: function (jqXHR, exception) {

					}
				});

			});

			var datatableUrl		= element.data("url");
			var datatableUrlMethod	= element.data("url-method");

			if (datatableUrlMethod != undefined && datatableUrlMethod != "") {
				datatableUrl	= datatableUrl + "/" + datatableUrlMethod;
			} else {
				datatableUrl	= datatableUrl + "/ajax_data";
			}

			var treeKey			= element_table.attr("data-key");
			var treeField		= element_table.attr("data-label");
			var treeGetAll		= element_table.attr("data-get_all");
			var treeRowNumbers	= element_table.attr("data-rownumbers");

			var sort_default		= $("#datatable_sort_default").val();
			var sort_type_default	= $("#datatable_sort_type_default").val();

			var tree_options		= {
				url				: datatableUrl,
				method			: "GET",
				idField			: treeKey,
				treeField		: treeField,
				/*fitColumns		: true,*/
				singleSelect	: true,
				AutoSizeColumns	: false,
				pagination		: true,

				clientPaging	: false,
				/*remoteFilter	: true,*/
				rownumbers		: false,
				sortName		: sort_default,
				sortOrder		: sort_type_default,
				queryParams     : {

				},
				emptyMsg		: "No Data found.",
				onLoadSuccess	: function () {
					handleDatatableButtonAction();

					$(".datagrid-view2 tr.datagrid-filter-row").find("td").each(function (i, a) {

						var enable_filter	= $($(".table-treetable thead tr th")[i]).attr("data-filter");
						enable_filter		= enable_filter = undefined ? false : enable_filter;

						if ($(this).find("input").length)
						{
							if (enable_filter == "true")
							{
								var label 	= $($(".datagrid-view2 tr.datagrid-header-row:not(.datagrid-filter-row)").find("td")[i]).text();
								$(this).find("input").attr("placeholder", "Search");
							}
							else
							{
								$(this).find("input").remove();
							}
						}
					});
				}
			};
			var param				= element.data("param");

			$.each(param, function (key, value) {
				tree_options.queryParams[key]	= value;
			});

			if (treeRowNumbers == 1){
				tree_options.rownumbers		= true;
			}

			if (treeGetAll == 1)
			{
				tree_options.pagination		= false;
				/*tree_options.data			= [];*/

				/*delete tree_options[Object.keys(tree_options)[0]];
				delete tree_options[Object.keys(tree_options)[1]];*/

				elTreeTable				= element_table.treegrid(tree_options);
			}
			else
			{
				elTreeTable				= element_table.treegrid(tree_options);
			}



			/*elTreeTable.treegrid("enableFilter");*/

			/*elTreeTable.treegrid("disableFilter", [{
				field	: "name"
			}]);*/

		}
	};


	// Page Import
	var handlePageImport			= function () {

		var element	= $("#page-import");

		if (element.length)
		{
			var navListItems 	= $('ul.setup-panel li a');
			var allWells 		= $('.setup-content');
			allWells.hide().eq(0).show();

			// Event
			$(".btn-move-panel").on('click', function(e) {
				var step = $(this).data("step");

				handleMoveForm((step - 1), step);
			});
			element.on("click", ".btn-file-import", function () {
				var el          = $(this);
				var el_form		= el.data("id");

				$("." + el_form).find(".input-file-import").click();
			});
			element.on("change", ".input-file-import", function (e) {

				var el          = $(this);
				var type        = el.attr("data-type");
				var field       = el.attr("data-field");

				var file_data   = el.prop('files')[0];
				var form_data   = new FormData();
				form_data.append('file', file_data);

				el.parent().parent().removeClass("has-error");
				el.parent().parent().find(".help-block").text("");

				$.ajax({
					url: element.data("url") + "/import_upload/",
					type: "POST",
					dataType: "JSON",
					data: form_data,
					processData: false,
					contentType: false,
					beforeSend: function(){
						Common.handleLoadingScreen();

					},
					success: function (res) {
						Common.handleCloseLoadingScreen();

						if (res.result == "error")
						{
							$(".form-field-input_file").addClass("has-error");
							$(".form-field-input_file").find(".help-block").html('<i class="fa fa-warning"></i>&nbsp;&nbsp;' + res.message);
						}
						else
						{
							$(".input-file-import").val("");
							handleMoveForm(1, 2);
						}

					},
					error: function (res) {

					}
				});
			});
			element.on("click", ".btn-import-save", function () {
				$.confirm({
					icon: "fa fa-save",
					title: "Save Data",
					content: "Are you sure import this data?",
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
									url: element.data("url") + "/import_save",
									type: "POST",
									dataType: "JSON",
									data: $("#form-import-data").serialize(),
									beforeSend: function () {
										Common.handleLoadingScreen();
									},
									success: function (res) {
										Common.handleCloseLoadingScreen();

										if (res.result == "error")
										{
											Common.handleNotificationError(res.message);
										}
										else if (res.result == "success")
										{
											handleMoveForm(3, 4, res.message);

										}
									},
									error: function (jqXHR, exception) {

									}
								});

							}
						},
					}
				});

			});

			$(document).on('ifChecked ifUnchecked', ".ids_all", function(event) {

				if (event.type == 'ifChecked') {
					$(".ids_data").iCheck('check');
				} else {
					$(".ids_data").iCheck('uncheck');
				}
			});
			$(document).on('ifChanged', ".ids_data", function(event){

				if($(".ids_data").filter(':checked').length == $(".ids_data").length) {
					$(".ids_all").prop('checked', 'checked');
				} else {
					$(".ids_all").removeProp('checked');
				}
				$(".ids_all").iCheck('update');
			});


		}

	};
	var handleMoveForm				= function (prev_step, next_step, param) {

		if (next_step == 3 && prev_step == 2){
			handleIUpdateImport();
		}

		$(".setup-panel li").removeClass("active").addClass("disabled");
		$(".setup-panel li.head-" + next_step).removeClass("disabled").addClass("active");

		$(".setup-content").hide();
		$("#step-" + next_step).show();

		if (next_step == 2){
			handleGetImport("header");
		} else if (next_step == 3){
			handleGetImport("body");
		} else if (next_step == 4){

			$("#import-result").html(param);

			var options     = {
				"deferLoading"      : true,
				"processing"		: true,
				"searching"			: false,
				"info"				: false,
				"scrollY"			: "36vh",
				"scrollX"			: true,
				"scrollCollapse"	: true,
				"autoWidth"			: false,
				"language"			: {
					"processing": "<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>",
					"sInfoFiltered": "(filtered from _MAX_ total records)",
					"info": "Showing _START_ to _END_ of _TOTAL_ entries",
					"lengthMenu": "_MENU_"
				},
				"paging"			: false,
				"ordering"			: false,
				"fixedColumns"      : {
					"leftColumns": 1
				},

			};
			var datatable_result   = $("#table-import-result").DataTable(options);

			setTimeout(function () {
				datatable_result.columns.adjust();
			}, 500);

		}

	};

	var handleGetImport				= function (type) {
		var element	= $("#page-import");
		$.ajax({
			url: element.data("url") + "/get_import_data/" + type,
			type: "GET",
			dataType: "JSON",
			processData: false,
			contentType: false,
			beforeSend : function(){
				$("#import-" + type).html("<div class='text-center pd-25'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></div>");
			},
			success: function (res) {
				$("#import-" + type).html(res.content);

				if (res.result == "success")
				{
					if (type == "body")
					{
						var options     = {
							"deferLoading"      : true,
							"processing"		: true,
							"searching"			: false,
							"info"				: false,
							"scrollY"			: "36vh",
							"scrollX"			: true,
							"scrollCollapse"	: true,
							"autoWidth"			: false,
							"language"			: {
								"processing": "<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>",
								"sInfoFiltered": "(filtered from _MAX_ total records)",
								"info": "Showing _START_ to _END_ of _TOTAL_ entries",
								"lengthMenu": "_MENU_"
							},
							"paging"			: false,
							"ordering"			: false,
							"fixedColumns"      : {
								"leftColumns": 1
							},

						};
						var datatable   = $("#table-import-preview").DataTable(options);

						setTimeout(function () {
							datatable.columns.adjust();
						}, 500);

						if ($("#table-import-preview tbody tr").length){
							$(".btn-import-save").removeClass("hidden");
						}else{
							$(".btn-import-save").addClass("hidden");
						}
					}
				}

				Common.handleElementForm();
			},
			error: function (res) {

			}
		});
	};
	var handleIUpdateImport			= function () {
		var element	= $("#page-import");
		$.ajax({
			url: element.data("url") + "/update_import_data/",
			type: "POST",
			dataType: "JSON",
			data: $("#form-import").serialize(),
			success: function (res) {

			},
			error: function (res) {

			}
		});
	};
	var handleGetImportData			= function () {

		var element	= $("#page-import");

		$.ajax({
			url: element.data("url") + "/import_get_data/",
			type: "GET",
			dataType: "JSON",
			processData: false,
			contentType: false,
			beforeSend : function(){
				$("#import-header").html("<div class='text-center borders pd-25'><img src='" + UrlimageLoading + "' style='width: 70px; margin: 10px;' /></div>");
			},
			success: function (res) {
				$("#import-header").html(res.content);


				Common.handleElementForm();


				$(".panel-footer").removeClass("hidden");
				var options     = {
					"deferLoading"      : true,
					"processing"		: true,
					"searching"			: false,
					"info"				: false,
					"scrollY"			: "36vh",
					"scrollX"			: true,
					"scrollCollapse"	: true,
					"autoWidth"			: false,
					"language"			: {
						"processing": "<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>",
						"sInfoFiltered": "(filtered from _MAX_ total records)",
						"info": "Showing _START_ to _END_ of _TOTAL_ entries",
						"lengthMenu": "_MENU_"
					},
					"paging"			: false,

					"fixedColumns"      : {
						"leftColumns": 1
					},

				};
				var datatable   = $("#table-import-preview").DataTable(options);

				setTimeout(function () {
					datatable.columns.adjust();
				}, 500);

				/*handleRanderDataImport(res);*/
			},
			error: function (res) {

			}
		});
	}
	var handleRanderDataImport		= function (response) {
		$("#input_filename").val(response.file);

		tmpImport	= response;

		var headers	= response.data.header;
		var columns	= response.data.values;
		var fields	= response.fields;

		var content			= "";
		var head_1			= "";
		var head_2			= "";
		var bodies			= "";
		var field_option	= "<option value=''>Select</option>";

		$.each(fields, function (i, field) {

			if (field.source_type != undefined && field.source_type != "" && field.source_type != null && field.type != "ID")
			{
				field_option	+= "<option value='" + field.id + "'>" + field.form.label + "</option>";
			}

		});

		head_1	+= "<tr>";
		head_1	+= "<th style='height: 32px;'>&nbsp;&nbsp;Select Field&nbsp;&nbsp;<i class='fa fa-arrow-right text-info'></i>&nbsp;&nbsp;</th>";
		head_2	+= "<tr>";
		head_2	+= "<th width='50' class='text-center'><input type='checkbox' checked id='check_all'></th>";

		$.each(headers, function (key, head) {
			head_1	+= "<th class=''><select class='input-select2' name='input[field][" + key + "]'>" + field_option + "</select></th>";
			head_2	+= "<th class='text-center'>" + head + "</th>";
		});

		head_1	+= "</tr>";
		head_2	+= "</tr>";

		$.each(columns, function (i, column) {
			bodies	+= "<tr>";

			bodies	+= "<td class='text-center'><input type='checkbox' name='input[data][]' checked value='" + i + "'></td>";

			$.each(column, function (key, item) {
				bodies	+= "<td>" + item + "</td>";
			});

			bodies	+= "</tr>";
		});

		content	+= "<table id='table-import-preview' class='display nowrap dataTable' style='width: 100%; border-top: 1px solid #ddd; border-left: 1px solid #ddd;box-sizing: border-box;'>";
		content	+= "<thead>";
		content	+= head_1;
		content	+= head_2;
		content	+= "</thead>";
		content	+= "<tbody>";
		content	+= bodies;
		content	+= "</table>";

		$("#import-result").html(content);
		$(".panel-footer").removeClass("hidden");

		var options     = {
			"deferLoading"      : true,
			"processing"		: true,
			"searching"			: false,
			"info"				: false,
			"scrollY"			: "36vh",
			"scrollX"			: true,
			"scrollCollapse"	: true,
			"autoWidth"			: false,
			"language"			: {
				"processing": "<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>",
				"sInfoFiltered": "(filtered from _MAX_ total records)",
				"info": "Showing _START_ to _END_ of _TOTAL_ entries",
				"lengthMenu": "_MENU_"
			},
			"paging"			: false,

			"fixedColumns"      : {
				"leftColumns": 1
			},

		};

		var datatable   = $("#table-import-preview").DataTable(options);

		setTimeout(function () {
			datatable.columns.adjust();
		}, 500);


	};

	// Page Export
	var handlePageExport		= function () {

		var element	= $("#page-export");

		if (element.length)
		{
			$("#list-source, #list-target").sortable({
				tolerance: "pointer",
				connectWith: ".link-dragdrop",
				forcePlaceholderSize: true,
				opacity: 0.8,
				stop: function(e, ui) {

					/*var height_sources	= $("#list-source").height();
					var height_targets	= $("#list-target").height();

					if (height_sources > height_targets)
					{
						$(".link-dragdrop").css("height", height_sources + "px");
					}
					else
					{
						$(".link-dragdrop").css("height", height_targets + "px");
					}*/

					handlePreviewExport();
				}
			}).disableSelection();
			element.on("keyup", "#filename", delay(function (e) {
				handlePreviewExport();
			}, 100));
			element.on("keyup", "#filename", delay(function (e) {
				handlePreviewExport();
			}, 100));
			element.on('ifChecked ifUnchecked', "#filename_time", function(event) {

				if (event.type == 'ifChecked') {
					$("#filename_time").iCheck('check');
				} else {
					$("#filename_time").iCheck('uncheck');
				}

				handlePreviewExport();
			});

			handlePreviewExport();
		}

	};
	var handlePreviewExport		= function (e) {

		var list_element	= $("#list-target");
		var list_table		= $("#table-export-preview");
		var data_field		= [];
		var data_filter		= null;
		var data_sort		= null;
		var data_sort_type	= null;
		var filename		= null;
		var filename_time	= null;


		list_table.find("thead").html("<tr></tr>");
		list_table.find("tbody").html("");
		list_element.find(".hpanel").each(function () {
			var text_head 	= $(this).data("label");
			var data_name	= $(this).data("name");
			list_table.find("thead tr").append("<th class='text-center'>" + text_head + "</th>");

			data_field.push(data_name);
		});

		for (var i = 1; i <= 5; i++)
		{
			var tr_content	= "";

			tr_content	+= "<tr>";
			list_element.find(".hpanel").each(function () {

				tr_content	+= "<td class='text-center text-muted'>..............</td>";
			});
			tr_content	+= "</tr>";

			list_table.find("tbody").append(tr_content);
		}

		$("#field").val(JSON.stringify(data_field));

		data_field		= encodeURIComponent(JSON.stringify(data_field));
		data_filter		= $("#filter").val();
		data_sort		= $("#sort").val();
		data_sort_type	= $("#sort_type").val();
		filename		= $("#filename").val();
		filename_time	= $("#filename_time:checked").val();
		filename_time	= filename_time != undefined ? 1 : 0;

		var url_param	= "?filter=" + data_filter + "&field=" + data_field + "&sort=" + data_sort + "&sort_type=" + data_sort_type + "&filename=" + filename + "&filename_time=" + filename_time;

		$(".btn-export-excel").attr("href", $("#form-export").data("url") + "/exports/excel" + url_param);
		$(".btn-export-pdf").attr("href", $("#form-export").data("url") + "/exports/pdf" + url_param);
	};

	return {
		initializeDatatable: function (refresh_data) {
			handleDataTable();
			handlePageImport();
			handlePageExport();

			handleTreeTable();

			Common.handleElementForm();
		},
		initializeRefreshData: function () {
			$("#datatable").DataTable().ajax.reload(null, false);
		}
	};
}();
jQuery(document).ready(function (e) {
	Datatable.initializeDatatable();
});
