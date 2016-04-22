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
        $yearlyTuition = 15000;
        $gradDegreeLength = 2;
        $yearlyGradDegreeIncome = 7000;
        $gradSalary = 55000;
        
        
        $disicions = array();
        $basicDecison = new basic_net_value($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate);
        $gradDecision = new GS_net_value($gradSalary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate, $yearlyTuition, $gradDegreeLength, $yearlyGradDegreeIncome);
        $disicions[] = &$basicDecision;
        
        $basicDecison->calcTaxObligation();//calculate first years tax obligation
        for ($h = 0; $h < $years; $h++)//years
        {
            for ($i = 0; $i < 12; $i ++)//months 
            {
                $basicDecison->simulateOneMonth();
                $gradDecision->simulateOneMonth();
            }
            //updated need varaibles in the basicDecision object
            $basicDecison->updateSalary();           
            $basicDecison->updateLivingExpenses();
            $basicDecison->calcTaxObligation();
            $gradDecision->updateSalary();           
            $gradDecision->updateLivingExpenses();
            $gradDecision->calcTaxObligation();
            
            //echo "Y" .  $h . "<br>";
            //$basicDecison->printInfo();
        }
        $basicDecison->printInfo();      
        $gradDecision->printInfo();

        ?>
    </body>
</html>
