<?php



class PermissoesDTO {
    private $men_id;
    private $par_id;

    function __construct($arrayMenu) {
        $this->fillObjPermissoes($arrayMenu);
    }
    public function fillObjPermissoes($arrayMenu){
        $this->setMen_id($arrayMenu['men_id']);
        $this->setPar_id($arrayMenu['per_id']);
    }
     
    function getMen_id() {
        return $this->men_id;
    }

    function getPar_id() {
        return $this->par_id;
    }

    function setMen_id($men_id) {
        $this->men_id = $men_id;
    }

    function setPar_id($par_id) {
        $this->par_id = $par_id;
    }



}
