<?=$this->extend("template/apps/_layout");?>
<?=$this->section("content");?>
    <br>
    <div class="row mt-20" style="">
        <div class="col-md-4 col-sm-12">
            <div class="card mb-10">
                <div class="card-header">Chart Pegawai (Divisi)</div>
                <div class="card-body pd-10">
                    <div id="chart_divisi" class="h-300"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card mb-10">
                <div class="card-header">Chart Pegawai (Jabatan)</div>
                <div class="card-body pd-10">
                    <div id="chart_jabatan" class="h-300"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card mb-10">
                <div class="card-header">Chart Pegawai (Jenis Kelamin)</div>
                <div class="card-body pd-10">
                    <div id="chart_gender" class="h-300"></div>
                </div>
            </div>
        </div>
    </div>
<?=$this->endSection();?>