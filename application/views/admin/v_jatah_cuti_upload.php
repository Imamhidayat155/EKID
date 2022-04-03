<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
        <h3 class="box-title">FORM TAMBAH DATA</h3>
        </div>
        <div class="box-body">
        <div class="row">
            <div class="col-md-8 offset-2">
                <?php echo $this->session->flashdata('notif') ?>
                <form onsubmit="return false;" id="import_form" enctype="multipart/form-data" class="text-center">
                    <div class="form-group">
                        <label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xls, .xlsx" required>
                    </div>
                    <input type="submit" name="import" value="Import" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<script src="<?=base_url()?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
    $(document).ready(function(){
        event.preventDefault();
        
        $('#import_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"<?php echo base_url(); ?>admin/import_jatah_cuti",
                method:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    $('#file').val('');
                    // load_data();
                    alert(data);
                    // location.replace('<?php echo base_url('admin/karyawan')?>');
                }
            })
        });
    });
</script>