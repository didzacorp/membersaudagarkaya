<span class="card-title">My Lead
<a href="javascript:void(0)" class="btn btn-info btn-sm pull-right" style="text-align: right;" onclick="inputLead()"> Tambah Lead</a>
</span>
<br>
<br>
<script type="text/javascript" src="<?= base_url();?>assets/ui-member/js/freeze-table.js"></script>
<script type="text/javascript">
	$(function () {
		TableResponsive();
	});	
	function TableResponsive(){
		$('#lead').freezeTable({
         'scrollBar': true,
         'headWrapStyles': {'top': '45px','width': '100px'},
         'columnNum' : 0,
        });
	}
	$( window ).resize(function() {
	  TableResponsive();
	})
</script>
<div class="table-with-scrollbar" id="lead" style='width: 100%;'>
<table class="table table-bordered table-hover menu">
	<thead>
		<tr>
			<th style="width: 1%; font-weight: bold;">No </th>
			<th style="font-weight: bold;">Nama</th>
			<th style="font-weight: bold;">Email</th>
			<th style="font-weight: bold;">Tanggal</th>
			<th style="font-weight: bold;">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no = 0;
		$status = '';
		foreach($list->result_array() as $row)
		{
			$no++;
		?>
		<tr>
			<td><?= $no?></td>
			<td><?=$row['nama']?></td>
			<td><?=$row['email']?></td>
			<td><?=humanize_date($row['tanggal_join'])?></td>			
			<td style="text-align: center;"><?=$row['status']?></td>			
		</tr>
		<?php }?>
	</tbody>
	
</table>
<?=$paging['list']?>
</div>