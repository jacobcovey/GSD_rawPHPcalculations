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
class basic_net_value {// Class used for calculating net for users "no grad school" option
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
        $this->originalDebtMinimumPayment = $this->originalDebt * (($this->originalIntrestRate/12)/(1-(pow(1+($this->originalIntrestRate/12),-180))));//calculate the minimum loan payment and assign result to varaible
        //$this->originalDebtMinimumPayment = pow($originalIntrestRate,3);
        $this->monthlySalary = $this->salary / 12;
        $this->taxObligation = 0;
        $this->taxableIncome = 0;
    }
 
    function calcTaxObligation() //Uses federal tax bracket as of April 2016 to calculate the total federal tax obligation
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
    function simulateOneMonth()// add one years intrest to debt balance. Calculate how much of monthly salary is left over after living expenses and minimum debt payment. Apply remaining money to debt.
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
    function updateSalary()//update salary for one year
    {
        $this->salary *= (1+ $this->salaryGrothRate);
        $this->monthlySalary = $this->salary/12;
    }
    function  updateLivingExpenses()//update living expense for one year
    {
        $this->monthlyLivingExpense *= (1+ $this->livingExpenseGrowthRate);
    }
    function calcNetValue()
    {
        $this->netValue = $this->savings - $this->debtBalance;
    }
    function printInfo()
    {
        echo "Current Net Value: $"  .number_format($this->netValue) . "<br>";       
        echo "Current Monthly Salary: $" .number_format($this->monthlySalary) . "<br>";       
        echo "Current Monthly Living Expenses: " .number_format($this->monthlyLivingExpense) . "/month<br>";       
        echo "Current Debt Balance: " .number_format($this->debtBalance) . "<br>";       
        echo "Current Savings Balance: " .number_format($this->savings) . "<br>";       

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
