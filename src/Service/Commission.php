<?php

declare(strict_types=1);

namespace Task1\CommissionTask\Service;

use Task1\CommissionTask\Entity\Client;
use DateTime;

Class Commission{
    const DEPOSIT_COMMISSION = 0.03;
    const WITHDRAWAL_COMMISSION_PRIVATE = 0.3;
    const WITHDRAWAL_COMMISSION_BUSINESS = 0.5;
    private $clientOperations;
    private $lastWidthdrawalMonday;
    private $clientOperationCount;
    private $clientTotalWithdrawal;
    private $currentClientId;
    private $converter;

    public function __construct(array $initialOperations)
    {
        $this->clientOperations = [];
        foreach($initialOperations as $operation){
            $this->clientOperations[$operation->getClientId()][] = $operation;
        }
        $this->resetDate();
        $this->resetOperationCount();
        $this->currentClientId = -1;
        $this->clientTotalWithdrawal = 0;
        $this->converter = new Converter(1, 1.1497, 129.53);
    }
    private function resetDate(){
        $this->lastWidthdrawalMonday = new DateTime('1000-01-01');
    }
    private function resetOperationCount(){
        $this->clientOperationCount = 0;
    }
    public function calculateCommission(){
        foreach ($this->clientOperations as $clientOperations){
            $this->resetDate();
            $this->resetOperationCount();
            foreach($clientOperations as $operation){

                switch($operation->getOperationType()){
                    case 'deposit':
                        $operation->setFees(
                            $operation->getAmount() * (self::DEPOSIT_COMMISSION / 100)
                        );
                        break;
                    case 'withdraw':
                        $this->calculateUsingWithdrawalRule($operation);
                        break;
                        
                }
            }
            //print_r($clientOperations);
        }
    }
    private function calculateUsingWithdrawalRule(Client $operation){
        $clientId = $operation->getClientId();
        if($clientId !== $this->currentClientId ||
            $clientId === -1){
            $this->resetDate();
            $this->resetOperationCount();
            $this->currentClientId = $clientId;
            $this->clientTotalWithdrawal = 0;
        }

        switch($operation->getClientType()){
            case 'private':
                $nextMonday = new DateTime($operation->getDate());
                $nextMonday->modify('next monday');
                if($nextMonday != $this->lastWidthdrawalMonday){
                    $this->resetOperationCount();
                    $this->clientTotalWithdrawal = 0;
                    $this->lastWidthdrawalMonday = $nextMonday;
                }
                if($this->clientOperationCount > 3 ||
                    $this->clientTotalWithdrawal > 1000){
                    $operation->setFees(
                        $operation->getAmount() * (self::WITHDRAWAL_COMMISSION_PRIVATE / 100)
                    );
                } else {
                    $widthdrawalAmount = $this->converter->convertToEuros(
                        $operation->getAmount(), $operation->getCurrency()
                    );
                    $this->clientTotalWithdrawal += $widthdrawalAmount;
                    if($this->clientTotalWithdrawal > 1000){
                        $commissionAmount = $this->clientTotalWithdrawal - 1000;
                        $commissionAmount = $this->converter->convertFromEuros(
                            $commissionAmount, $operation->getCurrency()
                        );
                        $operation->setFees(
                            $commissionAmount * (self::WITHDRAWAL_COMMISSION_PRIVATE / 100)
                        );
                    }
                    $this->clientOperationCount++;
                }
                break;
            case 'business':
                $operation->setFees(
                    $operation->getAmount() * (self::WITHDRAWAL_COMMISSION_BUSINESS / 100)
                );
                break;
        }
    }
    public function getOutput(array $operations) : array{
        $feeArray = [];
        foreach($operations as $operation){
            $clientId = $operation->getClientId();
            foreach($this->clientOperations[$clientId] as $clientOperation){
                if($clientOperation === $operation){
                    $fee = $this->roundFees($clientOperation);
                    $feeArray[] = $fee;
                    echo $fee . "\n";
                }
            }
        }
        return $feeArray;
    }
    private function roundFees(Client $operation) : string{
        $currency = $operation->getCurrency();
        $fees = $operation->getFees();
        if($currency === "EUR" || $currency === "USD"){
            $fees = number_format($fees, 2, '.', '');
        } else if($currency === "JPY"){
            $fees = number_format($fees, 0, '.', '');
        }
        return $fees;
    }
}
