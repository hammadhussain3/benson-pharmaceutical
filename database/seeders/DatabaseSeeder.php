<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            BankSeeder::class,
            CompanySeeder::class,
            BranchSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            EmployeeSeeder::class,
            SalaryTaxSlabSeeder::class,
            LeaveTypeSeeder::class,
            LeaveSeeder::class,
            SalarySlipSeeder::class,
            LoanSeeder::class,
            PaymentTypeSeeder::class,
            PartiesSeeder::class,
        ]);
    }
}
