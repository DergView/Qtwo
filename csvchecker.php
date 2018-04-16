<?php

/**
 * Checks if a string is a valid Unix timestamp.
 *
 * @param  string $timestamp - Timestamp to validate.
 * 
 * @return bool
 */
function is_timestamp($timestamp)
{
	$check = (is_int($timestamp) || is_float($timestamp)) ? $timestamp : (string) (int) $timestamp;
	return  ($check === $timestamp) && ( (int) $timestamp <=  PHP_INT_MAX) && ( (int) $timestamp >= ~PHP_INT_MAX);
}

/**
 * Parses a user provided csv file according to the validation rules.
 *
 * @param  string $csvFile - Filepath for the CSV file passed in by the user.
 * 
 * @return int OR @return float $totalSum - the sum of the third column for valid rows in the csv file
 */

function parseCSV($csvFile) 
{   
    $totalSum = 0;

    // Open the CSV for reading according to the provided filepath

    if (($handle = fopen($csvFile, "r")) !== false) {
        
        // Read each row of data from the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $numColumns = count($data);

            // Check the row does not contain more than 3 columns - otherwise skip to next row
            
            if ($numColumns > 3) {                
                continue;
            }
            // A regular expression to check the ID field (column 1) is valid - otherwise skip to next row   

            if (!preg_match("/(^[A-Za-z]{3,5}-[0-9]{1,}\.{0,1}[0-9]{0,}$)/", $data[0])) {                
                continue;
            };           
            
            //Check that the number field is numeric - if it's not, skip to next row

            if (!is_numeric($data[2])) {
                continue;
            };

            //Check the Unix Timestamp is valid - if it's not skip to the next row

            if (!is_timestamp($data[1])) {
                continue;
            };
           
            // Sum the value of the third column for each valid row
            $totalSum += $data[2];
        }
        
        // Close the filehandle once all the data has been read
        
        fclose($handle);
        return $totalSum;

    } else {
        echo("Sorry unable to open your file. Please check the filepath is correct.");
    }
    
}
// Check that the user has provided a file path - provide an error message if not

if (!empty($argv['1'])) {

    $filePath= $argv['1'];

    // Check that the file path is correct - provide an error message if not

    if ( !file_exists($filePath) ) {        
        echo("Sorry unable to locate your csv file. Please check the filepath is correct.");
        exit;
      }
    // Pass the CSV filepath to our parser function

    $parseResult = parseCSV($filePath);

    // Return a result to the user - the total of the third column for the valid rows

    echo("The total of the third column for the valid rows in your CSV file is: ".$parseResult);

} else {
    echo("Please ensure you have entered the path to your csv file.");
}
?>