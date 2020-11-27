const Swal = require('sweetalert2');

$('.delete-row').on('click', function(e) {
	e.preventDefault();

	Swal.fire({
		title: 'Jste si jisti?',
		text: 'Tato akce nelze vrátit zpátky',
		icon: 'warning',
		showCancelButton: true,
		cancelButtonText: 'Zrušit',
		confirmButtonText: 'Odstranit',
		cancelButtonColor: '#3085d6',
		confirmButtonColor: '#d33'
	}).then((result) => {
		if (result.value) {
			$(this).closest('form').submit();
		}
	})
})
