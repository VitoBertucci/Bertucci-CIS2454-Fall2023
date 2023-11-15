
<?php
    /*
     * Rubric:
     *  form: accept and store wage, hours/wk, and tax rate
     *  calculate: pay for first 40, pay for overtime, taxes
     *  display: (+)total pay, (-)total taxes, (=) net pay
     *  commit and push to repo
     *  submit url to php file in repo 
     */
     
    //get inputs from form
    $wage = filter_input(INPUT_GET, 'wage');
    $hours = filter_input(INPUT_GET, 'hours');    
    $tax_rate = filter_input(INPUT_GET, 'tax_rate');
    $pay_gross = 0.0;
    
    
    //gross pay: loop for total hours, add wage to total each iteration, if over 40, add (wage * 1.5)
    for ($i = 1; $i <= $hours; $i++) {
        if($i > 40) {
            $pay_gross += ($wage * 1.5);
        } else {
            $pay_gross += $wage;
        }
    }
    
    //taxes deducted: take gross pay, calculate amount to be deducted, subtract deducted from gross
    $tax_deducted = $pay_gross * ($tax_rate/100);
    $pay_net = $pay_gross - $tax_deducted;
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="index.php" method="get">
            <label>Wage: </label>
            <input type="text" name="wage" required><br>
            <label>Hours: </label>
            <input type="text" name="hours" required><br>
            <label>Tax rate (percentage): </label>
            <input type="text" name="tax_rate" required><br>
            <input type="submit" value="Submit"/>
        </form>
        
        <?php
        
        //only show once all fields are filled out, or if the form has been submitted before
        if (isset($tax_rate)) {
            echo $hours . " hours at $" . $wage . " an hour with a " . $tax_rate . "% tax rate:" . "<br>";
            echo "Gross pay: $" . round($pay_gross, 2) . "<br>";
            echo "Taxes deducted: $" . round($tax_deducted, 2) . "<br>";
            echo "Net pay: $" . round($pay_net, 2);
        }
        ?>
    </body>
</html>

