<?php

class PacoteDTO {

    private $pacId;
    private $pacCusto;
    private $pacTimestamp;
    
    public function __construct() {
        
    }
    
    //getters
    function getPacId() {
        return $this->pacId;
    }

    function getPacCusto() {
        return $this->pacCusto;
    }

    function getPacTimestamp() {
        return $this->pacTimestamp;
    }

    //setters
    function setPacId($pacId) {
        $this->pacId = $pacId;
    }

    function setPacCusto($pacCusto) {
        $this->pacCusto = $pacCusto;
    }

    function setPacTimestamp($pacTimestamp) {
        $this->pacTimestamp = $pacTimestamp;
    }


}

?>