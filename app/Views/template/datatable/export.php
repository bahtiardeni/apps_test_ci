<?=$this->extend("template/apps/_layout");?>
<?=$this->section("content");?>
<?php
    $new_filters   = array();
    if (!empty($filter)){
        foreach ($filter  as $field => $value){
            if (isset($value) && $value != ""){
                $new_filters[$field]    = $value;
            }
        }
    }
    $filter = $new_filters;

?>
<div id="page-export">
    <form method="post" id="form-export" data-url="<?= $datatable->_initial->url ?>">
        <div class="row">
            <div class="col-lg-6">
                <div class="grid simple vertical">
                    <div class="grid-title">
                        <h4><i class="fa fa-cogs"></i>&nbsp;&nbsp;Export Setting</h4>
                        <div class="tools">
                            <a href="javascript:void(0);" class="collapse"></a>
                        </div>
                    </div>
                    <div class="grid-body" style="display: block;">
                        <div class="mb-20">
                            <?php
                            echo $formlib->generate_form(array(
                                "form_type"     => "form",
                                "type"          => DATA_TYPE_TEXTBOX,
                                "id"            => "filename",
                                "name"          => "input[filename]",
                                "label"         => "Filename",
                                "value"         => $datatable->_initial->label,
                                "attr_element"  => array(),
                                "validation"    => array()
                            ));
                            ?>
                            <div class="mb-0 form-group">
                                <div class="element-input-container">
                                    <label class="input-icheck">
                                        <input type="hidden" name="input[filename_time]" value="0">
                                        <input type="checkbox" class="flat-red" id="filename_time" name="input[filename_time]" value="1" checked>&nbsp;&nbsp;Include curent time.
                                    </label><br>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-info">Select Column</h4>
                        <div class="color-bands green"></div>
                        <div class="color-bands purple"></div>
                        <div class="color-bands red"></div>
                        <div class="color-bands blue"></div>
                        <div class="row panel-dragdrop">
                            <div class="col-lg-6 col-md-6 col-xs-6 border-right">
                                <h5 class="mb-20">Column</h5>
                                <div id="list-source" class="link-dragdrop" style="min-height: 100px;">
                                    <?php foreach ($datatable->_initial->fields as $fields) { ?>
                                        <?php
                                        $search_datatable	= $utils->search_array($datatable->_initial->fields_datatable, "name", $fields->name, true);

                                        $label  = "";
                                        if ($fields->datatable->render === true){
                                            $label = $fields->datatable->label;
                                        } else if ($fields->form->render === true){
                                            $label = $fields->form->label;
                                        }

                                        if ($search_datatable === false && $fields->field != "id_client" && !empty($label))
                                        {
                                            ?>
                                            <div class="hpanel" data-name="<?=$fields->name?>" data-label="<?=$label?>">
                                                <div class="panel-heading hbuilt" style="padding: 2px 5px;">
                                                    <div class="panel-head-sources"><?=$label?></div>
                                                    <div class="panel-head-targets"><?=$label?></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-6 border-left">
                                <h5 class="mb-20">Column Export</h5>
                                <div id="list-target" class="link-dragdrop" style="min-height: 100px;">
                                    <?php foreach ($datatable->_initial->fields_datatable as $fields) {

                                        $label  = "";
                                        if ($fields->datatable->render === true){
                                            $label = $fields->datatable->label;
                                        } else if ($fields->form->render === true){
                                            $label = $fields->form->label;
                                        }
                                        ?>

                                        <?php if ($fields->type != DATA_TYPE_ACTION && !empty($label)) { ?>
                                            <div class="hpanel" data-name="<?=$fields->name?>" data-label="<?=$label?>">
                                                <div class="panel-heading hbuilt" style="padding: 2px 5px;">
                                                    <div class="panel-head-sources"><?=$label?></div>
                                                    <div class="panel-head-targets"><?=$label?></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="grid simple vertical">
                    <div class="grid-title">
                        <h4><i class="fa fa-list"></i>&nbsp;&nbsp;Export Preview</h4>
                        <div class="tools">
                            <a href="javascript:void(0);" class="collapse"></a>
                        </div>
                    </div>
                    <div class="grid-body" style="display: block;">
                        <div class="table-responsive">
                            <table id="table-export-preview" class="display nowrap dataTable no-footer DTFC_Cloned" style="width: 99%; border: 1px solid #ddd;">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-footer">
                        <input type="hidden" name="input[filter]" id="filter" value='<?=json_encode($filter)?>'>
                        <input type="hidden" name="input[sort]" id="sort" value='<?=$sort?>'>
                        <input type="hidden" name="input[sort_type]" id="sort_type" value='<?=$sort_type?>'>
                        <input type="hidden" name="input[field]" id="field" value=''>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <a href="<?=$datatable->_initial->url?>" class="btn btn-sm btn-small btn-primary" id="btn-cancel"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                            </div>
                            <div class="col-lg-6 col-md-6 text-right">
                                <a href="javascript:void(0);" class="btn btn-sm btn-small btn-info btn-export-excel"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?=$this->endSection();?>