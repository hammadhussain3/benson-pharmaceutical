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
                citySelect.value = data.loan;
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

function SelectIncomeTax(employeeId)
{
    var employeeId = employeeId;
    var incomeTax = document.getElementById('income_tax');
    
    if (employeeId) {
        fetch(`/getincometax/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                incomeTax.value = data.incomeTax;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function SelectCompany(employeeId)
{
    var employeeId = employeeId;
    var company = document.getElementById('company_id');
    
    if (employeeId) {
        fetch(`/getcompany/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                company.value = data.company;
                $(company).trigger('change');
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function SelectEmployeeDetails(employeeId)
{
    var employeeId = employeeId;
    var branch = document.getElementById('branch_id');
    var department = document.getElementById('department_id');
    var designation = document.getElementById('designation_id');
    var basic_pay = document.getElementById('basic_pay');
    var allowances = document.getElementById('allowances');
    var monthInput = document.getElementById('month');
    
    if (employeeId) {
        fetch(`/getemployee/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                branch.value = data.branch;
                $(branch).trigger('change');
                department.value = data.department;
                $(department).trigger('change');
                designation.value = data.designation;
                $(designation).trigger('change');
                basic_pay.value = data.basic_pay;
                allowances.value = data.allowances;

                if (data.date_of_joining) {
                    // Assuming date_of_joining is in the format 'YYYY-MM-DD'
                    var joiningDate = new Date(data.date_of_joining);
                    var formattedJoiningMonth = joiningDate.toISOString().slice(0, 7); // Get 'YYYY-MM' part
                    monthInput.min = formattedJoiningMonth;
                }
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}
