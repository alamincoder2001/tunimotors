<?php $i=1; foreach($getData as $row){ ?>
<tr>
	<td><?= $i++; ?></td>
	<td><?= $row->Customer_Name; ?></td>
	<td><?= $row->Product_Name; ?></td>
	<td><?= $row->EngineNo; ?></td>
	<td><?= $row->reg_fee; ?></td>
	<td><?= $row->driving_fee ; ?></td>
	<td><?= $row->laicence_fee ; ?></td>
	<td><?= $row->transfer_fee ; ?></td>
	<td><?= $row->reg_fee + $row->driving_fee + $row->others_fees + $row->laicence_fee + $row->transfer_fee ?></td>
	<td><?= $row->reg_cost + $row->driving_cost + $row->laicence_cost + $row->transfer_cost ?></td>
	<td><?php echo ($row->reg_fee + $row->driving_fee + $row->others_fees + $row->laicence_fee + $row->transfer_fee) - ($row->reg_cost + $row->driving_cost + $row->laicence_cost + $row->transfer_cost)?></td>
	<td>  
	<?php if ($row->registration_dc_type == 'B') {?>
		 <i class=" green ace-icon fa fa-check-circle bigger-130"></i>
	<?php }  ?>
       
    </td>
    <td>  
	<?php if ($row->bike_dc_type == 'R') {?>
		<i class=" green ace-icon fa fa-check-circle bigger-130"></i>
		<?php }  ?>
	</td>
    <td>  
	<?php if ($row->bike_dl_type == 'L') {?>
		<i class=" green ace-icon fa fa-check-circle bigger-130"></i>
		<?php }  ?>
	</td>
    <td>  
	<?php if ($row->bike_nt_type == 'T') {?>
		<i class=" green ace-icon fa fa-check-circle bigger-130"></i>
		<?php }  ?>
	</td>
	<td class="actions">
		<div class="hidden-sm hidden-xs action-buttons">
			<a class="green fancybox fancybox.ajax" href="<?php echo base_url() ?>editRegStatement/<?= $row->reg_id; ?>" >
				<i class="ace-icon fa fa-pencil bigger-130"></i>
			</a>

			<a class="red" href="#" onclick="deleted(<?= $row->reg_id; ?>)">
				<i class="ace-icon fa fa-trash-o bigger-130"></i>
			</a>
		</div>
	</td>
</tr>

<?php } ?>
<tr style="font-weight:bold;">
	<td colspan="8" style="text-align:right;">Total</td>
	<td style="text-align:right;"><?php echo  $getDataTotal->fee; ?></td>
	<td style="text-align:right;"><?php echo  $getDataTotal->cost;?></td>
	<td style="text-align:right;"><?php echo $getDataTotal->profit; ?></td>
</tr>