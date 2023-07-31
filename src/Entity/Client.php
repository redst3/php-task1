<?php

declare(strict_types=1);

namespace Task1\CommissionTask\Entity;

class Client{

    private  string $date;
    private int $clientId;
    private string $clientType;
    private string $operationType;
    private float $amount;
    private string $currency;
    private float $fees;

    public function __construct(string $date, int $clientId, string $clientType, string $operationType, float $amount, string $currency)
    {
        $this->date = $date;
        $this->clientId = $clientId;
        $this->clientType = $clientType;
        $this->operationType = $operationType;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->fees = 0;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getClientType(): string
    {
        return $this->clientType;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getFees(): float
    {
        return $this->fees;
    }

    public function setFees(float $fees) : void
    {
        $this->fees = $fees;
    }

}
