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

function SelectEob(employeeId)
{
    var eob = document.getElementById('eob');
    
    if (employeeId && eob) {
        fetch(`/geteob/${employeeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching eob');
                }
                return response.json();
            })
            .then(data => {
                eob.value = data.eob;
            })
            .catch(error => console.error('Error fetching eob:', error));
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

function SelectLoanDate(month, year)
{
    var employeeId = document.getElementById('employee_id').value;
    var loan_advance = document.getElementById('loan_advance');
    var selectMonth = `${year}-${String(month).padStart(2, '0')}`;

    if (selectMonth && employeeId) {
        fetch(`/getloan/${employeeId}?month=${selectMonth}`)
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


function SelectLeaves(employeeId, year, month) {

    if (employeeId) {
        fetch(`/getleaves/${employeeId}?month=${month}&year=${year}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching leaves');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.leaves);
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
                    input.value = leave.total_days;

                    const nameInput = document.createElement('input');
                    nameInput.type = 'hidden';
                    nameInput.name = `leave_id[]`;
                    nameInput.id = `leave_id_${leave.leave_type_id}`;
                    nameInput.value = leave.leave_type_id;

                    // Append elements to the wrapper div
                    div.appendChild(label);
                    div.appendChild(input);
                    div.appendChild(nameInput);

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
                    throw new Error('Unauthorized or error fetching income tax');
                }
                return response.json();
            })
            .then(data => {
                incomeTax.value = data.incomeTax;
            })
            .catch(error => console.error('Error fetching income tax:', error));
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
                    throw new Error('Unauthorized or error fetching company');
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
            .catch(error => console.error('Error fetching company:', error));
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
                    throw new Error('Unauthorized or error fetching employee details');
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

function selectBanks(branchId)
{
    var bankSelect = document.getElementById('bank_id');
    
    if (branchId && bankSelect) {
        bankSelect.innerHTML = '<option value="">Select Bank</option>';
        fetch(`/branches/${branchId}/banks`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching banks');
                }
                return response.json();
            })
            .then(data => {
                data.banks.forEach(function (bank) {
                    var option = document.createElement('option');
                    option.value = bank.id;
                    option.textContent = bank.name;
                    bankSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching banks:', error));
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
            .catch(error => console.error('Error fetching branches:', error));
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
                    throw new Error('Unauthorized or error fetching departments');
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
            .catch(error => console.error('Error fetching departments:', error));
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
                    throw new Error('Unauthorized or error fetching designations');
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
            .catch(error => console.error('Error fetching designations:', error));
    }
}

function selectEmployeeTypes(companyId)
{
    var employeeTypeSelect = document.getElementById('employee_type_id');
    
    if (companyId && employeeTypeSelect) {
        employeeTypeSelect.innerHTML = '<option value="">Select Employee Type</option>';
        fetch(`/companies/${companyId}/employee-types`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching employee types');
                }
                return response.json();
            })
            .then(data => {
                data.employeeTypes.forEach(function (employeeType) {
                    var option = document.createElement('option');
                    option.value = employeeType.id;
                    option.textContent = employeeType.type;
                    employeeTypeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching  employee types:', error));
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
                    throw new Error('Unauthorized or error fetching employees');
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
            .catch(error => console.error('Error fetching employees:', error));
    }
}

function selectProductGroups(companyId)
{
    var productGroupSelect = document.getElementById('product_group_id');
    
    if (companyId && productGroupSelect) {
        productGroupSelect.innerHTML = '<option value="">Select Product Group</option>';
        fetch(`/companies/${companyId}/product-groups`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching product groups');
                }
                return response.json();
            })
            .then(data => {
                data.productGroups.forEach(function (productGroup) {
                    var option = document.createElement('option');
                    option.value = productGroup.id;
                    option.textContent = productGroup.name;
                    productGroupSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching product groups:', error));
    }
}

function selectProducts(companyId) {
    if (!companyId) return; // Exit if no company ID is provided

    const productSelect = document.getElementById('product_id');
    const productSelectList = Array.from(document.getElementsByClassName('products_dropdown'));

    const allSelects = [];
    if (productSelect) allSelects.push(productSelect);
    allSelects.push(...productSelectList);

    if (allSelects.length === 0) return;

    allSelects.forEach(select => {
        select.innerHTML = '<option value="">Select Product</option>';
    });

    fetch(`/companies/${companyId}/products`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error fetching products');
            }
            return response.json();
        })
        .then(data => {
            if (data.products && data.products.length > 0) {
                allSelects.forEach(select => {
                    data.products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.id;
                        option.textContent = product.name;
                        select.appendChild(option);
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
}

function selectProductVariationsByCompany(companyId) {
    if (!companyId) return; // Exit if no company ID is provided

    const productSelect = document.getElementById('product_variation_id');
    const productSelectList = Array.from(document.getElementsByClassName('product_variations_dropdown'));

    const allSelects = [];
    if (productSelect) allSelects.push(productSelect);
    allSelects.push(...productSelectList);

    if (allSelects.length === 0) return;

    allSelects.forEach(select => {
        select.innerHTML = '<option value="">Select Product</option>';
    });
    fetch(`/companies/${companyId}/product-variations`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error fetching product variations');
            }
            return response.json();
        })
        .then(data => {
            if (data.productVariations && data.productVariations.length > 0) {
                allSelects.forEach(select => {
                    data.productVariations.forEach(productVariation => {
                        const option = document.createElement('option');
                        option.value = productVariation.id;
                        option.textContent = `${productVariation.product.name} | ${productVariation.packing_type.name} | ${productVariation.pack_size.name}`;
                        select.appendChild(option);
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error fetching product variations:', error);
        });
}

function selectProductsAndRawMaterials(companyId) {
    // Get all dropdowns with the class 'products_dropdown'
    var productSelectList = document.getElementsByClassName('products_dropdown');
    
    if (companyId && productSelectList.length > 0) {
        // Loop through all dropdowns
        Array.from(productSelectList).forEach(function(productSelect) {
            // Clear the existing options in each dropdown
            productSelect.innerHTML = '<option value="">Select Product or Raw Material</option>';
            
            // Fetch the products and raw materials for the selected company
            fetch(`/companies/${companyId}/products-and-raw-materials`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching data');
                    }
                    return response.json();
                })
                .then(data => {
                    // Add product options
                    if (data.products && data.products.length > 0) {
                        var productGroup = document.createElement('optgroup');
                        productGroup.label = "Products";
                        data.products.forEach(function(product) {
                            var option = document.createElement('option');
                            option.value = `product_${product.id}`; // Use prefix to differentiate
                            option.textContent = product.name;
                            productGroup.appendChild(option);
                        });
                        productSelect.appendChild(productGroup);
                    }

                    // Add raw material options
                    if (data.rawMaterialItems && data.rawMaterialItems.length > 0) {
                        var rawMaterialGroup = document.createElement('optgroup');
                        rawMaterialGroup.label = "Raw Materials";
                        data.rawMaterialItems.forEach(function(rawMaterialItem) {
                            var option = document.createElement('option');
                            option.value = `raw_${rawMaterialItem.id}`; // Use prefix to differentiate
                            option.textContent = rawMaterialItem.name;
                            rawMaterialGroup.appendChild(option);
                        });
                        productSelect.appendChild(rawMaterialGroup);
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    }
}

function selectAllTypeOfProducts(companyId) {
    // Get all dropdowns with the class 'products_dropdown'
    var productSelectList = document.getElementsByClassName('products_dropdown');
    
    if (companyId && productSelectList.length > 0) {
        // Loop through all dropdowns
        Array.from(productSelectList).forEach(function(productSelect) {
            // Clear the existing options in each dropdown
            productSelect.innerHTML = '<option value="">Select Products</option>';
            
            // Fetch the products and raw materials for the selected company
            fetch(`/companies/${companyId}/all-products`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching data');
                    }
                    return response.json();
                })
                .then(data => {
                    // Add raw material options
                    if (data.rawMaterialItems && data.rawMaterialItems.length > 0) {
                        var rawMaterialGroup = document.createElement('optgroup');
                        rawMaterialGroup.label = "Raw Materials";
                        data.rawMaterialItems.forEach(function(rawMaterialItem) {
                            var option = document.createElement('option');
                            option.value = `raw_${rawMaterialItem.id}`; // Use prefix to differentiate
                            option.textContent = rawMaterialItem.name;
                            rawMaterialGroup.appendChild(option);
                        });
                        productSelect.appendChild(rawMaterialGroup);
                    }

                    // Add product variation
                    if (data.productVariations && data.productVariations.length > 0) {
                        var productVariationGroup = document.createElement('optgroup');
                        productVariationGroup.label = "Finished Products";
                        data.productVariations.forEach(function(productVariation) {
                            var option = document.createElement('option');
                            option.value = `var_${productVariation.id}`; // Use prefix to differentiate
                            option.textContent = `${productVariation.product.name} | ${productVariation.packing_type.name} | ${productVariation.pack_size.name}`;
                            productVariationGroup.appendChild(option);
                        });
                        productSelect.appendChild(productVariationGroup);
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    }
}

function selectProductVariations(productId) {
    // Get all dropdowns with the class 'product_variations_dropdown'
    var selectProductVariations = document.getElementsByClassName('product_variations_dropdown');
    
    if (productId && selectProductVariations.length > 0) {
        // Loop through all dropdowns
        Array.from(selectProductVariations).forEach(function(selectProductVariation) {
            // Clear the existing options in each dropdown
            selectProductVariation.innerHTML = '<option value="">Select Product Variation</option>';
            
            // Fetch the products and raw materials for the selected company
            fetch(`/products/${productId}/product-variations`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching data');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.productVariations && data.productVariations.length > 0) {
                        data.productVariations.forEach(function(productVariation) {
                            var option = document.createElement('option');
                            option.value = productVariation.id; // Use prefix to differentiate
                            option.textContent = `${productVariation.product.name} | ${productVariation.packing_type.name} | ${productVariation.pack_size.name}`;
                            selectProductVariation.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    }
}

function selectDosageForms(companyId)
{
    var dosageFormSelect = document.getElementById('dosage_form_id');
    
    if (companyId && dosageFormSelect) {
        dosageFormSelect.innerHTML = '<option value="">Select Dosage Form</option>';
        fetch(`/companies/${companyId}/dosage-forms`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching dosage forms');
                }
                return response.json();
            })
            .then(data => {
                data.dosageForms.forEach(function (dosageForm) {
                    var option = document.createElement('option');
                    option.value = dosageForm.id;
                    option.textContent = dosageForm.name;
                    dosageFormSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching dosage forms:', error));
    }
}

function selectPackForms(companyId)
{
    var packFormSelect = document.getElementById('pack_form_id');
    
    if (companyId && packFormSelect) {
        packFormSelect.innerHTML = '<option value="">Select Pack Form</option>';
        fetch(`/companies/${companyId}/pack-forms`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching pack forms');
                }
                return response.json();
            })
            .then(data => {
                data.packForms.forEach(function (packForm) {
                    var option = document.createElement('option');
                    option.value = packForm.id;
                    option.textContent = packForm.name;
                    packFormSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching pack forms:', error));
    }
}

function selectPackSizes(companyId)
{
    var packSizeSelect = document.getElementById('pack_size_id');
    
    if (companyId && packSizeSelect) {
        packSizeSelect.innerHTML = '<option value="">Select Pack Size</option>';
        fetch(`/companies/${companyId}/pack-sizes`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching pack sizes');
                }
                return response.json();
            })
            .then(data => {
                data.packSizes.forEach(function (packSize) {
                    var option = document.createElement('option');
                    option.value = packSize.id;
                    option.textContent = packSize.name;
                    packSizeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching pack sizes:', error));
    }
}

function selectPackingTypes(companyId)
{
    var packingTypeSelect = document.getElementById('packing_type_id');
    
    if (companyId && packingTypeSelect) {
        packingTypeSelect.innerHTML = '<option value="">Select Packing Type</option>';
        fetch(`/companies/${companyId}/packing-types`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching packing types');
                }
                return response.json();
            })
            .then(data => {
                data.packingTypes.forEach(function (packingType) {
                    var option = document.createElement('option');
                    option.value = packingType.id;
                    option.textContent = packingType.name;
                    packingTypeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching packing types:', error));
    }
}

function selectParties(companyId)
{
    var partySelect = document.getElementById('party_id');
    var documentTypeSelect = document.getElementById('document_type');
    
    if (companyId && partySelect) {
        let documentType = documentTypeSelect ? documentTypeSelect.value : null;
        partySelect.innerHTML = '<option value="">Select Party</option>';
        fetch(`/companies/${companyId}/parties?document_type=${documentType || ''}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching parties');
                }
                return response.json();
            })
            .then(data => {
                data.parties.forEach(function (party) {
                    var option = document.createElement('option');
                    option.value = party.id;
                    let nameSuffix = '';
                    if (party.is_supplier === 1) {
                        nameSuffix = ' (Supplier)';
                    } else if (party.is_distributor === 1) {
                        nameSuffix = ' (Franchiser)';
                    }
                    option.textContent = party.name + nameSuffix;
                    partySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching parties:', error));
    }
}

function selectRawMaterialItems(companyId)
{
    if (!companyId) return; // Exit if no company ID is provided

    const rawMaterialItemSelect = document.getElementById('raw_material_item_id');
    const rawMaterialItemSelectList = Array.from(document.getElementsByClassName('raw_material_items_dropdown'));

    const allSelects = [];
    if (rawMaterialItemSelect) allSelects.push(rawMaterialItemSelect);
    allSelects.push(...rawMaterialItemSelectList);

    if (allSelects.length === 0) return;

    allSelects.forEach(select => {
        select.innerHTML = '<option value="">Select Raw Material</option>';
    });

    fetch(`/companies/${companyId}/raw-material-items`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error fetching raw materials');
            }
            return response.json();
        })
        .then(data => {
            if (data.rawMaterialItems && data.rawMaterialItems.length > 0) {
                allSelects.forEach(select => {
                    data.rawMaterialItems.forEach(rawMaterialItem => {
                        const option = document.createElement('option');
                        option.value = rawMaterialItem.id;
                        option.textContent = rawMaterialItem.name;
                        select.appendChild(option);
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error fetching raw materials:', error);
        });
}

function selectSuppliers(companyId)
{
    var supplierSelect = document.getElementById('supplier_id');
    
    if (companyId && supplierSelect) {
        supplierSelect.innerHTML = '<option value="">Select Supplier</option>';
        fetch(`/companies/${companyId}/suppliers`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching suppliers');
                }
                return response.json();
            })
            .then(data => {
                data.suppliers.forEach(function (supplier) {
                    var option = document.createElement('option');
                    option.value = supplier.id;
                    option.textContent = supplier.name;
                    supplierSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching suppliers:', error));
    }
}

function selectFranchisers(companyId)
{
    var franchiserSelect = document.getElementById('franchiser_id');
    
    if (companyId && franchiserSelect) {
        franchiserSelect.innerHTML = '<option value="">Select Franchiser</option>';
        fetch(`/companies/${companyId}/franchisers`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching franchisers');
                }
                return response.json();
            })
            .then(data => {
                data.franchisers.forEach(function (franchiser) {
                    var option = document.createElement('option');
                    option.value = franchiser.id;
                    option.textContent = franchiser.name;
                    franchiserSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching franchisers:', error));
    }
}

function selectBatches(productId)
{
    var BatchSelect = document.getElementById('batch_id');
    
    if (productId && BatchSelect) {
        BatchSelect.innerHTML = '<option value="">Select Batch</option>';
        fetch(`/products/${productId}/batches`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching Batches');
                }
                return response.json();
            })
            .then(data => {
                data.batches.forEach(function (batch) {
                    var option = document.createElement('option');
                    option.value = batch.id;
                    option.textContent = batch.batch_no;
                    BatchSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching Batches:', error));
    }
}

function selectBatchesForProducts(productVariation, target) {
    // Remove all options and append one with "Select Product"
    const itemSet = target.closest('.item-set');
    if (!itemSet) return;

    const batchDropdown = itemSet.querySelector('.batch_dropdown');
    if (batchDropdown) {
        if (productVariation.startsWith('var_')) {
            const productVariationId = productVariation.split('_')[1];
            console.log(productVariationId);
            selectBatchesByProductVariation(productVariationId, target);
        } else {            
            batchDropdown.innerHTML = ''; // Clear all options
            const defaultOption = document.createElement('option');
            defaultOption.value = ''; // Value set to null equivalent
            defaultOption.textContent = 'Select Batch';
            batchDropdown.appendChild(defaultOption);
        }
    }
}

function selectBatchesByProductVariation(productVariationId, triggerElement) {
    // Find the closest `.item-set` container
    var itemSet = triggerElement.closest('.item-set');
    if (!itemSet) return;

    // Find the `batch_id` dropdown within the same `.item-set`
    var BatchSelect = itemSet.querySelector('.batch_dropdown');
    if (productVariationId && BatchSelect) {
        BatchSelect.innerHTML = '<option value="">Select Batch</option>'; // Clear previous options

        // Fetch batches for the selected product variation
        fetch(`/product-variations/${productVariationId}/batches`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error fetching batches');
                }
                return response.json();
            })
            .then(data => {
                data.batches.forEach(function (batch) {
                    var option = document.createElement('option');
                    option.value = batch.id;
                    option.textContent = batch.batch_no;
                    BatchSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching batches:', error));
    }
}

function selectChartOfAccounts(companyId)
{
    if (!companyId) return; // Exit if no company ID is provided

    const chartOfAccountSelect = document.getElementById('chart_of_account_id');
    const chartOfAccountSelectList = Array.from(document.getElementsByClassName('chart_of_accounts_dropdown'));

    const allSelects = [];
    if (chartOfAccountSelect) allSelects.push(chartOfAccountSelect);
    allSelects.push(...chartOfAccountSelectList);

    if (allSelects.length === 0) return;

    allSelects.forEach(select => {
        select.innerHTML = '<option value="">Select Chart Of Account</option>';
    });

    fetch(`/companies/${companyId}/chart-of-accounts`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error fetching chart of accounts');
            }
            return response.json();
        })
        .then(data => {
            if (data.chartOfAccounts && data.chartOfAccounts.length > 0) {
                allSelects.forEach(select => {
                    data.chartOfAccounts.forEach(chartOfAccount => {
                        const option = document.createElement('option');
                        option.value = chartOfAccount.id;
                        option.textContent = chartOfAccount.particular;
                        select.appendChild(option);
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error fetching chart of accounts:', error);
        });
}

function selectGeneralStoreRequisitions(companyId)
{
    var storeIssueRequisitionSelect = document.getElementById('store_issue_requisition_id');
    
    if (companyId && storeIssueRequisitionSelect) {
        storeIssueRequisitionSelect.innerHTML = '<option value="">Select Store Issue Requisition</option>';
        fetch(`/companies/${companyId}/general-store-requisitions`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching store issue requisitions');
                }
                return response.json();
            })
            .then(data => {
                data.storeIssueRequisitions.forEach(function (storeIssueRequisition) {
                    var option = document.createElement('option');
                    option.value = storeIssueRequisition.id;
                    option.textContent = storeIssueRequisition.code;
                    storeIssueRequisitionSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching store issue requisitions:', error));
    }
}

function selectProductionStoreRequisitions(companyId, productId)
{
    var storeIssueRequisitionSelect = document.getElementById('store_issue_requisition_id');
    
    if (companyId && storeIssueRequisitionSelect && productId) {
        storeIssueRequisitionSelect.innerHTML = '<option value="">Select Store Issue Requisition</option>';
        fetch(`/companies/${companyId}/production-store-requisitions?productId=${productId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching store issue requisitions');
                }
                return response.json();
            })
            .then(data => {
                data.storeIssueRequisitions.forEach(function (storeIssueRequisition) {
                    var option = document.createElement('option');
                    option.value = storeIssueRequisition.id;
                    option.textContent = storeIssueRequisition.code;
                    storeIssueRequisitionSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching store issue requisitions:', error));
    }
}

function selectInvoices(companyId)
{
    var InvoiceSelect = document.getElementById('invoice_id');
    
    if (companyId && InvoiceSelect) {
        InvoiceSelect.innerHTML = '<option value="">Select Invoice</option>';
        fetch(`/companies/${companyId}/invoices`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching parties');
                }
                return response.json();
            })
            .then(data => {
                data.invoices.forEach(function (invoice) {
                    var option = document.createElement('option');
                    option.value = invoice.id;
                    option.textContent = invoice.code;
                    InvoiceSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching parties:', error));
    }
}

function createEmployeeCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/employee-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating employee code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.employee_code;
            })
            .catch(error => console.error('Error creating employee code:', error));
    }
}

function createSupplierCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/supplier-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating suppliers code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.supplier_code;
            })
            .catch(error => console.error('Error creating suppliers code:', error));
    }
}

function createFranchiseCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/franchise-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating franchises code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.franchise_code;
            })
            .catch(error => console.error('Error creating franchises code:', error));
    }
}

function createProductCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/product-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating products code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.product_code;
            })
            .catch(error => console.error('Error creating products code:', error));
    }
}

function createPurchaseRequisitionCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/purchase-requisition-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating purchse requisition code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.purchase_requisition_code;
            })
            .catch(error => console.error('Error creating purchse requisition code:', error));
    }
}

function createRawMaterialItemCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/raw-material-item-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating raw material items code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.raw_material_item_code;
            })
            .catch(error => console.error('Error creating raw material items code:', error));
    }
}

function createPurchaseInvoiceCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/purchase-invoice-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating purchase invoice code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.invoice_code;
            })
            .catch(error => console.error('Error creating purchase invoice code:', error));
    }
}

function createSaleInvoiceCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/sale-invoice-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating sale invoice code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.invoice_code;
            })
            .catch(error => console.error('Error creating sale invoice code:', error));
    }
}

function createGoodsReceivingsCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/goods-receivings-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating goods receivings code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.goods_receiving_code;
            })
            .catch(error => console.error('Error creating goods receivings code:', error));
    }
}

function createStoreRequisitionCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/store-requisition-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating store requisition code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.store_requisition_code;
            })
            .catch(error => console.error('Error creating store requisition code:', error));
    }
}

function createFinishedGoodsCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/finished-goods-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating finished goods code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.finished_goods_code;
            })
            .catch(error => console.error('Error creating finished goods code:', error));
    }
}

function createLeftOverNoteCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/left-over-note-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating left over note code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.left_over_note_code;
            })
            .catch(error => console.error('Error creating left over note code:', error));
    }
}

function createRejectionCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/rejection-return-note-code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating rejection return note code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.rejection;
            })
            .catch(error => console.error('Error creating rejection return note code:', error));
    }
}

function createChartOfAccountCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/chart-of-account`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating chart of account code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.chart_of_account_code;
            })
            .catch(error => console.error('Error creating chart of account code:', error));
    }
}

function createPaymentVoucherCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/payment-voucher`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating payment voucher code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.payment_voucher_code;
            })
            .catch(error => console.error('Error creating payment voucher code:', error));
    }
}

function createReceiptVoucherCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/receipt-voucher`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating receipt voucher code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.receipt_voucher_code;
            })
            .catch(error => console.error('Error creating receipt voucher code:', error));
    }
}

function createCreditNoteCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/credit-note`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating credit note code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.credit_note_code;
            })
            .catch(error => console.error('Error creating credit note code:', error));
    }
}

function createSalesReturnCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/sales-return`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating sales return code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.sales_return_code;
            })
            .catch(error => console.error('Error creating sales return code:', error));
    }
}

function createJournalVoucherCode(companyId)
{
    var code = document.getElementById('code');
    
    if (companyId && code) {
        fetch(`/companies/${companyId}/journal-voucher`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error creating journal voucher code');
                }
                return response.json();
            })
            .then(data => {
                code.value = data.journal_voucher_code;
            })
            .catch(error => console.error('Error creating journal voucher code:', error));
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
                    throw new Error('Unauthorized or error fetching departments');
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
            .catch(error => console.error('Error fetching departments:', error));
    }
}

function getInvoiceDetails(invoiceId) {
    const itemSets = document.querySelectorAll('#item-group .item-set');
    var supplierId = document.getElementById('supplier_id');
    var supplierName = document.getElementById('supplier_name');
    var supplierCode = document.getElementById('supplier_code');
    
    if (invoiceId && (supplierId || supplierName || supplierCode)) {
        fetch(`/invoices/${invoiceId}/details`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching invoice details');
                }
                return response.json();
            })
            .then(data => {
                let itemIndex = 0;
                supplierId.value = data.invoice.party_id;
                supplierName.value = data.invoice.party.name;
                supplierCode.value = data.invoice.code;
                itemSets.forEach(itemSet => itemSet.remove());
                data.invoice.items.forEach(function (item) {
                    var html = `
                        <div class="item-set">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Item ${itemIndex + 1}</h4>
                                <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="card-body px-0 pb-0">
                                <input type="hidden" name="items[${itemIndex}][types]" value="${item.product_id ? 'product' : 'raw_material_item'}">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="product_code">Code</label>
                                        <input type="text" class="form-control" name="items[${itemIndex}][code]"
                                            placeholder="Product Code" required value="${item.product ? item.product.code : item.raw_material_item.code}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="product_name">Description</label>
                                        <input type="text" class="form-control" name="items[${itemIndex}][name]"
                                            placeholder="Product Names" required value="${item.product ? item.product.name : item.raw_material_item.name}" readonly>
                                        <input type="hidden" name="items[${itemIndex}][${item.product_id ? 'product' : 'raw_material_item'}]" value="${item.product_id ? item.product_id : item.raw_material_item_id}">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="batch_id">Batch</label>
                                        <select name="items[${itemIndex}][batch]" id="batch_id_${itemIndex}" class="js-example-basic-single select2" required>
                                            <option value="">Select Batch</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label>Quantity Ordered</label>
                                        <input type="number" class="form-control" name="items[${itemIndex}][quantity_ordered]"
                                            placeholder="Quantity Ordered" required value="${item.quantity}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label>Quantity Recieved</label>
                                        <input type="number" class="form-control" name="items[${itemIndex}][quantity_received]"
                                            placeholder="Quantity Recieved" required value="${item.received_quantity}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label>Balance Recievable</label>
                                        <input type="number" class="form-control balance_receivable" name="items[${itemIndex}][balance_receivable]"
                                            placeholder="Balance Recievable" required value="" max="${item.quantity - item.received_quantity}" oninput="calculateGoodsRecievingAmount()">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" name="items[${itemIndex}][unit]"
                                            placeholder="Unit" required value="${item.unit}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label>Unit Price</label>
                                        <input type="text" class="form-control unit_price" name="items[${itemIndex}][unit_price]"
                                            placeholder="Unit Price" required value="${item.unit_price}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label>Total</label>
                                        <input type="number" class="form-control product_total" name="items[${itemIndex}][total_amount]"
                                            placeholder="Total" required value="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    $("#item-group").append(html);

                    // Populate the batch options dynamically based on the type (product or raw material)
                    var batchSelect = $(`#batch_id_${itemIndex}`);
                    if (item.product_id) {
                        // For product, populate batches related to the product
                        item.batches.forEach(function(batch) {
                            var batchOption = `<option value="${batch.id}">${batch.batch_no}</option>`;
                            batchSelect.append(batchOption);
                        });
                    }

                    // Reinitialize select2 for the new batch dropdown
                    batchSelect.select2();
                    itemIndex++;
                });
            })
            .catch(error => console.error('Error fetching invoice details:', error));
    }
}

function getGeneralStoreRequisitionDetails(requisitionId) {
    const itemSets = document.querySelectorAll('#item-group .item-set');
    var invoiceId = document.getElementById('invoice_id').value;
    var supplierBillNo = document.getElementById('supplier_bill_no').value;
    
    if (requisitionId && invoiceId && supplierBillNo) {
        fetch(`/store-requisitions/${requisitionId}/general-details?invoiceId=${invoiceId}&supplierBillNo=${supplierBillNo}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching store requisition details');
                }
                return response.json();
            })
            .then(data => {
                // Clear existing item sets
                itemSets.forEach(itemSet => itemSet.remove());

                if (data.items && data.items.length > 0) {
                    let index = 0;
                
                    // Iterate over the common items (data.requisition)
                    data.items.forEach(function (item, index) {
                        // Generate HTML for each item
                        var html = `
                            <div class="item-set">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Item ${index + 1}</h4>
                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="card-body px-0 pb-0">
                                    <input type="hidden" name="items[${index}][types]" value="${item.product_id ? 'product' : 'raw_material_item'}">
                                    <div class="row">
                                        <div class="mb-3 col-md">
                                            <label for="product_name">Description</label>
                                            <input type="text" class="form-control" name="items[${index}][name]"
                                                placeholder="Description" required 
                                                value="${item.product ? item.product.name : item.raw_material_item.name}" readonly>
                                            <input type="hidden" name="items[${index}][${item.product_id ? 'product' : 'raw_material_item'}]" 
                                                value="${item.product_id ? item.product_id : item.raw_material_item_id}">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label>Unit Price</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control w-25 unit_price" name="items[${index}][unit_price]"
                                                    placeholder="Unit Price" required value="${item.unit_price}" readonly oninput="calculateSingleProductAmount()">
                                                <input type="text" class="form-control" name="items[${index}][unit]"
                                                    placeholder="Unit" required value="${item.unit}" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control quantity" name="items[${index}][quantity]"
                                                placeholder="Quantity" required value="${item.quantity}" oninput="calculateSingleProductAmount()" readonly>
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label>Total</label>
                                            <input type="number" class="form-control product_total" name="items[${index}][total]"
                                                placeholder="Total" required value="${item.total}" readonly>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label>Remarks</label>
                                            <textarea class="form-control" name="items[${index}][remarks]" placeholder="Write your remarks..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    
                        // Append the generated HTML to the #item-group container
                        $("#item-group").append(html);
                    
                        // Ensure amounts are calculated
                        calculateSingleProductAmount();
                    });                    
                } else {
                    var html = `
                        <div class="item-set">
                            <div class="alert alert-danger text-center">No Items Found According your provided supplier bill no. and store issue requisition.</p>
                        </div>
                    `;
                    $("#item-group").append(html);
                }
            })
            
            .catch(error => console.error('Error fetching store requisition details:', error));
    }
}

function getProductionStoreRequisitionDetails(requisitionId) {
    const itemSets = document.querySelectorAll('#item-group .item-set');
    var batchId = document.getElementById('batch_id').value;
    
    if (requisitionId && batchId) {
        fetch(`/store-requisitions/${requisitionId}/production-details?batchId=${batchId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching store requisition details');
                }
                return response.json();
            })
            .then(data => {
                // Clear existing item sets
                itemSets.forEach(itemSet => itemSet.remove());

                if (data.items && data.items.length > 0) {
                
                    // Iterate over the common items (data.requisition)
                    data.items.forEach(function (item, index) {
                        // Generate HTML for each item
                        var html = `
                            <div class="item-set">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Item ${index + 1}</h4>
                                    <button type="button" onclick="removeItem(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="card-body px-0 pb-0">
                                    <div class="row">
                                        <div class="mb-3 col-md">
                                            <label for="raw_material_item_name">Description</label>
                                            <input type="text" class="form-control" name="items[${index}][name]"
                                                placeholder="Description" required 
                                                value="${item.raw_material_item.name}" readonly>
                                            <input type="hidden" name="items[${index}][raw_material_item]" 
                                                value="${item.raw_material_item_id}">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label>Unit Price</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control w-25 unit_price" name="items[${index}][unit_price]"
                                                    placeholder="Unit Price" required value="${item.unit_price}" readonly oninput="calculateSingleProductAmount()">
                                                <input type="text" class="form-control" name="items[${index}][unit]"
                                                    placeholder="Unit" required value="${item.unit}" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control quantity" name="items[${index}][quantity]"
                                                placeholder="Quantity" required value="${item.quantity}" oninput="calculateSingleProductAmount()" max="${item.quantity}" min="1">
                                            <input type="hidden" name="items[${index}][max_quantity]" value="${item.quantity}">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label>Total</label>
                                            <input type="number" class="form-control product_total" name="items[${index}][total]"
                                                placeholder="Total" required value="${item.total}" readonly>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label>Remarks</label>
                                            <textarea class="form-control" name="items[${index}][remarks]" placeholder="Write your remarks..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    
                        // Append the generated HTML to the #item-group container
                        $("#item-group").append(html);
                    
                        // Ensure amounts are calculated
                        calculateSingleProductAmount();
                    });                    
                } else {
                    var html = `
                        <div class="item-set">
                            <div class="alert alert-danger text-center">No Items Found According your provided product and batch No.</p>
                        </div>
                    `;
                    $("#item-group").append(html);
                }
            })
            
            .catch(error => console.error('Error fetching store requisition details:', error));
    }
}

function selectSupplierByInvoice(invoiceId)
{
    var supplierIdSelect = document.getElementById('supplier_id');
    var supplierNameSelect = document.getElementById('supplier_name');
    
    if (invoiceId && (supplierIdSelect || supplierNameSelect)) {
        fetch(`/invoices/${invoiceId}/supplier`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching supplier');
                }
                return response.json();
            })
            .then(data => {
                supplierNameSelect.value = data.supplier.name;
                supplierIdSelect.value = data.supplier.id;
            })
            .catch(error => console.error('Error fetching supplier:', error));
    }
}

function selectSupplierBillNoByInvoice(invoiceId)
{
    var supplierBillNoSelect = document.getElementById('supplier_bill_no');
    
    if (invoiceId && supplierBillNoSelect) {
        supplierBillNoSelect.innerHTML = '<option value="">Select Bill No.</option>';
        fetch(`/invoices/${invoiceId}/goods-receivings`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching goods receivings');
                }
                return response.json();
            })
            .then(data => {
                data.goodsReceivings.forEach(function (goodsReceiving) {
                    var option = document.createElement('option');
                    option.value = goodsReceiving.supplier_bill_no;
                    option.textContent = goodsReceiving.supplier_bill_no;
                    supplierBillNoSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching goods receivings:', error));
    }
}

function getSupplierCodeByPartyId(partyId)
{
    var SupplierCodeSelect = document.getElementById('supplier_code');
    
    if (partyId && SupplierCodeSelect) {
        fetch(`/parties/${partyId}/supplier_code`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Unauthorized or error fetching parties');
                }
                return response.json();
            })
            .then(data => {
                SupplierCodeSelect.value = data.supplier_code;
            })
            .catch(error => console.error('Error fetching parties:', error));
    }
}

function updateLoanRemaining(loanAmount) {
    document.getElementById('loan_remaining').value = loanAmount;
}

function calculateValue() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const rate = parseFloat(document.getElementById('unit_price').value) || 0;
    const value = quantity * rate;
    
    document.getElementById('total').value = value.toFixed(2); // Format to 2 decimal places if needed
}

function calculateRowAmount(element) {
    // Find the closest row and the inputs within it
    const row = element.closest('.product-row');
    const quantity = row.querySelector('input[name="quantity[]"]').value || 0;
    const price = row.querySelector('input[name="price[]"]').value || 0;

    // Calculate the amount
    const amount = parseFloat(quantity) * parseFloat(price);

    // Set the amount value in the corresponding input
    row.querySelector('input[name="amount[]"]').value = amount.toFixed(2);

    // Optionally, update the total amount for all rows
    calculateTotalAmount();
}

function calculateTotalAmount() {
    let totalAmount = 0;
    const amountInputs = document.querySelectorAll('input[name="amount[]"]');
    amountInputs.forEach(input => {
        const amount = parseFloat(input.value) || 0;
        totalAmount += amount;
    });
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
}

document.getElementById('addProductButton').addEventListener('click', function() {
    // Get the table body and clone the row
    const table = document.getElementById('productList').getElementsByTagName('tbody')[0];
    const newRow = document.querySelector('.product-row').cloneNode(true);

    // Update row index in the first cell
    const rowCount = table.querySelectorAll('.product-row').length + 1;
    newRow.cells[0].textContent = rowCount;

    // Clear input values in the cloned row
    newRow.querySelectorAll('input').forEach(input => input.value = '');

    // Add "Remove" button only to new rows
    newRow.cells[6].innerHTML = '<button type="button" class="btn btn-danger btn-sm removeProductButton" onclick="removeProductRow(this)"><i class="fa fa-trash"></i></button>';

    // Insert the new row before the "Total" row
    const totalRow = table.lastElementChild;
    table.insertBefore(newRow, totalRow);
});

function removeProductRow(button) {
    const row = button.closest('tr');
    row.remove();
    calculateTotalAmount();
    updateRowNumbers();
}

function updateProductRowNumbers() {
    // Update row numbers after a row is removed
    document.querySelectorAll('.product-row').forEach((row, index) => {
        row.cells[0].textContent = index + 1;
    });
}

function selectInvoiceprefix(value) {
    let prefix = '';
    switch(value) {
        case 'sale':
            prefix = 'SI';
            break;
        case 'purchase':
            prefix = 'PR';
            break;
        case 'quotation':
            prefix = 'QT';
            break;
        default:
            prefix = '';
    }
    document.getElementById('prefix').value = prefix;
}

function calculateSaleInvoiceAmount() {
    let totalInvoiceTax = 0;
    let itemsCostWithTax = 0;
    let itemsCostWithoutTax = 0;
    let totalAmount = 0;
    let dueAmount = 0;

    var shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
    var invoiceTaxRate = parseFloat(document.getElementById('invoice_tax_rate').value) || 0;
    var invdiscount = parseFloat(document.getElementById('discount').value) || 0;
    var invdiscounttype = document.getElementById('discount_type').value || 'flat';
    var paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
    var returnedAmount = parseFloat(document.getElementById('returned_amount').value) || 0;

    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const unitPrice = parseFloat(itemSet.querySelector('.unit_price').value) || 0;
        const quantity = parseFloat(itemSet.querySelector('.product_quantity').value) || 0;
        const taxRate = parseFloat(itemSet.querySelector('.tax_rate').value) || 0;
        const discountType = itemSet.querySelector('select[name="invoice_items[' + index + '][discount_type]"]').value;
        const discount = parseFloat(itemSet.querySelector('.discount').value) || 0;

        let itemTotal = unitPrice * quantity;

        itemTotal += (itemTotal * taxRate) / 100;

        if (discountType === 'percent') {
            itemTotal -= (itemTotal * discount) / 100;
        } else {
            itemTotal -= discount;
        }

        totalAmount += itemTotal;

        itemSet.querySelector('.total_item_amount').value = itemTotal.toFixed(2);
    });

    totalAmount += shippingCost;

    itemsCostWithoutTax += totalAmount;
    totalInvoiceTax = (totalAmount * invoiceTaxRate) / 100;
    itemsCostWithTax += itemsCostWithoutTax + totalInvoiceTax;
    totalAmount += totalInvoiceTax;
    
    if (invdiscounttype === 'percent') {
        totalAmount -= (totalAmount * invdiscount) / 100;
    } else {
        totalAmount -= invdiscount;
    }

    dueAmount = totalAmount - paidAmount + returnedAmount;

    document.getElementById('items_cost_without_tax').value = itemsCostWithoutTax.toFixed(2);
    document.getElementById('total_invoice_tax').value = totalInvoiceTax.toFixed(2);
    document.getElementById('items_cost_with_tax').value = itemsCostWithTax.toFixed(2);
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
    document.getElementById('due_amount').value = dueAmount.toFixed(2);
}

function calculateSalesReturnAmount() {
    let totalTax = 0;
    let itemsCostWithTax = 0;
    let itemsCostWithoutTax = 0;
    let totalAmount = 0;

    var returnTaxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
    var invdiscount = parseFloat(document.getElementById('discount').value) || 0;
    var invdiscounttype = document.getElementById('discount_type').value || 'flat';

    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const unitPrice = parseFloat(itemSet.querySelector('.unit_price').value) || 0;
        const quantity = parseFloat(itemSet.querySelector('.product_quantity').value) || 0;
        const taxRate = parseFloat(itemSet.querySelector('.tax_rate').value) || 0;
        const discountType = itemSet.querySelector('select[name="items[' + index + '][discount_type]"]').value;
        const discount = parseFloat(itemSet.querySelector('.discount').value) || 0;

        let itemTotal = unitPrice * quantity;

        itemTotal += (itemTotal * taxRate) / 100;

        if (discountType === 'percent') {
            itemTotal -= (itemTotal * discount) / 100;
        } else {
            itemTotal -= discount;
        }

        totalAmount += itemTotal;

        itemSet.querySelector('.total_item_amount').value = itemTotal.toFixed(2);
    });

    itemsCostWithoutTax += totalAmount;
    totalTax = (totalAmount * returnTaxRate) / 100;
    itemsCostWithTax += itemsCostWithoutTax + totalTax;
    totalAmount += totalTax;
    
    if (invdiscounttype === 'percent') {
        totalAmount -= (totalAmount * invdiscount) / 100;
    } else {
        totalAmount -= invdiscount;
    }

    document.getElementById('inclusive_tax').value = itemsCostWithoutTax.toFixed(2);
    document.getElementById('total_tax').value = totalTax.toFixed(2);
    document.getElementById('exclusive_tax').value = itemsCostWithTax.toFixed(2);
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
}

function calculatePurchaseInvoiceAmount() {
    let totalInvoiceTax = 0;
    let itemsCostWithTax = 0;
    let itemsCostWithoutTax = 0;
    let totalAmount = 0;
    let dueAmount = 0;

    var invoiceTaxRate = parseFloat(document.getElementById('invoice_tax_rate').value) || 0;
    var invdiscount = parseFloat(document.getElementById('discount').value) || 0;
    var invdiscounttype = document.getElementById('discount_type').value || 'flat';
    var paid_amount = parseFloat(document.getElementById('paid_amount').value) || 0;
    var returned_amount = parseFloat(document.getElementById('returned_amount').value) || 0;

    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const unitPrice = parseFloat(itemSet.querySelector('.unit_price').value) || 0;
        const quantity = parseFloat(itemSet.querySelector('.product_quantity').value) || 0;
        const taxRate = parseFloat(itemSet.querySelector('.tax_rate').value) || 0;
        const discountType = itemSet.querySelector('select[name="invoice_items[' + index + '][discount_type]"]').value;
        const discount = parseFloat(itemSet.querySelector('.discount').value) || 0;

        let itemTotal = unitPrice * quantity;

        itemTotal += (itemTotal * taxRate) / 100;

        if (discountType === 'percent') {
            itemTotal -= (itemTotal * discount) / 100;
        } else {
            itemTotal -= discount;
        }

        totalAmount += itemTotal;

        itemSet.querySelector('.total_item_amount').value = itemTotal.toFixed(2);
    });

    itemsCostWithoutTax += totalAmount;
    totalInvoiceTax = (totalAmount * invoiceTaxRate) / 100;
    itemsCostWithTax += itemsCostWithoutTax + totalInvoiceTax;
    totalAmount += totalInvoiceTax;
    
    if (invdiscounttype === 'percent') {
        totalAmount -= (totalAmount * invdiscount) / 100;
    } else {
        totalAmount -= invdiscount;
    }

    dueAmount = totalAmount - paid_amount + returned_amount;

    document.getElementById('items_cost_without_tax').value = itemsCostWithoutTax.toFixed(2);
    document.getElementById('total_invoice_tax').value = totalInvoiceTax.toFixed(2);
    document.getElementById('items_cost_with_tax').value = itemsCostWithTax.toFixed(2);
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
    document.getElementById('due_amount').value = dueAmount.toFixed(2);
}

function calculateGoodsRecievingAmount() {
    let totalAmount = 0;

    var salesTax = parseFloat(document.getElementById('sales_tax').value) || 0;
    var advanceTax = parseFloat(document.getElementById('adv_tax').value) || 0;

    // Loop through each item set
    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const unitPrice = parseFloat(itemSet.querySelector('.unit_price').value) || 0;
        const quantity = parseFloat(itemSet.querySelector('.balance_receivable').value) || 0;

        // Calculate item total without discount and tax
        let itemTotal = unitPrice * quantity;

        // Accumulate total invoice tax
        totalAmount += itemTotal;

        // Update the total amount field
        itemSet.querySelector('.product_total').value = itemTotal.toFixed(2);
    });

    totalAmount += salesTax + advanceTax;
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
}

function calculateSingleProductAmount() {
    // Loop through each item set
    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const unitPrice = parseFloat(itemSet.querySelector('.unit_price').value) || 0;
        const quantity = parseFloat(itemSet.querySelector('.quantity').value) || 0;

        // Calculate item total without discount and tax
        let itemTotal = unitPrice * quantity;

        // Update the total amount field
        itemSet.querySelector('.product_total').value = itemTotal.toFixed(2);
    });
}

function calculatePaymentVoucherAmount() {
    let totalDebit = 0;
    let totalCredit = 0;
    let total = 0;
    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const debit = parseFloat(itemSet.querySelector('.debit').value) || 0;
        const credit = parseFloat(itemSet.querySelector('.credit').value) || 0;

        totalDebit += debit;
        totalCredit += credit;
    });

    total += totalDebit - totalCredit;

    document.getElementById('total_debit').value = totalDebit.toFixed(2);
    document.getElementById('total_credit').value = totalCredit.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

function calculateReceiptVoucherAmount() {
    let totalDebit = 0;
    let totalCredit = 0;
    let total = 0;
    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const debit = parseFloat(itemSet.querySelector('.debit').value) || 0;
        const credit = parseFloat(itemSet.querySelector('.credit').value) || 0;

        totalDebit += debit;
        totalCredit += credit;
    });

    total += totalCredit - totalDebit;

    document.getElementById('total_debit').value = totalDebit.toFixed(2);
    document.getElementById('total_credit').value = totalCredit.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

function calculateJournalVoucherAmount() {
    let totalDebit = 0;
    let totalCredit = 0;
    document.querySelectorAll('.item-set').forEach((itemSet, index) => {
        const debit = parseFloat(itemSet.querySelector('.debit').value) || 0;
        const credit = parseFloat(itemSet.querySelector('.credit').value) || 0;

        totalDebit += debit;
        totalCredit += credit;
    });

    document.getElementById('total_debit').value = totalDebit.toFixed(2);
    document.getElementById('total_credit').value = totalCredit.toFixed(2);
}

function addAllowance() {
    let container = document.getElementById('allowance-container');
    let input = `<div class="col-md-6 mb-3"><input type="text" name="allowance_names[]" placeholder="Allowance Name" class="form-control" required></div>
                 <div class="col-md-6 mb-3"><input type="number" name="allowance_amounts[]" placeholder="Amount" class="form-control" required></div>`;
    container.insertAdjacentHTML('beforeend', input);
}

function addDeduction() {
    let container = document.getElementById('deduction-container');
    let input = `<div class="col-md-6 mb-3"><input type="text" name="deduction_names[]" placeholder="Deduction Name" class="form-control" required></div>
                 <div class="col-md-6 mb-3"><input type="number" name="deduction_amounts[]" placeholder="Amount" class="form-control" required></div>`;
    container.insertAdjacentHTML('beforeend', input);
}