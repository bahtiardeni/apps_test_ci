<?=$this->extend("template/apps/_layout");?>
<?=$this->section("content");?>
<div class="card">
    <div class="card-body no-border pd-10">
        <div class="row">
            <div class="col-md-6">
                <table width="100%" class="no-more-tables table-striped table-condensed table-datatable-detail">
                    <?php foreach ($data as $item) { $item = (array) $item; ?>
                        <tr>
                            <td nowrap="true" valign="top"><?=$item["label"]?></td>
                            <td valign="top" width="20" align="center">:</td>
                            <td valign="top"><b><?=$item["value"]?></b></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer pd-10">
        <a href="<?=$url_back?>" class="btn btn-sm btn-small btn-info btn-back"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
    </div>
</div>

<?=$this->endSection();?>