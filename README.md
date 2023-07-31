# Homework assignment

## Before running the script

```sh
    composer update
    composer install
```

PHP version used for the project `7.4.9`

## To run the script

```sh
    php script.php or php script.php <path-to-file>
```

If no path to file is provided, script will get the default file found in `src\Data\input.csv`. All Commissions will be sorted by client id and fees will be calculated for each commission.

### Deposit rule

All deposits are charged 0.03% of deposit amount.

### Withdraw rules

There are different calculation rules for `withdraw` of `private` and `business` clients.

**Private Clients**

- Commission fee - 0.3% from withdrawn amount.
- 1000.00 EUR for a week (from Monday to Sunday) is free of charge. Only for the first 3 withdraw operations per a week. 4th and the following operations are calculated by using the rule above (0.3%). If total free of charge amount is exceeded them commission is calculated only for the exceeded amount (i.e. up to 1000.00 EUR no commission fee is applied).

**Business Clients**

- Commission fee - 0.5% from withdrawn amount.

## Results

Output of calculated commission fees for each operation.

## Testing

To run all test cases use the following command

```sh
    composer run test
```
