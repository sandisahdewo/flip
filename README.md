# Dev Test Backend Flip

## Features:
- Can send money for disbursement to other banks (fake request).
- After send a fake request, can get information about:
  - `status`
  - `receipt`
  - `time_served` 
- Integrated with third party library.

## Requirements:
- PHP >= 7.x.x
- MySQL

## Installation steps:
1. Clone the repo : `git clone https://github.com/sandiwo/flip.git`
2. `$ cd flip`
3. Create new MySQL database for this application
4. Set database configuration on `app > config > database.php` file
5. `$ php migration-up.php`
6. `$ php -S localhost:8000`
7. Visit `http://localhost:8000/disburse` via web browser
8. Done, you can see welcome message

## Send a Disbursement:

### Request
1. Use a API client application, for example: `Postman` or `REST Client`
2. Make sure to use `POST` method
4. Go to url: `http://localhost:8000/disburse/store`
3. Data attribute:
   - `bank_code`
   - `account_number`, must a number value
   - `amount`, must a number value
   - `remark`
 
Example:
```http
POST http://localhost:8000/disburse/store
Content-Type: application/x-www-form-urlencoded
 
{
  "bank_code": "bca",
  "account_number": "987985165789",
  "amount": "1000000",
  "remark": "Sandi Sahdewo"
}
```
 ### Response
 ```
 {"success":
      {
        "code":"200",
        "data": {
                  "id":5599181191,
                  "amount":100000,
                  "status":"PENDING",
                  "timestamp":"2020-02-27 22:12:03",
                  "bank_code":"bca",
                  "account_number":"1234567890",
                  "beneficiary_name":"PT FLIP",
                  "remark":"Sandi Sahdewo",
                  "receipt":null,
                  "time_served":"0000-00-00 00:00:00",
                  "fee":4000
                }
      }
 }
```

## Get a Disbursement status:
