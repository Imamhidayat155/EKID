
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Profile</h3>
            </div><div class="box-body">
				<div class="row">
					<div class="col-sm-3 col-md-2 text-center">
						<div style="margin:0px auto; display:inline-block"><img src="<?php echo $this->config->item('link_url')?>fotoprofile/<?php echo $this->session->userdata('foto')?>" class="img-circle img-responsive" alt="<?php echo $this->session->userdata('namauser')?>"/></div>
						<div class="clearfix"></div>
					</div>
					<?php
					$adm_id=$this->session->userdata('id');
					$sql=$this->db->query("select *
						from m_admin
						where adm_id='$adm_id'
						")->result_object();
					foreach($sql as $var){
					?>
					<div class="col-sm-9 col-md-10">
						<table class="table table-bordered table-striped">
							<tbody>
								<tr>
									<th width="140">Nama:</th>
									<td><?php echo $this->session->userdata('namauser')?></td>
								</tr>
								<tr>
									<th>Username:</th>
									<td><?php echo $var->adm_username?></td>
								</tr>
								<tr>
									<th>Password:</th>
									<td><?php echo $var->adm_password?></td>
								</tr>
								<tr>
									<th>Last Login:</th>
									<td><?php echo $var->adm_lastlogin?></td>
								</tr>					
							</tbody>
						</table>
					</div>
					<?php } ?>
				</div>
            </div>
            <div class="box-footer">
			<a class="btn btn-default btn-sm" onclick="window.location.replace('<?php echo base_url(); ?>admin/edit_admin/<?php echo $this->session->userdata('id') ?>')"><i class="fa fa-edit"></i> Edit Profile</a>
            <a href="<?php echo base_url()?>login/logout_admin/<?php echo $this->session->userdata('id')?>" class="btn btn-warning btn-sm pull-right">Sign out</a>
            </div>
		</div>
	</div>
</div>