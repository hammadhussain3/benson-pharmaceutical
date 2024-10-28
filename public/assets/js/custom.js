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
                console.log(data);
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
    var companyId = document.getElementById('company_id');
    var company = document.getElementById('company');
    
    if (employeeId) {
        fetch(`/getcompany/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                companyId.value = data.company_id;
                company.value = data.company;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function SelectEmployeeDetails(employeeId)
{
    var employeeId = employeeId;
    var branchId = document.getElementById('branch_id');
    var departmentId = document.getElementById('department_id');
    var designationId = document.getElementById('designation_id');
    var branch = document.getElementById('branch');
    var department = document.getElementById('department');
    var designation = document.getElementById('designation');
    var basic_pay = document.getElementById('basic_pay');
    var allowances = document.getElementById('allowances');
    var monthInput = document.getElementById('month');
    
    if (employeeId) {
        fetch(`/getemployee/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                branchId.value = data.branch_id;
                departmentId.value = data.department_id;
                designationId.value = data.designation_id;
                branch.value = data.branch;
                department.value = data.department;
                designation.value = data.designation;
                basic_pay.value = data.basic_pay;
                allowances.value = data.allowances;

                // Set the minimum month based on date of joining or last 3 years
                if (data.date_of_joining) {
                    // Assuming date_of_joining is in the format 'YYYY-MM-DD'
                    var joiningDate = new Date(data.date_of_joining);
                    var today = new Date();

                    // Calculate the date three years ago from today
                    var threeYearsAgo = new Date(today);
                    threeYearsAgo.setFullYear(today.getFullYear() - 3);

                    // Compare joining date with three years ago
                    var minDate = joiningDate > threeYearsAgo ? joiningDate : threeYearsAgo;
                    var formattedMinMonth = minDate.toISOString().slice(0, 7); // Get 'YYYY-MM' part
                    monthInput.min = formattedMinMonth;
                }
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}
