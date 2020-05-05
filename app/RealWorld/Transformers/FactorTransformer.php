<?php

namespace App\RealWorld\Transformers;

class FactorTransformer extends Transformer
{
    protected $resourceName = 'factor';

    public function transform($data)
    {
        return [
            'id' => $data['id'],
            'value' => $data['value'],
            'title' => $data['title'],
            'description' => $data['description'],
        ];
    }
}