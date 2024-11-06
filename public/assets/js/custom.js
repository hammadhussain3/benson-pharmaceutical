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

// var countryId = document.getElementById('country_id');
// var employeeId = document.getElementById('employee_id');
// var companyId = document.getElementById('company_id');

// if (countryId) {
//     var selectedCountryValue = countryId.value;
//     Selectcountry(selectedCountryValue);
// }

// if (employeeId) {
//     var selectedEmployeeValue = employeeId.value;
//     SelectLoan(selectedEmployeeValue);
//     SelecLeaves(selectedEmployeeValue);
//     SelectIncomeTax(selectedEmployeeValue); 
//     SelectCompany(selectedEmployeeValue);
//     SelectEmployeeDetails(selectedEmployeeValue);
// }

// if (companyId) {
//     var selectedCompanyValue = companyId.value;
//     console.log(selectedCompanyValue);
//     selectBranches(selectedCompanyValue);
//     selectDepartments(selectedCompanyValue);
//     selectDesignations(selectedCompanyValue);
//     selectEmployee(selectedCompanyValue);
// }


function Selectcountry()
{
    var countryId = document.getElementById('country_id').value;
    var citySelect = document.getElementById('city_id');
    
    if (countryId && citySelect) {
        citySelect.innerHTML = '<option value="">Select City</option>';
        fetch(`/countries/${countryId}/cities`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
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
    var loanAdvance = document.getElementById('loan_advance');
    
    if (employeeId && loanAdvance) {
        fetch(`/getloan/${employeeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                loanAdvance.value = data.loan;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function SelectLoanDate(month)
{
    var employeeId = document.getElementById('employee_id').value;
    var loan_advance = document.getElementById('loan_advance');

    if (month && employeeId) {
        fetch(`/getloan/${employeeId}?month=${month}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                loan_advance.value = data.loan;
            })
            .catch(error => console.error('Error fetching loan data:', error));
    }
}


function SelectLeaves(employeeId) {
    if (employeeId) {
        fetch(`/getleaves/${employeeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching leaves');
                }
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('formContainer');
                const existingLeaves = container.querySelectorAll('.leaves');
                existingLeaves.forEach(leaveDiv => leaveDiv.remove());

                data.leaves.forEach(leave => {
                    // Create a wrapper div
                    const div = document.createElement('div');
                    div.classList.add('mb-3', 'col-md-6', 'leaves');

                    // Create a label for the leave type
                    const label = document.createElement('label');
                    label.setAttribute('for', `leaves_${leave.leave_type_id}`);
                    label.textContent = `${leave.leave_type_name}`;

                    // Create the input field
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.classList.add('form-control');
                    input.name = `leaves[]`;
                    input.id = `leaves_${leave.leave_type_id}`;
                    input.required = true;
                    input.readOnly = true;
                    input.value = leave.total_days; // Set the total days as the value

                    // Append elements to the wrapper div
                    div.appendChild(label);
                    div.appendChild(input);

                    // Append the wrapper div to the container
                    container.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching leaves:', error));
    }
    // var auth_leave = document.getElementById('auth_leave');
    // var unauth_leave = document.getElementById('unauth_leave');
    // var approved_with_pay = document.getElementById('approved_with_pay');
    
    // if (employeeId) {
    //     fetch(`/getapprovedleaves/${employeeId}`)
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error('Unauthorized or error fetching branches');
    //             }
    //             return response.json();
    //         })
    //         .then(data => {
    //             if (data.leaves !== null) {
    //                 auth_leave.value = data.leaves['days'];
    //             }
    //             else
    //             {
    //                 auth_leave.value = 0;
    //             }
             
    //         })
    //         .catch(error => console.error('Error fetching cities:', error));

    //         fetch(`/getunauthleaves/${employeeId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.leaves !== null) {
    //                 unauth_leave.value = data.leaves['days'];
    //             }
    //             else
    //             {
    //                 unauth_leave.value = 0;
    //             }
             
    //         })
    //         .catch(error => console.error('Error fetching cities:', error));

    //         fetch(`/getapprovedpayleaves/${employeeId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.leaves !== null) {
    //                 approved_with_pay.value = data.leaves['days'];
    //             }
    //             else
    //             {
    //                 approved_with_pay.value = 0;
    //             }
             
    //         })
    //         .catch(error => console.error('Error fetching cities:', error));
    // }
}

function SelectIncomeTax(employeeId)
{
    var incomeTax = document.getElementById('income_tax');
    
    if (employeeId && incomeTax) {
        fetch(`/getincometax/${employeeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                incomeTax.value = data.incomeTax;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function SelectCompany(employeeId)
{
    var companyId = document.getElementById('company_id');
    var company = document.getElementById('company');
    
    if (employeeId && (companyId || company)) {
        fetch(`/getcompany/${employeeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                if (companyId) {
                    companyId.value = data.company_id;
                }
                if (company) {
                    company.value = data.company;
                }
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function SelectEmployeeDetails(employeeId) {
    var branchId = document.getElementById('branch_id');
    var departmentId = document.getElementById('department_id');
    var designationId = document.getElementById('designation_id');
    var branch = document.getElementById('branch');
    var department = document.getElementById('department');
    var designation = document.getElementById('designation');
    var basic_pay = document.getElementById('basic_pay');
    var allowances = document.getElementById('allowances');
    var monthInput = document.getElementById('month');
    var name = document.getElementById('name');
    var email = document.getElementById('email');

    if (employeeId && (branchId || departmentId || designationId || branch || department || designation || basic_pay || allowances || monthInput || name || email)) {
        fetch(`/getemployee/${employeeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                if (branchId) {
                    branchId.value = data.branch_id;
                }
                if (departmentId) {
                    departmentId.value = data.department_id;
                }
                if (designationId) {
                    designationId.value = data.designation_id;
                }
                if (branch) {
                    branch.value = data.branch;
                }
                if (department) {
                    department.value = data.department;
                }
                if (designation) {
                    designation.value = data.designation;
                }
                if (basic_pay) {
                    basic_pay.value = data.basic_pay;
                }
                if (allowances) {
                    allowances.value = data.allowances;
                }
                if (name) {
                    name.value = data.first_name+ ' ' +data.last_name;
                }
                if (email) {
                    email.value = data.email;
                }
                
                // Set the minimum month based on date of joining or last 3 years
                if (data.date_of_joining && monthInput) {
                    // Assuming date_of_joining is in the format 'YYYY-MM-DD'
                    var joiningDate = new Date(data.date_of_joining);
                    var today = new Date();

                    // Calculate the date three years ago from today
                    var threeYearsAgo = new Date(today);
                    threeYearsAgo.setFullYear(today.getFullYear() - 3);

                    // Compare joining date with three years ago to get the later date
                    var minDate = joiningDate > threeYearsAgo ? joiningDate : threeYearsAgo;
                    var formattedMinMonth = minDate.toISOString().slice(0, 7); // Get 'YYYY-MM' part
                    monthInput.min = formattedMinMonth;
                }
            })
            .catch(error => console.error('Error fetching employee details:', error));
    }
}

function selectBranches(companyId)
{
    var branchSelect = document.getElementById('branch_id');
    
    if (companyId && branchSelect) {
        branchSelect.innerHTML = '<option value="">Select Branch</option>';
        fetch(`/companies/${companyId}/branches`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                data.branches.forEach(function (branch) {
                    var option = document.createElement('option');
                    option.value = branch.id;
                    option.textContent = branch.name;
                    branchSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function selectDepartments(companyId)
{
    var departmentSelect = document.getElementById('department_id');
    
    if (companyId && departmentSelect) {
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        fetch(`/companies/${companyId}/departments`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                data.departments.forEach(function (department) {
                    var option = document.createElement('option');
                    option.value = department.id;
                    option.textContent = department.name;
                    departmentSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function selectDesignations(companyId)
{
    var designationSelect = document.getElementById('designation_id');
    
    if (companyId && designationSelect) {
        designationSelect.innerHTML = '<option value="">Select Designation</option>';
        fetch(`/companies/${companyId}/designations`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                data.designations.forEach(function (designation) {
                    var option = document.createElement('option');
                    option.value = designation.id;
                    option.textContent = designation.name;
                    designationSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function selectEmployee(companyId)
{
    var employeeSelect = document.getElementById('employee_id');
    
    if (companyId && employeeSelect) {
        employeeSelect.innerHTML = '<option value="">Select Employee</option>';
        fetch(`/companies/${companyId}/employees`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                data.employees.forEach(function (employee) {
                    var option = document.createElement('option');
                    option.value = employee.id;
                    option.textContent = employee.code+ ' - ' +employee.first_name+ ' ' +employee.last_name;
                    employeeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function createEmployeeCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/employee-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.employee_code;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function createSupplierCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/supplier-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.supplier_code;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function createFranchiseCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/franchise-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.franchise_code;
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function selectDepartmentsByBranch(branchId)
{
    var departmentSelect = document.getElementById('department_id');
    
    if (branchId && departmentSelect) {
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        fetch(`/branches/${branchId}/departments`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching branches');
                }
                return response.json();
            })
            .then(data => {
                data.departments.forEach(function (department) {
                    var option = document.createElement('option');
                    option.value = department.id;
                    option.textContent = department.name;
                    departmentSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

function updateLoanRemaining(loanAmount) {
    document.getElementById('loan_remaining').value = loanAmount;
}