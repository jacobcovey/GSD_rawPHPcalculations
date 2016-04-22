        <?php
        include("BasicCalculation.html");
        include("basic_net_value.php");
        include("GS_net_value.php");
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
        $gradSalary = 50000;
        
        $NVswitch = false;
        
        $disicions = array();
        $basicDecison = new basic_net_value($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate);
        $gradDecision = new GS_net_value($gradSalary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate, $yearlyTuition, $gradDegreeLength, $yearlyGradDegreeIncome);
        $disicions[] = &$basicDecision;
        
        $basicDecison->calcTaxObligation();//calculate first years tax obligation
        for ($h = 0; $h < $years; $h++)//years
        {
            $gradDecision->checkIfGraduated($h);

            for ($i = 0; $i < 12; $i ++)//months 
            {
                $basicDecison->simulateOneMonth();
                $gradDecision->simulateOneMonth();
                
                if (!$NVswitch)
                {
                    if ($basicDecison->getNetValue() <= $gradDecision->getNetValue())
                    {
                        $NVswitch = true;
                        $timeUntilNetValueEquals = array($h,$i);
                    }
                }
            }
            //updated need varaibles in the basicDecision object
            $basicDecison->updateSalary();           
            $basicDecison->updateLivingExpenses();
            $basicDecison->calcTaxObligation();
           
            if ($h >= $gradDegreeLength)
            {
                $gradDecision->updateSalary();
            }
            $gradDecision->updateLivingExpenses();
            $gradDecision->calcTaxObligation();
            
            /*
            echo "Y " .  $h . " Basic:<br>";
            $basicDecison->printInfo(); 
            echo "Y " .  $h . " Grad:<br>";
            $gradDecision->printInfo();  
             * 
             */  
        }
        /*
        echo " Basic:<br>";        
        $basicDecison->printInfo(); 
        echo " Grad:<br>";
        $gradDecision->printInfo();
        echo "At " . $timeUntilNetValueEquals[0] . " Years and " . $timeUntilNetValueEquals[1] . " Months the net values were aproxamently equal.";
        */ 