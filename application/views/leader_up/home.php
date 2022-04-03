<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                <?php if(isset($jml_CP)) echo $jml_CP; else echo 0; ?>
            </h3>

            <h4>Cuti Panjang</h4>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
        <div class="inner">
            <h3>
                <?php if(isset($jml_CT)) echo $jml_CT; else echo 0; ?>
            </h3>

            <h4>Cuti Tahunan</h4>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="#!" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                <?php if(isset($jml_CP_sisa_p1)) echo $jml_CP_sisa_p1; else echo 0; ?>
            </h3>

            <h4>Sisa Periode I</h4>
        </div>
        <div class="icon">
            <i class="fa fa-pencil-square"></i>
        </div>
        <a href="#" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div> -->
    <!-- <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                <?php if(isset($jml_CP_sisa_p2)) echo $jml_CP_sisa_p2; else echo 0; ?>
            </h3>

            <h4>Sisa Periode II</h4>
        </div>
        <div class="icon">
            <i class="fa fa-pencil-square"></i>
        </div>
        <a href="#" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div> -->
    
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
            <?php if(isset($jml_CP_sisa)) echo $jml_CP_sisa; else echo 0; ?> 
            </h3>
            <h4>Sisa CP</h4>
        </div>

            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url('leader_up/history_pengambilan_cuti/'.$this->session->userdata('id'))?>" class="small-box-footer">Lihat History Cuti <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <!-- AKTIFKAN SCRIP DIBAWAH JIKA CB BELUM DIOPEN -->
            <!-- <div class="inner">
                <h3>
                    <?php if(isset($jml_CT_sisa)) echo $jml_CT_sisa; else echo 0; ?>
                </h3>
                <h4>Sisa Cuti Tahunan</h4>
            </div> -->

            <!-- AKTIFKAN SCRIP DIBAWAH JIKA CB BELUM DIOPEN -->
            <div class="inner">
                <h3>
                    <?php if(isset($jml_CT_sisa2)) echo $jml_CT_sisa2 -4; else echo 0; ?> 
                </h3>
                <h4>Sisa CT</h4>
            </div>

            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url('leader_up/history_pengambilan_cuti/'.$this->session->userdata('id'))?>" class="small-box-footer">Lihat History Cuti <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
        <div class="inner">
            <h3>
                <?php if(isset($sisa_CT_tahun_lalu)) echo $sisa_CT_tahun_lalu; else echo 0; ?>
            </h3>

            <h4>Sisa CT Tahun Lalu</h4>
        </div>
        <div class="icon">
            <i class="fa fa-check"></i>
        </div>
        <a href="#!" class="small-box-footer tombol-info-cuti-tahun-lalu">Klik Disini ! <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
        <div class="inner">
            <h3>
                <?php if(isset($jml_CB)) echo $jml_CB; else echo 0; ?>
            </h3>

            <h4>Cuti Bersama</h4>
        </div>
        <div class="icon">
            <i class="fa fa-pencil-square"></i>
        </div>
        <a href="#!"  class="small-box-footer tombol-info-cuti-bersama">Klik Disini ! <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    
    
    <!-- /.row (main row) -->
    
</div>
</section>
<!-- /.content -->