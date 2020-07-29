<style type="text/css">
.progress.progress-sm {
    height: 3.375rem !important;
}
</style>
<script type="text/javascript" src="<?= base_url();?>assets/ui-member/js/freeze-table.js"></script>
<script type="text/javascript">
	$(function () {
		// pageHistory(1);
		TableResponsive();
	});	
	function TableResponsive(){
		$('#membership').freezeTable({
         'scrollBar': true,
         'headWrapStyles': {'top': '45px','width': '100px'},
         'columnNum' : 0,
        });

        $('#membershipHistory').freezeTable({
         'scrollBar': true,
         'headWrapStyles': {'top': '45px','width': '100px'},
         'columnNum' : 0,
        });
	}
	$( window ).resize(function() {
	  TableResponsive();
	})

  function pageHistory(pg)
  { 
    showProgres();
    $.post(base_url(1)+'/membership.member/manage/pageHistory/'+pg
      // ,{
      //   id_member :$('#id_member').val()
      // }
      ,function(result) {
        $('#tableHistory').html(result);
        hideProgres();
      }         
      ,"html"
    );
  }
</script>

<table  style="margin-bottom:0px;width: 100%">
<tbody >
    <tr >
        <th >
            <h4 > 
            	<b>Type Member : <?= $member['lisensi'] ?>, Total Penjualan : <?= $member['jumlah_barang'] ?> </b><br>
            	<code>Note : Jika member berhasil menjual minimal 15 barang, maka Type member akan diupdate menjadi PREMIUM</code>
        	</h4>
        </th>
      <!--   <th  class="text-right">
        	
        </th> -->
    </tr>
</tbody>
</table>
<div class="row">
	<div class="col-lg-12">
		<div class="d-flex justify-content-between mt-2">
          <small>FREE</small>
          <small>PREMIUM</small>
        </div>
        <div class="progress progress-sm mt-2">
          <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= (($member['jumlah_barang'] / 15) * 100).'%' ? :'0%'; ?>" aria-valuenow="<?= $member['jumlah_barang'] ?>" aria-valuemin="0" aria-valuemax="15"></div>
        </div>
	</div>
</div>
<hr style="margin-top: 4rem;">
<div class="row">
<div class="col-lg-12">
  <h5>Komisi Bulan Ini</h5></div>
<div class="col-lg-6" style="margin-bottom: 1%;">
  <div class="card text-white bg-primary text-right">
      <h6 class="card-header">Profit</h6>
      <div class="card-body pb-0">
          <h4 class="mb-0">Rp <?= number_format($komisi['profit']) ?></h4>
          <p>Omset : <?= number_format($komisi['omset_profit']) ?></p>
      </div>
  </div>
</div>
<div class="col-lg-6" style="margin-bottom: 1%;">
  <div class="card text-white bg-info text-right">
      <h6 class="card-header">Komisi Penjualan</h6>
      <div class="card-body pb-0">
          <h4 class="mb-0">Rp <?= number_format($komisi['komisi_referal'])?></h4>
          <p>Omset : <?= number_format($komisi['omset_referal']) ?></p>
      </div>
  </div>
</div>
<div class="col-lg-12" style="margin-bottom: 1%;">
  <div class="card text-white bg-warning
 text-right">
      <h6 class="card-header">Total Commission</h6>
      <div class="card-body pb-0">
          <!---->
          <h4 class="mb-0">Rp <?= number_format($komisi['profit'] + $komisi['komisi_referal'])?></h4>
          <!---->
          <p></p>
      </div>
  </div>
</div>
</div>
<!-- 
<div class="table-with-scrollbar" id="membershipHistory" style='width: 100%;'>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>Jumlah Member</th>
			<th>Tanggal</th>
			<th>Komisi Referal</th>
			<th>Komisi Penjualan</th>
			<th>Omset Penjualan</th>
		</tr>
	</thead>
	<tbody id="tableHistory">
	</tbody>
</table>
</div> -->
<br>
<div class="table-with-scrollbar" id="membership" style='width: 100%;'>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Email</th>
			<th>No Telpn</th>
			<th>Tim Member</th>
			<!-- <th>*</th> -->
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 0; 
			foreach ($list->result_array() as $row) {
				$no++;
			?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= $row['nama']?></td>
					<td><?= $row['email']?></td>
					<td><?= $row['nomor_telepon']?></td>
					<td><?= $row['total_upline1'] ?></td>
					<!-- <td>
						<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
						onclick="
						$('#id_member').val('<?= $row['id']?>');
						$('#MemberName').append(' > <a href=\'javascript:void(0)\'>'+'<?= $row['nama']; ?>'+'</a>');
						pageLoadMemberShip(1);
						
						"
						>View Detail</a>
					</td>
					 -->
				</tr>
			<?php
			}
		 ?>
	</tbody>
</table>
</div>