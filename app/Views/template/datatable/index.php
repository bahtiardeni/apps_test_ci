<?=$this->extend("template/apps/_layout");?>
<?=$this->section("content");?>
<?php if ($datatable->_initial->type == DATATABLE_TYPE_TABLE) { ?>
    <form method="post" id="form-datatable" data-method="<?=(!empty($datatable->_initial->other["datatable"]["protocol"]) ? $datatable->_initial->other["datatable"]["protocol"] : DATATABLE_GET)?>"  data-url="<?=(!empty($datatable->_initial->url) ? $datatable->_initial->url : "")?>" data-url-method="<?=(!empty($datatable->_initial->url_method) ? $datatable->_initial->url_method : "ajax_data")?>">
        <div class="row">
            <div class="col-lg-12">
                <div class="card <?=(!empty($is_popup) ? "mb-0" : "mb-15")?> ">
                    <div class="grid-title no-border pd-10">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-0">
                                <?=(!empty($datatable->_initial->table_button) ? $datatable->_initial->table_button : "")?>
                            </div>
                            <div class="col-lg-6 col-md-6 text-right datatable-info font-size-12" style="padding-top: 5px; padding-right: 20px;"></div>
                        </div>
                    </div>
                    <div class="card-body no-border no-padding pd-0">

                        <input type="hidden" id="datatable_start" name="q[start]" value="<?= (!empty($filter["start"]) && array_key_exists("start", $filter) ? $filter["start"] : 0) ?>">
                        <input type="hidden" id="datatable_size" name="q[size]" value="<?= (!empty($filter["size"]) ? $filter["size"] : (!empty($datatable->_initial->other["datatable"]["table_size_page"]) ? $datatable->_initial->other["datatable"]["table_size_page"] : 10)) ?>">
                        <input type="hidden" id="datatable_sort" name="q[sort]" value="<?= (!empty($filter["sort"]) && array_key_exists("sort", $filter) ? $filter["sort"] : (!empty($datatable->_initial->other["datatable"]["table_sort"]) ? $datatable->_initial->other["datatable"]["table_sort"] : "")) ?>">
                        <input type="hidden" id="datatable_sort_type" name="q[sort_type]" value="<?= (!empty($filter["sort_type"]) ? $filter["sort_type"] : (!empty($datatable->_initial->other["datatable"]["table_sort_type"]) ? $datatable->_initial->other["datatable"]["table_sort_type"] : "")) ?>">

                        <input type="hidden" id="datatable_sort_default" value="<?=(!empty($datatable->_initial->other["datatable"]["table_sort"]) ? $datatable->_initial->other["datatable"]["table_sort"] : "")?>">
                        <input type="hidden" id="datatable_sort_type_default" value="<?=(!empty($datatable->_initial->other["datatable"]["table_sort_type"]) ? $datatable->_initial->other["datatable"]["table_sort_type"] : "")?>">

                        <table id="datatable" class="display nowrap" style="width:100%">
                            <thead>
                            <tr class="tr-filter">
                                <?php $i_datatable = 0; ?>
                                <?php foreach ($datatable->_initial->fields_datatable as $i => $fields) { ?>
                                    <th data-index="<?=$i_datatable?>">
                                        <?php if ($fields->datatable->filter) { ?>
                                            <?php

                                            $param	= array(
                                                "form_type"		=> "datatable",
                                                "type"			=> $fields->type,
                                                "id"			=> $fields->name,
                                                "name"			=> "q[s][".$fields->name."]",
                                                "label"			=> !empty($fields->datatable->label) ? $fields->datatable->label : "",
                                                "value"			=> !empty($filter["s"]) && array_key_exists($fields->name, $filter["s"]) ? $filter["s"][$fields->name] : "",
                                                "attr_element"	=> array(
                                                    "data-index" => $i_datatable,
                                                    "data-field" => $fields->field
                                                ),
                                                "other"			=> $fields->other,

                                            );

                                            echo $formlib->generate_form($param);

                                            ?>
                                        <?php } ?>
                                        <?php $i_datatable++; ?>
                                    </th>
                                <?php } ?>
                            </tr>
                            <tr class="tr-sort">
                                <?php $i_datatable = 0; ?>
                                <?php foreach ($datatable->_initial->fields_datatable as $i => $fields) { ?>
                                    <th
                                        class="<?=(!empty($fields->datatable->halign) ? "text-".$fields->datatable->halign : "")?> <?=$fields->datatable->class_th?>"
                                        data-width="<?=(!empty($fields->datatable->width) ? $fields->datatable->width : "")?>"
                                        data-class-column="<?=(!empty($fields->datatable->align) ? "text-".$fields->datatable->align : "")?> <?=$fields->datatable->class_td?>"
                                        data-name="<?=$fields->name?>"
                                        data-field="<?=$fields->field?>"
                                        data-sort="<?=($fields->datatable->sort ? 1 : 0)?>"
                                        data-index="<?=$i_datatable?>"
                                        data-wrap="<?=(!empty($fields->datatable->wrap) ? 1 : 0)?>">
                                        <?=$fields->datatable->label?>
                                    </th>
                                    <?php $i_datatable++; ?>
                                <?php } ?>

                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } else if ($datatable->_initial->type == DATATABLE_TYPE_TREE) { ?>
    <form method="post" id="form-treetable" data-method="<?=(!empty($datatable->_initial->other["datatable"]["protocol"]) ? $datatable->_initial->other["datatable"]["protocol"] : DATATABLE_GET)?>" data-url="<?=(!empty($datatable->_initial->url) ? $datatable->_initial->url : "")?>" data-url-method="<?=(!empty($datatable->_initial->url_method) ? $datatable->_initial->url_method : "ajax_data")?>" >

        <div class="grid simple <?=(!empty($is_popup) ? "mb-0" : "mb-15")?>">
            <div class="grid-title no-border pd-10">
                <div class="row">
                    <div class="col-lg-8 col-md-8 mb-0">
                        <?=(!empty($datatable->_initial->table_button) ? $datatable->_initial->table_button : "")?>
                        <?php if (!empty($datatable->_initial->other["datatable"]["tree_all"])) { ?>

                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-small btn-default  btn-datatable-header btn-tree-expand" title="Expand All"><i class="fa fa-expand mr-5"></i>Expand All</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-small btn-default  btn-datatable-header btn-tree-collapse" title="Collapse All"><i class="fa fa-compress mr-5"></i>Collapse All</button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-md-4 text-right datatable-info" style="padding-top: 5px; padding-right: 20px;"></div>
                </div>
            </div>
            <div class="grid-body no-border no-padding">
                <input type="hidden" id="datatable_sort_default" value="<?=(!empty($datatable->_initial->other["datatable"]["table_sort"]) ? $datatable->_initial->fields_datatable[$datatable->_initial->other["datatable"]["table_sort"]]->name : "")?>">
                <input type="hidden" id="datatable_sort_type_default" value="<?=(!empty($datatable->_initial->other["datatable"]["table_sort_type"]) ? $datatable->_initial->other["datatable"]["table_sort_type"] : "")?>">

                <table id="treetable-<?=$datatable->_initial->name?>" class="table-treetable" style="max-height: 500px;" data-label="<?=(!empty($datatable->_initial->other["datatable"]["tree_label"]) ? $datatable->_initial->other["datatable"]["tree_label"] : "")?>" data-key="<?=(!empty($datatable->_initial->field_primary) ? $datatable->_initial->field_primary : "")?>" data-get_all="<?=(!empty($datatable->_initial->other["datatable"]["tree_all"]) ? 1 : 0)?>" data-rownumbers="<?=(!empty($datatable->_initial->other["datatable"]["tree_rownumbers"]) ? 1 : 0)?>">
                    <thead data-options="frozen:false">
                    <tr>
                        <?php foreach ($datatable->_initial->fields_datatable as $i => $fields) { ?>
                            <?php if ($fields->name == DATA_TYPE_ACTION) { ?>
                                <th data-options="field:'<?=$fields->name?>', width:50, align:'center'"><?=$fields->datatable->label?></th>
                            <?php } else { ?>
                                <th data-options="field:'<?=$fields->name?>'<?=(!empty($fields->datatable->width) ? ", width:".$fields->datatable->width : "")?><?=(!empty($fields->datatable->align) ? ", align:'".$fields->datatable->align."'" : "")?>, sortable:<?=($fields->datatable->sort ? "true" : "false")?>" data-filter="<?=($fields->datatable->filter ? "true" : "false")?>"><?=$fields->datatable->label?></th>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </form>
<?php } ?>
<?=$this->endSection();?>