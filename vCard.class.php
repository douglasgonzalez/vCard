<?php

/**
 * @name      vCard
 * @version   1.5
 * @author Douglas Gonzalez <douglas.gonzalez2207 at gmail dot com>
 * 
 * Criado em 3 de Outubro de 2012
 * 
 */
class vCard {
    /*
     * receber os dados em array multidimensional
     * $dados[0] => $dados[0]['nome'] = Douglas Gonzalez
     * $dados[0] => $dados[0]['telefone'] = 91234-5678
     */

    private $vCard = "";

    public function __construct($dados) {
        if (!empty($dados))
            $this->setDados($dados);
    }

    public function __toString() {
        return $this->vCard;
    }

    private function setDados($dados) {

        $item = 1;
        foreach ($dados as $array) {
            $this->vCard .= "BEGIN:VCARD" . "\r\n";
            $this->vCard .= "VERSION:3.0" . "\r\n";
            foreach ($array as $chave => $value) {
                $chave = strtoupper($chave);
                switch ($chave) {
                    case 'FN':
                        // First Name and Name separated with ';'
                        if (!empty($value)) {
                            $N = explode(" ", $value);
                            $this->vCard .= "N:{$N[1]};{$N[0]};;;" . "\r\n";
                            $this->vCard .= "FN:{$value}" . "\r\n";
                        }
                        break;
                    case 'ORG':
                        // Organization
                        if (!empty($value))
                            $this->vCard .= "ORG:{$value}" . "\r\n";
                        break;
                    case 'ROLE':
                        // Role or occupation
                        // The role, occupation, or business category of the vCard object within an organization (e.g. Executive)
                        if (!empty($value))
                            $this->vCard .= "ROLE:{$value}" . "\r\n";
                        break;
                    case 'BDAY':
                        // Role or occupation
                        // The role, occupation, or business category of the vCard object within an organization (e.g. Executive)
                        if (!empty($value) && $value != '0000-00-00')
                            $this->vCard .= "BDAY:{$value}" . "\r\n";
                        break;
                    case 'EMAIL':
                        // Array - 1st - Value and 2nd - Label
                        $e_array = sizeof($value);
                        for ($e = 0; $e < $e_array; $e++) {
                            if (!empty($value[$e][0]) && !empty($value[$e][1])) {
                                $this->vCard .= "item{$item}.EMAIL;type=INTERNET;type=pref:{$value[$e][0]}" . "\r\n";
                                $this->vCard .= "item{$item}.X-ABLabel:{$value[$e][1]}" . "\r\n";
                                $item++;
                            }
                        }
                        break;
                    case 'TEL':
                        // tamanho do array
                        $t_array = sizeof($value);
                        for ($t = 0; $t < $t_array; $t++) {
                            if (!empty($value[$t][0]) && !empty($value[$t][1])) {
                                $this->vCard .= "item{$item}.TEL:{$value[$t][0]}" . "\r\n";
                                $this->vCard .= "item{$item}.X-ABLabel:{$value[$t][1]}" . "\r\n";
                                $item++;
                            }
                        }
                        break;
                    case 'NOTE':
                        // Organization
                        if (!empty($value))
                            $this->vCard .= "NOTE:{$value}" . "\r\n";
                        break;
                    case 'URL':
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.URL:{$value[0]}" . "\r\n";
                            $this->vCard .= "item{$item}.X-ABLabel:{$dados[0]['EMAIL'][1]}" . "\r\n";
                            $item++;
                        }
                        break;
                    case 'ADR':
                        // Address
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.ADR;type={$value[0]};type=pref:;;{$value[1]};{$value[2]};;{$value[3]};" . "\r\n";
                            $item++;
                        }

                        break;
                    case 'X-MANAGER':
                        // Name of the manager
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.X-MANAGER:{$value[0]}" . "\r\n";
                            $this->vCard .= "item{$item}.X-ABLabel:{$value[1]}" . "\r\n";
                            $item++;
                        }
                        break;
                    case 'X-MSN':
                        // Messenger
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.X-MSN:{$value[0]}" . "\r\n";
                            $this->vCard .= "item{$item}.X-ABLabel:{$value[1]}" . "\r\n";
                            $item++;
                        }
                        break;
                    case 'X-JABBER':
                        // Use for GTalk and others
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.X-JABBER:{$value[0]}" . "\r\n";
                            $this->vCard .= "item{$item}.X-ABLabel:{$value[1]}" . "\r\n";
                            $item++;
                        }
                        break;
                    case 'X-GENDER':
                        // Gender
                        if (!empty($value[0])) {
                            if ($value[0] == 'M')
                                $value[0] = 'Male';
                            else
                                $value[0] = 'Female';
                            $this->vCard .= "item{$item}.X-GENDER:{$value[0]}" . "\r\n";
                            $item++;
                        }
                        break;
                    case 'X-TWITTER':
                        // Twitter
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.X-TWITTER:{$value[0]}" . "\r\n";
                            $this->vCard .= "item{$item}.X-ABLabel:{$value[1]}" . "\r\n";
                            $item++;
                        }
                        break;
                    case 'X-SKYPE':
                        // Skype username
                        if (!empty($value[0]) && !empty($value[1])) {
                            $this->vCard .= "item{$item}.X-SKYPE:{$value[0]}" . "\r\n";
                            $this->vCard .= "item{$item}.X-ABLabel:{$value[1]}" . "\r\n";
                            $item++;
                        }
                        break;
                }
            }
            $this->vCard .= "END:VCARD" . "\r\n";
            $item = 1;
        }
    }

    public function getDados() {
        return $this->vCard;
    }

}

?>
