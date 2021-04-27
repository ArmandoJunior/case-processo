<?php


namespace App\Service\classes;


class SanitizerField
{
    public function removeDoublesSpaces(string $line) : string
    {
        return preg_replace('/\s\s+/', ' ', $line);
    }

    public function turnToArray(string $line) : array
    {
        return explode(' ', $line);
    }

    public function serialize(array $data) : array
    {
        $cpf = $this->cleanDocument($data[0]);
        $private = $this->cleanBoolean($data[1]);
        $incomplete = $this->cleanBoolean($data[2]);
        $lastBuy = $this->cleanDate($data[3]);
        $midTicket = $this->cleanTicket($data[4]);
        $lastTicket = $this->cleanTicket($data[5]);
        $usualStore = $this->cleanDocument($data[6]);
        $lastStore = $this->cleanDocument($data[7]);

        return [
            'cpf' => $cpf,
            'cpf_invalid' => $this->checkCPF($cpf),
            'private' => $private,
            'incomplete' => $incomplete,
            'last_buy' => $lastBuy,
            'mid_ticket' => $midTicket,
            'last_ticket' => $lastTicket,
            'usual_store' => $usualStore,
            'usual_store_invalid' => $this->checkCNPJ($usualStore),
            'last_store' => $lastStore,
            'last_store_invalid' => $this->checkCNPJ($lastStore)
        ];
    }

    private function cleanDocument(string $document) : ?string
    {
        $cleaned = preg_replace("/[^0-9]/", "", $document);

        if ($cleaned === "") return null;

        return $cleaned;
    }

    private function cleanBoolean($data) : bool
    {
        return preg_replace("/[^0-1]/", "", $data);
    }

    private function cleanTicket($data) : ?float
    {
        $cleanedStepOne = preg_replace("/[^0-9,]/", "", $data);

        if ($cleanedStepOne === "") return null;

        return str_replace(",", ".", $cleanedStepOne);
    }

    private function cleanDate($data) : ?string
    {
        $cleaned = preg_replace('/[^0-9-]/', '', $data);

        if ($cleaned === "") return null;

        return $cleaned;
    }

    private function checkCPF(?string $cpf)
    {
        if (strlen($cpf) != 11) return true;
        if (preg_match('/(\d)\1{10}/', $cpf)) return true;

        for ($digits = 9; $digits < 11; $digits++) {
            for ($dig = 0, $c = 0; $c < $digits; $c++) {
                $dig += $cpf[$c] * (($digits + 1) - $c);
            }
            $dig = ((10 * $dig) % 11) % 10;
            if ($cpf[$c] != $dig) return true;
        }
        return false;
    }

    function checkCNPJ(?string $cnpj): bool
    {
        if (strlen($cnpj) != 14) return true;

        if (preg_match('/(\d)\1{13}/', $cnpj)) return true;

        for ($digits = 12; $digits < 14; $digits++) {
            for ($d = 0, $m = ($digits - 7), $i = 0; $i < $digits; $i++) {
                $d += $cnpj[$i] * $m;
                $m = ($m == 2 ? 9 : --$m);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$i] != $d) return true;
        }
        return false;
    }
}
