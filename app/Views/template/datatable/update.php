<?=$this->extend("template/apps/_layout");?>
<?=$this->section("content");?>
<form method="post" id="update-datatable" data-url="<?= $url?>">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <?php if (!empty($forms)) { ?>
                                <?php foreach ($forms as $form) { ?>
                                    <?=$form?>
                                <?php } ?>
                            <?php }?>
                        </div>
                        <div class="col-lg-6 col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <a href="<?=$url?>" class="btn btn-sm btn-small btn-danger" id="btn-cancel"><i class="fa fa-undo"></i>&nbsp;&nbsp;BATAL</a>
                            <button type="button" class="btn btn-sm btn-small btn-primary" id="btn-save"><i class="fa fa-save"></i>&nbsp;&nbsp;SIMPAN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?=$this->endSection();?>