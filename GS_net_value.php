
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GS_net_value
 *
 * @author jcovey
 */
   
    //include("basic_net_value.php");

class GS_net_value extends basic_net_value // Used to calculate the net value for the Grad School option
{
    protected $yearlyTuition;    
    protected $monthlyTuition;
    protected $gradDegreeLength;// In years
    protected $yearlyGradDegreeIncome;//Income made during the graduate program
    protected $monthlyGradDegreeIncome;
    protected $graduated;
    protected $degreeInMonths;
    public function __construct($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate, $yearlyTuition, $gradDegreeLength, $yearlyGradDegreeIncome) {
        parent::__construct($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate);
        
        $this->yearlyTuition = $yearlyTuition;
        $this->monthlyTuition = $yearlyTuition / 12;
        $this->gradDegreeLength = $gradDegreeLength;
        $this->yearlyGradDegreeIncome = $yearlyGradDegreeIncome;
        $this->graduated = false;
        $this->degreeInMonths = $gradDegreeLength;
        $this->monthlyGradDegreeIncome = $yearlyGradDegreeIncome / 12;
    }
     function simulateOneMonth()// add one years intrest to debt balance. Calculate how much of monthly salary is left over after living expenses and minimum debt payment. Apply remaining money to debt.
    {
        $this->debtBalance *= (($this->originalIntrestRate/12)+ 1);
        
        if (!$this->graduated)
        {
            $this->debtBalance += $this->monthlyTuition + $this->monthlyLivingExpense - $this->monthlyGradDegreeIncome;
        }
        else 
        {
            $this->monthLeftOver = $this->monthlySalary - $this->monthlyLivingExpense - $this->originalDebtMinimumPayment;
            if ($this->debtBalance >$this->monthLeftOver && $this->monthLeftOver > 0 )
            {
                $this->debtBalance -= $this->monthLeftOver;
            }
            else if ($this->debtBalance < $this->monthLeftOver)
            {          
                $this->savings += $this->monthLeftOver - $this->debtBalance;
                $this->debtBalance = 0;
            }
        }
        $this->calcNetValue();
    }
    function checkIfGraduated($years)//Checks if years simulated is => years of grad degree. If yes then it updates the objects graduation status
    {
        if (($years) >= $this->gradDegreeLength )
        {
            $this->graduated = true;
        }
    }
}
