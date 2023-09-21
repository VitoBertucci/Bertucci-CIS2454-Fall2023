<?php     
    //get inputs from form
    $input_name = htmlspecialchars(filter_input(INPUT_GET, 'input_name', FILTER_SANITIZE_STRING));
    $input_deductions = filter_input(INPUT_GET, 'input_deductions', FILTER_VALIDATE_FLOAT);
    $input_gross = filter_input(INPUT_GET, 'input_gross', FILTER_VALIDATE_FLOAT);
    $valid = false;
    $message = "";
    
    // Validate and append error message if needed
    if (isset($input_name) && ctype_alpha(trim($input_name))) {
        $name = trim($input_name);
    } else {
        $message .= "Invalid Name <br>";
    }
    
    if (isset($input_gross) && is_numeric($input_gross) && $input_gross > 0) {
        $gross = $input_gross;
    } else {
        $message .= "Gross Income must be a positive number <br>";
    }
    
    if (isset($input_deductions) && is_numeric($input_deductions) && $input_deductions >= 0) {
        $deductions = $input_deductions;
        // Check if deductions are less than standard deduction
        if ($deductions < 12950) {
            $deductions = 12950;
        }
    } else {
        $message .= "Deductions must be a positive number <br>";
    }
    
    if ($gross - $deductions < 0) {
        $message .= "Adjusted Gross Income must be positive <br>";
        $deductions = null;
    }
    
    if(isset($name) && isset($gross) && isset($deductions)) {
        $valid = true;
    }
    

    //only calculate if all inputs are validated
    if ($valid) {
        // Arrays to store tax brackets and rates
        $brackets = [11000, 44725, 95375, 182100, 231250, 231250, 578125];
        $rates = [0.10, 0.12, 0.22, 0.24, 0.32, 0.35, 0.37];

        // Calculate adjusted gross income as (gross income - deductions)
        $gross_adjusted = $gross - $deductions;

        // Initialize total taxes owed
        $total_taxes_owed = 0;

        // Create an array to store taxes owed at each tax bracket
        $owed = [0, 0, 0, 0, 0, 0, 0];

        // Calculate taxes owed at each tax bracket
        for ($i = 0; $i < count($brackets); $i++) {
            $bracket_size = $brackets[$i];
            $tax_rate = $rates[$i];

            // Check if adjusted gross income is within this bracket
            if ($gross_adjusted <= 0) {
                break;
            }
            
            if ($gross_adjusted <= $bracket_size) {
                // Calculate taxes for this bracket
                $taxes_owed = $gross_adjusted * $tax_rate;
            } else {
                // Calculate taxes for the full bracket
                $taxes_owed = $bracket_size * $tax_rate;
            }

            // Store taxes owed for this bracket in the $owed array
            $owed[$i] = $taxes_owed;

            // Deduct taxes from adjusted gross income
            $gross_adjusted -= $bracket_size;

            // Add taxes to the total
            $total_taxes_owed += $taxes_owed;
        }       
    }
        
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="index.php" method="get">
            <label>Name: </label>
            <input type="text" name="input_name" required><br>
            <label>Gross Income: </label>
            <input type="number" name="input_gross" required><br>
            <label>total deductions: </label>
            <input type="number" name="input_deductions" required><br>
            <input type="submit" value="Submit"/>
        </form>
        
        <?php
            
            //if form has been submitted
            if (!empty($_GET)) {
                
                //if all inputs are validated
                if($valid) {
                    
                    //display all input values
                    echo "name: " . $name . "<br>";
                    echo "Gross Income: $" . number_format($gross) . "<br>"; 
                    echo "Total Deductions: $" . number_format($deductions) . "<br>"; 
                    echo "Adjusted Gross Income: $" . number_format(($gross - $deductions)) . "<br>";
                    
                    //display results of tax bracket calculation
                    for($i = 0; $i < count($owed); $i++) {
                        echo "Taxes Owed at " . $rates[$i] * 100 ."% bracket : $" . number_format($owed[$i]) . "<br>";
                    }
                    
                    //display totals and percentages
                    echo "Total Taxes Owed : $" . number_format($total_taxes_owed) . "<br>";
                    echo "Taxes Owed as percentage of income : " . round(($total_taxes_owed / $gross) * 100, 2) .  "% <br>";
                    echo "Taxes Owed as percentage of adjusted gross income : " . round(($total_taxes_owed / ($gross - $deductions) * 100), 2) ."%";
                } else {
                    
                    //display error message on error
                    echo $message;
                }
            }        
        ?>
    </body>
</html>