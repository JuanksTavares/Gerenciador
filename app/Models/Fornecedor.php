<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'telefone',
        'email'
    ];

    /**
     * Relacionamento com produtos
     */
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    /**
     * Setar CNPJ
     */
    public function setCnpjAttribute($value)
    {
        // Remove tudo que não for número
        $this->attributes['cnpj'] = preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Formatar CNPJ
     */
    public function getCnpjFormatadoAttribute()
    {
        $valor = $this->cnpj;
        $tamanho = strlen($valor);

        if ($tamanho === 11) { // CPF
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $valor);
        } else if ($tamanho === 14) { // CNPJ
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $valor);
        }
        
        return $valor;
    }

    /**
     * Obter tipo de documento
     */
    public function getTipoDocumentoAttribute()
    {
        return strlen($this->cnpj) === 11 ? 'CPF' : 'CNPJ';
    }

    /**
     * Formatar telefone
     */
    public function getTelefoneFormatadoAttribute()
    {
        $telefone = $this->telefone;
        if (strlen($telefone) === 11) {
            return '(' . substr($telefone, 0, 2) . ') ' . 
                   substr($telefone, 2, 5) . '-' . 
                   substr($telefone, 7, 4);
        }
        return $telefone;
    }

    public function setTelefoneAttribute($value)
    {
        // Remove tudo que não for número
        $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);
    }
}