<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        // Fetch existing IDs for foreign keys
        $designationIds = Designation::pluck('id')->toArray();
        $departmentIds = Department::pluck('id')->toArray();
        $bankIds = Bank::pluck('id')->toArray();
        $branchIds = Branch::pluck('id')->toArray();
        $companyIds = Company::pluck('id')->toArray();

        return [
            'Code' => $this->faker->unique()->numerify('EMP#####'),
            'First_name' => $this->faker->firstName(),
            'Last_name' => $this->faker->lastName(),
            'Basic_pay' => $this->faker->randomFloat(2, 3000, 7000),
            'Allowances' => $this->faker->randomFloat(2, 0, 1000),

            'Date_of_joining' => $this->faker->date(),
            'Designation_id' => $this->faker->randomElement($designationIds), // Use an existing Designation ID
            'Department_id' => $this->faker->randomElement($departmentIds), // Use an existing Department ID
            'Bank_id' => $this->faker->randomElement($bankIds), // Use an existing Bank ID (nullable)
            'Bank_account' => $this->faker->bankAccountNumber(),
            'Is_active' => $this->faker->boolean(),
            'Branch_id' => $this->faker->randomElement($branchIds), // Use an existing Branch ID
            'Company_id' => $this->faker->randomElement($companyIds), // Use an existing Company ID
        ];
    }
}
