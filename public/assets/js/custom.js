document.getElementById('country_id').addEventListener('change', function () {
    var countryId = this.value;
    var citySelect = document.getElementById('city_id');
    citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

    if (countryId) {
        fetch(`/countries/${countryId}/cities`)
            .then(response => response.json())
            .then(data => {
                data.cities.forEach(function (city) {
                    var option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
});


// $(document).ready(function () {
//     $('#example').DataTable({
//         dom: 'Bfrtip',
//         buttons: [
//             'excel', 'pdf', 'print'
//         ]
//     });
// });
