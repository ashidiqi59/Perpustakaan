# TODO - Fix Loan Return for Overdue Books

## Problem
When admin clicks "Kembalikan" on overdue loans, the status doesn't change to "dikembalikan" and users can't borrow books again.

## Root Cause
1. `getActualStatus()` was returning 'terlambat' even when `return_date` was set (book was returned late)
2. The return button condition depended on `getActualStatus() !== 'dikembalikan'`, which caused issues
3. The database status wasn't being set correctly to 'dikembalikan'

## Solution Implemented

### 1. Fixed `app/Models/Loan.php`:
- **`getActualStatus()`**: Now returns 'dikembalikan' as long as `return_date` is set (regardless of being late)
- **`getDaysLate()`**: Still calculates late days correctly (return_date > due_date = late)

### 2. Fixed `app/Http/Controllers/LoanController.php`:
- **`return()` method**: Always sets status to 'dikembalikan' and restores book stock
- **`adminIndex()`**: Only updates status to 'terlambat' for loans that haven't been returned yet (return_date is null)

### 3. Fixed `resources/views/admin/loans/index.blade.php`:
- Added new badge "Dikembalikan (Terlambat)" shown in red when status is 'dikembalikan' but returned late

## Result
- Admin can click "Kembalikan" on overdue loans
- Status changes to 'dikembalikan' 
- Display shows "Dikembalikan (Terlambat)" badge in red with late indicator
- Book stock is restored
- User can borrow the same book again


