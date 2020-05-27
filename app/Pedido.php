<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function items()
    {
        return $this->belongsToMany(Produto::class, 'itens_pedido','pedido_id','produto_id')->withPivot('quantity','price');
    }
}
