// document.getElementById('country_id').addEventListener('change', function () {
//     var countryId = this.value;
//     var citySelect = document.getElementById('city_id');
//     citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities
    
//     if (countryId) {
//         fetch(`/countries/${countryId}/cities`)
//             .then(response => response.json())
//             .then(data => {
//                 data.cities.forEach(function (city) {
//                     var option = document.createElement('option');
//                     option.value = city.id;
//                     option.textContent = city.name;
//                     citySelect.appendChild(option);
//                 });
//             })
//             .catch(error => console.error('Error fetching cities:', error));
//     }
// });


function Selectcountry()
{
    var countryId = document.getElementById('country_id').value;
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
}


function SelectLoan(employeeId)
{
    var employeeId = employeeId;
    var citySelect = document.getElementById('loan_advance');
    
    if (employeeId) {
        fetch(`/getloan/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                citySelect.value = data.loan['amount'];
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}


function SelecLeaves(employeeId)
{
    var employeeId = employeeId;
    var auth_leave = document.getElementById('auth_leave');
    var unauth_leave = document.getElementById('unauth_leave');
    var approved_with_pay = document.getElementById('approved_with_pay');
    
    if (employeeId) {
        fetch(`/getapprovedleaves/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.leaves !== null) {
                    auth_leave.value = data.leaves['days'];
                }
                else
                {
                    auth_leave.value = 0;
                }
             
            })
            .catch(error => console.error('Error fetching cities:', error));

            fetch(`/getunauthleaves/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.leaves !== null) {
                    unauth_leave.value = data.leaves['days'];
                }
                else
                {
                    unauth_leave.value = 0;
                }
             
            })
            .catch(error => console.error('Error fetching cities:', error));

            fetch(`/getapprovedpayleaves/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.leaves !== null) {
                    approved_with_pay.value = data.leaves['days'];
                }
                else
                {
                    approved_with_pay.value = 0;
                }
             
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

// $(document).ready(function () {
//     $('#example').DataTable({
//         dom: 'Bfrtip',
//         buttons: [
//             'excel', 'pdf', 'print'
//         ]
//     });
// });
