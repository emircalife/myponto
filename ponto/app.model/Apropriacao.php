<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Apropriacao
 *
 * @author 80058442553
 */
class Apropriacao extends Dao {
    //put your code here
    private $id;
    private $codProfFuncao;
    private $data;
    private $cc;
    private $valor;

    public function getCodProfFuncao() {
        return $this->codProfFuncao;
    }

    public function setCodProfFuncao($codProfFuncao) {
        $this->codProfFuncao = $codProfFuncao;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getCc() {
        return $this->cc;
    }

    public function setCc($cc) {
        $this->cc = $cc;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAll()
    {
        try{
            $sql = "SELECT id, cc, total
                   FROM hor_aprop
                   WHERE cod_prof_funcao = ".$this->getCodProfFuncao().
                   " AND data = '".$this->getData()."';";
            $rs = parent::obterRecordSet($sql);
            $vAprop = array();
            foreach($rs as $row)
            {
                $oAprop = new Apropriacao;
                $oAprop->setId($row["id"]);
                $oAprop->setCc($row["cc"]);
                $oAprop->setCodProfFuncao($pCodProfFuncao);
                $oAprop->setData($pData);
                $oAprop->setValor($row["total"]);
                $vAprop[] = $oAprop;
                unset($oAprop);
            }
            return $vAprop;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function add()
    {
        try{
            $sql = "INSERT INTO hor_aprop (cod_prof_funcao, data, cc, total)
                    VALUES ("
            .$this->getCodProfFuncao().",'"
            .$this->getData()."',"
            .$this->getCc().",'"
            .$this->getValor()."');";
            $rs = parent::executar($sql);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function excluir()
    {
        try{
            $sql = "DELETE FROM hor_aprop
                    WHERE id = " . $this->getId();
            $rs = parent::executar($sql);
            return true;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function getById()
    {
        try{
            $sql = "SELECT id, data, cod_prof_funcao, cc, total
                   FROM hor_aprop
                   WHERE id = ".$this->getId().";";
            $rs = parent::obterRecordSet($sql);
            if($rs)
            {
                $this->setId($rs[0]["id"]);
                $this->setCc($rs[0]["cc"]);
                $this->setCodProfFuncao($rs[0]["cod_prof_funcao"]);
                $this->setData($rs[0]["data"]);
                $this->setValor($rs[0]["total"]);
            }
            return true;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function getTotalApropriado()
    {
        try{
            $sql = "SELECT SUM(total)
                   FROM hor_aprop
                   WHERE cod_prof_funcao = ".$this->getCodProfFuncao().
                   " AND data = '".$this->getData()."';";
            $ret = parent::executarScalar($sql);
            return $ret;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function getSaldoApropriar()
    {
        try{

            $oProf = Sessao::getObject("oProf");
            $oRegistro = new Registro;
            $oRegistroD = new RegistroDao;
            $oRegistro = $oRegistroD->getByDate($oProf, $this->getData());
            if($oRegistro){
                $tRegistrado = $oRegistro->getTotal();
            }else{
                $tRegistrado = 0;
            }
            $tApropriado = $this->getTotalApropriado();
            $vSaldo = $tRegistrado - $tApropriado;

            return $vSaldo;

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }


}
?>
