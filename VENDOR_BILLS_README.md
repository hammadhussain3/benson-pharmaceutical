# Vendor Bills Feature for Goods Receiving Notes (GRN)

## Overview
This feature allows users to add multiple vendor bills for different items within a single Goods Receiving Note (GRN). Each item can have its own vendor bill number, date, and amount.

## Features Implemented

### 1. Database Structure
- **Table**: `goods_receiving_vendor_bills`
- **Fields**:
  - `id` - Primary key
  - `goods_receiving_id` - Foreign key to GRN
  - `item_index` - Index of the item in the GRN
  - `bill_no` - Vendor bill number
  - `bill_date` - Bill date (optional)
  - `amount` - Bill amount
  - `created_at`, `updated_at` - Timestamps

### 2. Frontend Changes

#### Create Form (`create.blade.php`)
- Added vendor bill section with dynamic rows
- Each row includes:
  - Item selection dropdown
  - Vendor bill number (required)
  - Bill date (optional)
  - Amount (optional)
  - Remove button

#### Edit Form (`edit.blade.php`)
- Same vendor bill section as create form
- Pre-populated with existing vendor bill data
- Dynamic row management

#### Show View (`show.blade.php`)
- Added vendor bill column to main items table
- Added vendor bills summary section below main table
- Shows total vendor bills amount

### 3. Backend Changes

#### Model (`GoodsReceivingVendorBill.php`)
- New model for vendor bills
- Relationships with GoodsReceiving
- Helper method for item description

#### GoodsReceiving Model Updates
- Added `vendor_bills()` relationship
- Added `approvedBy()` relationship

#### Service Layer Updates (`GoodsReceivingService.php`)
- **Create**: Handles vendor bill creation
- **Update**: Deletes existing vendor bills and creates new ones
- **Delete**: Removes vendor bills when GRN is deleted
- **Show**: Loads vendor bills with relationships

### 4. JavaScript Functions

#### Vendor Bill Management
- `addVendorBillRow()` - Adds new vendor bill row
- `removeVendorBillRow()` - Removes vendor bill row
- `generateItemOptions()` - Generates item dropdown options
- `updateVendorBillItemDetails()` - Updates item details when selected
- `calculateVendorBillTotal()` - Calculates total vendor bill amount

## Usage

### Adding Vendor Bills
1. Fill in the main GRN form with items
2. In the "Vendor Bills" section, click "Add Vendor Bill"
3. Select the item from dropdown
4. Enter vendor bill number (required)
5. Enter bill date and amount (optional)
6. Repeat for additional vendor bills

### Editing Vendor Bills
1. Existing vendor bills are displayed in the edit form
2. Modify fields as needed
3. Add/remove vendor bill rows as required

### Viewing Vendor Bills
1. Vendor bill information is displayed in the show view
2. Main table shows vendor bill for each item
3. Summary section shows all vendor bills with totals

## Database Migration

Run the migration to create the vendor bills table:
```bash
php artisan migrate
```

## Benefits

1. **Flexibility**: Multiple vendor bills per GRN
2. **Professional**: Better tracking and audit trail
3. **User-friendly**: Easy to manage multiple vendor bills
4. **Scalable**: Easy to extend with additional fields
5. **Compliance**: Better tracking for accounting and compliance

## Future Enhancements

1. **Vendor Bill Validation**: Ensure vendor bill numbers are unique
2. **Amount Reconciliation**: Compare vendor bill amounts with GRN totals
3. **Document Upload**: Allow vendor bill document attachments
4. **Payment Tracking**: Link vendor bills to payment records
5. **Reporting**: Generate vendor bill reports and analytics

## Technical Notes

- Uses dynamic form generation for vendor bill rows
- Maintains data integrity with proper relationships
- Handles both create and update scenarios
- Includes proper error handling and validation
- Follows Laravel best practices and conventions
