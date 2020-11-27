const invoiceItemsRoot = $('#invoice-items-root');

let invoiceItemsCounter = 1;

$('#add-invoice-item').click(e => {
	e.preventDefault();

	if (document.getElementById('vat-exists')) {
		invoiceItemsRoot.append(`
		<tr>
			<td><input type="text" name="items[${invoiceItemsCounter}][name]" autocomplete="off"></td>
			<td><input type="number" class="amount" name="items[${invoiceItemsCounter}][amount]" autocomplete="off"></td>
			<td><input type="text" name="items[${invoiceItemsCounter}][unit]" autocomplete="off"></td>
			<td><input type="number" class="price" name="items[${invoiceItemsCounter}][price]" autocomplete="off"></td>
			<td>
				<select name="items[${invoiceItemsCounter}][vat]" class="form-control select2 select2-hidden-accessible">
					<option value="21">21%</option>
					<option value="15">15%</option>
					<option value="10">10%</option>
				</select>
			</td>
			<td>
				<button class="btn btn-danger delete"><i class="fa fa-trash"></i></button>
			</td>
		</tr>
	`)
	} else {
		invoiceItemsRoot.append(`
		<tr>
			<td><input type="text" name="items[${invoiceItemsCounter}][name]" autocomplete="off"></td>
			<td><input type="number" data-index="${invoiceItemsCounter}" class="amount" name="items[${invoiceItemsCounter}][amount]" autocomplete="off"></td>
			<td><input type="text" name="items[${invoiceItemsCounter}][unit]" autocomplete="off"></td>
			<td><input type="number" data-index="${invoiceItemsCounter}" class="price" name="items[${invoiceItemsCounter}][price]" autocomplete="off"></td>
			<td>
				<button class="btn btn-danger delete"><i class="fa fa-trash"></i></button>
			</td>
		</tr>
	`)
	}


	document.getElementsByName(`items[${invoiceItemsCounter}][name]`)[0].focus();

	invoiceItemsCounter++;
});


$(document).on("click",'.delete', function () {
	$(this).closest('tr').remove();
});
