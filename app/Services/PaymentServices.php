<?php

namespace App\Services;

use App\Repositories\CreditCardRepository;

class PaymentServices{

    /**
     * @var CreditCardRepository
     */
    private $creditCardRepository;

    public function __construct(CreditCardRepository $creditCardRepository)
    {

        $this->creditCardRepository = $creditCardRepository;
    }

    public function newCreditCard($data)
    {
        $cardExists = $this->cardExists($data['number']);

        if(!$cardExists)
        {
            if($this->creditCardRepository->create($data))
            {
                return true;
            }
        }

        return false;
    }

    /*
     * Verifica se o cartão de crédito já existe
     */
    public function cardExists($number)
    {
        $card = $this->creditCardRepository->findByField('number', $number);

        if(count($card) > 0)
        {
            return true;
        }

        return false;
    }
}



