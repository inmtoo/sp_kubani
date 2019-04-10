
<div class="scroll-x">
	<table class="table table-bordered table-striped">
		<tr>
			<th>ID</th>
			<th>Логин</th>
			<th>Телефон</th>
			<th>Email</th>
			<th>Дата</th>
			<th>Время</th>
		</tr>
		<?php foreach( $data['customers'] as $customer ) { ?>
		<tr>
			<td><?=$customer['id']?></td>
			<td><?=$customer['login']?></td>
			<td><?=$customer['phone']?></td>
			<td><?=$customer['email']?></td>
			<td><?=$customer['date']?></td>
			<td><?=$customer['time']?></td>
		</tr>
		<?php } ?>
	</table>
</div>
