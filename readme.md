Project Title: CSV Parser

Aim: 
To parse a user provided CSV file acoording to the following validation rules:

The CSV must only have 3 columns per row
○ The first column must be in the following format:
    ■ 3 - 5 alphabetic character
    ■ Hyphen
    ■ A numeric value
    ■ e.g. ABCD-123, EFG-4 or HIJKL-5678
○ The second column must be a valid unix timestamp
○ The third column must be a numeric value (decimal values are accepted)
○ Ignore rows with invalid data (do not error out on invalid rows, simply ignore them)

On parsing the file - calculate and return the sum of the third column of each valid row

The project can be run from the command line and the result is returned to the user there.

Usage: $ php csvchecker.php {yourfile.csv}

Example Usage :- $ php csvchecker.php testdata.csv