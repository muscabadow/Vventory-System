<?php 


function table_row($query){
	$colums = $query->fetch_fields();
?>

<thead>
	<tr>
		<?php
		foreach($colums as $key) {
		?>
			<th><?php echo $key->name ?></th>
		<?php 
		} 
		?>
	</tr>
</thead>

<tbody>
	<?php
	while($row = $query->fetch_assoc()){
	?>
		<tr>
			<?php 
			foreach ($row as $key => $val) {
			?>
				<td><?php echo $val ?></td>
			<?php
			}
			?>
		</tr>
	<?php
	}
	?>
</tbody>

<?php 
}
?>