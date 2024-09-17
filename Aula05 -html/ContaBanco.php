<?php

class ContaBanco {
    // Attributes
    public $numConta;
    protected $tipo;
    private $dono;
    private $saldo;
    private $status;

    // Methods
    public function abrirConta($t) {
        $this->setTipo($t);
        $this->setStatus(true);
        if ($t == "CC") {
            $this->setSaldo(50);
        } else if ($t == "CP") {
            $this->setSaldo(150);
        }
    }

    public function fecharConta() {
        if ($this->getSaldo() > 0) {
            return "Account still has money, cannot close!";
        } elseif ($this->getSaldo() < 0) {
            return "Account is in debt. Impossible to close!";
        } else {
            $this->setStatus(false);
            return "Account of " . $this->getDono() . " closed successfully!";
        }
    }

    public function depositar($v) {
        if ($this->getStatus()) {
            $this->setSaldo($this->getSaldo() + $v);
            return "Deposit of R$ $v in the account of " . $this->getDono();
        } else {
            return "Closed account. Cannot deposit!";
        }
    }

    public function sacar($v) {
        if ($this->getStatus()) {
            if ($this->getSaldo() >= $v) {
                $this->setSaldo($this->getSaldo() - $v);
                return "Withdrawal of R$ $v authorized in the account of " . $this->getDono();
            } else {
                return "Insufficient balance for withdrawal!";
            }
        } else {
            return "Cannot withdraw from a closed account!";
        }
    }

    public function pagarMensal() {
        if ($this->getTipo() == "CC") {
            $v = 12;
        } else if ($this->getTipo() == "CP") {
            $v = 20;
        }
        
        if ($this->getStatus()) {
            $this->setSaldo($this->getSaldo() - $v);
            return "Monthly fee of R$ $v debited from the account of " . $this->getDono();
        } else {
            return "Problems with the account. Cannot charge!";
        }
    }

    // Special Methods
    public function __construct() {
        $this->setSaldo(0);
        $this->setStatus(false);
    }

    // Getters and Setters
    public function getNumConta() { return $this->numConta; }
    public function setNumConta($n) { $this->numConta = $n; }
    
    public function getTipo() { return $this->tipo; }
    public function setTipo($t) { $this->tipo = $t; }

    public function getDono() { return $this->dono; }
    public function setDono($d) { $this->dono = $d; }

    public function getSaldo() { return $this->saldo; }
    public function setSaldo($d) { 
      if ($d >= -100) { // Allow overdraft up to -100
          $this->saldo = $d; 
      }
    }

    public function getStatus() { return $this->status; }
    public function setStatus($s) { 
      if (is_bool($s)) { 
          $this->status = $s; 
      }
   }
}