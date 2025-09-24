<?php

// Interface
// Uma interface define um contrato que diz quais métodos uma classe deve implementar, mas não define como.
// Quem implementar essa interface deve ter assinatura igual ao que está nos métodos

interface DataBaseInterface {
    public function connect();
    public function disconnect();
}