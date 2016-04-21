<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include("basic_net_value.php");
        $salary = 40000;
        $salaryGrothRate = .06;
        $originalDebt = 32000;
        $originalIntrestRate = .0621;
        $monthlyLivingExpense = 2200;
        $livingExpenseGrowthRate = .065;
        $years = 40;
        
        
        $disicions = array();
        $basicDecison = new basic_net_value($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate);
        $disicions[] = &$basicDecision;
        
        $basicDecison->calcTaxObligation();
        for ($h = 0; $h < $years; $h++)
        {
            for ($i = 0; $i < 12; $i ++)
            {
                $basicDecison->simulateOneMonth();
            }
            $basicDecison->updateSalary();           
            $basicDecison->updateLivingExpenses();
            $basicDecison->calcTaxObligation();
            echo "Year " . $h . ": " . $basicDecison->getNetValue() . "<br>";      

        }
        
        

        ?>
    </body>
</html>