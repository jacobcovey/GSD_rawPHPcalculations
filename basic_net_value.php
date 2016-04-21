<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of basic_net_value
 *
 * @author jcovey
 */
class basic_net_value {
    protected $salary;
    protected $salaryGrothRate;
    protected $originalDebt;
    protected $originalIntrestRate;
    protected $monthlyLivingExpense;
    protected $livingExpenseGrowthRate;
    private $netValue;
    private $debtBalance;
    private $savings;
    private $taxableIncome;
    private $taxObligation;
    protected $originalDebtMinimumPayment;
    private $monthlySalary;
    private $monthLeftOver;
    
    function __construct($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate) 
    {
        $this->salary = $salary;
        $this->salaryGrothRate = $salaryGrothRate;
        $this->originalDebt = $originalDebt;
        $this->originalIntrestRate = $originalIntrestRate;
        $this->monthlyLivingExpense = $monthlyLivingExpense;
        $this->livingExpenseGrowthRate = $livingExpenseGrowthRate;
        $this->savings = 0;
        $this->monthLeftOver = 0;
        //$this->dailyIntrestRate = $this->calcDailyIntrestRate();
        $this->debtBalance = $originalDebt;
        $this->netValue = $this->savings - $this->debtBalance;
        $this->originalDebtMinimumPayment = $this->originalDebt * (($this->originalIntrestRate/12)/(1-(pow(1+($this->originalIntrestRate/12),-180))));
        //$this->originalDebtMinimumPayment = pow($originalIntrestRate,3);
        $this->monthlySalary = $this->salary / 12;
        $this->taxObligation = 0;
        $this->taxableIncome = 0;
    }
 
    function calcTaxObligation()
    {
        $this->taxableIncome = $this->salary;
        $this->taxableIncome -= 6300;//standard deduction
        if ($this->taxableIncome < 9075)
        {
            $this->taxObligation = 0;
        }
        else if ($this->taxableIncome < 36900)
        {
            $this->taxObligation = 907.5 + (($this->taxableIncome - 9075) * .15);
        }
        else if ($this->taxableIncome < 89350)
        {
            $this->taxObligation = 5081.25 + (($this->taxableIncome - 36900) * .25);
        }
        else if ($this->taxableIncome < 186350)
        {
            $this->taxObligation = 18193.75 + (($this->taxableIncome - 89350) * .28);
        }
        else if ($this->taxableIncome < 405750)
        {
            $this->taxObligation = 43353.75 + (($this->taxableIncome - 186350) * .33);
        }
        else if ($this->taxableIncome < 406750)
        {
            $this->taxObligation = 117541.25 + (($this->taxableIncome - 405750) * .35);
        }
        else 
        {
            $this->taxObligation = 118118.75 + (($this->taxableIncome - 406750) * .396);
        }
    }
    function simulateOneMonth()
    {
        
        $this->debtBalance *= (($this->originalIntrestRate/12)+ 1);
        $this->monthLeftOver = $this->monthlySalary - $this->monthlyLivingExpense - $this->originalDebtMinimumPayment;
        if ($this->debtBalance >$this->monthLeftOver)
        {
            $this->debtBalance -= $this->monthLeftOver;
        }
        else
        {          
            $this->savings += $this->monthLeftOver - $this->debtBalance;
            $this->debtBalance = 0;
        }
        $this->calcNetValue();
    }
    function updateSalary()
    {
        $this->salary *= (1+ $this->salaryGrothRate);
        $this->monthlySalary = $this->salary/12;
    }
    function  updateLivingExpenses()
    {
        $this->monthlyLivingExpense *= (1+ $this->livingExpenseGrowthRate);
    }
    function calcNetValue()
    {
        $this->netValue = $this->savings - $this->debtBalance;
    }
    function getOriginalDebtMinimumPayment() 
    {
        return $this->originalDebtMinimumPayment;
    }
        function getNetValue() 
    {
        
        return $this->netValue;
    }
    function printNetValue()
    {
        echo $this->debtBalance;
    }
    function getDebtBalance() 
    {
        return $this->debtBalance;
    }

    function getSavings() 
    {
        return $this->savings;
    }


    
}
