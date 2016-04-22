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
class GS_net_value extends basic_net_value // Used to calculate the net value for the Grad School option
{
    private $yearlyTuition;
    private $gradDegreeLength;// In years
    private $yearlyGradDegreeIncome;
    private $graduated;
    private $degreeInMonths;
    public function __construct($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate, $yearlyTuition, $gradDegreeLength, $yearlyGradDegreeIncome) {
        parent::__construct($salary, $salaryGrothRate, $originalDebt, $originalIntrestRate, $monthlyLivingExpense, $livingExpenseGrowthRate);
        
        $this->yearlyTuition = $yearlyTuition;
        $this->gradDegreeLength = $gradDegreeLength;
        $this->yearlyGradDegreeIncome = $yearlyGradDegreeIncome;
        $this->graduated = false;
        $this->degreeInMonths = $gradDegreeLength;
    }
}
