<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Stage 1 Calculator</title>
    </head>
    <body>
        <?php
        include("basic_net_value.php");
        $salary = 40000;
        $salaryGrothRate = .06;
        $originalDebt = 32000;
        $originalIntrestRate = .0621;
        $monthlyLivingExpense = 2800;
        $livingExpenseGrowthRate = .06;
        $years = 40;
        
        
        $disicions = array();
        $basicDecison = new basic_net_value($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate);
        $disicions[] = &$basicDecision;
        
        $basicDecison->calcTaxObligation();//calculate first years tax obligation
        for ($h = 0; $h < $years; $h++)//years
        {
            for ($i = 0; $i < 12; $i ++)//months 
            {
                $basicDecison->simulateOneMonth();
            }
            //updated need varaibles in the basicDecision object
            $basicDecison->updateSalary();           
            $basicDecison->updateLivingExpenses();
            $basicDecison->calcTaxObligation();
            
            echo "Y" .  $h . "<br>";
            $basicDecison->printInfo();
        }
        $basicDecison->printInfo();      
        

        ?>
    </body>
</html>
