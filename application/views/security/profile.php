
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
				<div align="center"><h2><strong> Selamat datang di "Izin Keluar Online 1.0"</strong></h2></div>
                <h3 class="" align="">Profile Saya | <small><a href="<?php echo base_url()?>admin/ganti_foto/<?php echo $this->session->userdata('id')?>" style="">Ganti Foto</a></small></h3>
            </div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-3 col-md-2 text-center">
						<div style="margin:0px auto; display:inline-block"><img src="<?php echo $this->config->item('link_url')?>fotoprofile/<?php echo $this->session->userdata('foto')?>" class=" img-responsive" alt="<?php echo $this->session->userdata('namauser')?>"/></div>
						<div class="clearfix"></div>
					</div>
					<?php
					$kar_id=$this->session->userdata('id');
					$sql=$this->db->get_where('m_karyawan',array('kar_id'=>$kar_id))->result_object();
					foreach($sql as $var){
					?>
					<div class="col-sm-9 col-md-10">
						<table class="table table-bordered table-striped">
							<tbody>
								<tr>
									<th width="140">Nama:</th>
									<td><?php echo $this->session->userdata('user')?></td>
								</tr>
								<tr>
									<th>Username:</th>
									<td><?php echo $var->kar_username?></td>
								</tr>
								<tr>
									<th>Password:</th>
									<td><?php echo $var->kar_password?></td>
								</tr>
								<tr>
									<th>Last Login:</th>
									<td><?php echo $var->kar_lastlogin?></td>
								</tr>					
							</tbody>
						</table>
					</div>
					<?php } ?>
				</div>
            </div>
            <div class="box-footer" align="center">
			<a class="btn btn-success btn-sm" onclick="window.location.replace('<?php echo base_url(); ?>admin/index')"><i class="fa fa-dashboard"></i> Lanjut ke Dashboard >></a>
            </div>
		</div>
	</div>
</div>