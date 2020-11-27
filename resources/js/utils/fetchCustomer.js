import {fetchCustomer} from "./api";

$('#customer-dropdown').change((e) => {
	e.preventDefault();

	fetchCustomer(e.target.value)
		.then(({payload}) => {

			$('#customer-data-root').removeClass('d-none');
			$('#odberatel_heading').text('ODBĚRATEL');

			$('#customer_tax_identification_number').text('');
			$('#customer_tax_identification_number_input').val('');

			$('#customer_name').text(payload.name);
			$('#customer_street').text(payload.street);
			$('#customer_city').text(payload.city);
			$('#customer_postcode').text(payload.postcode);
			$('#customer_country').text(payload.country);
			$('#customer_identification_number').text(`IČO ${payload.identification_number}`);
			if (payload.tax_identification_number) {
				$('#customer_tax_identification_number').text(`DIČ ${payload.tax_identification_number}`);
			}

			$('#customer_name_input').val(payload.name);
			$('#customer_street_input').val(payload.street);
			$('#customer_city_input').val(payload.city);
			$('#customer_postcode_input').val(payload.postcode);
			$('#customer_country_input').val(payload.country);
			$('#customer_identification_number_input').val(payload.identification_number);
			if (payload.tax_identification_number) {
				$('#customer_tax_identification_number_input').val(payload.tax_identification_number);
			}

		})
});

