<?php

namespace Spray\Serializer\TestAssets;

use Spray\Serializer\Object\BoundClosureSerializer;
use Spray\Serializer\SerializerInterface;

class FooSerializer extends BoundClosureSerializer
{
    public function __construct()
    {
        parent::__construct('Spray\Serializer\TestAssets\Foo');
    }

    protected function bindSerializer()
    {
        return function($subject, array &$data, SerializerInterface $serializer) {
            $data['bars'] = isset($subject->bars) ? $serializer->serialize($subject->bars) : null;
            $data['baz'] = isset($subject->baz) ? $serializer->serialize($subject->baz) : null;
            $data['date'] = isset($subject->date) ? $serializer->serialize($subject->date) : null;
            $data['ignore'] = isset($subject->ignore) ? $serializer->serialize($subject->ignore) : null;
        };
    }

    protected function bindDeserializer()
    {
        $deserialize = $this->valueDeserializer();
        return function($subject, array &$data, SerializerInterface $serializer) use ($deserialize) {
            $subject->bars = isset($data['bars']) ? $serializer->deserialize('Spray\Serializer\TestAssets\BarCollection', $data['bars']) : null;
            $subject->baz = isset($data['baz']) ? $serializer->deserialize('Spray\Serializer\TestAssets\Baz', $data['baz']) : null;
            $subject->date = isset($data['date']) ? $serializer->deserialize('DateTime', $data['date']) : null;
            $subject->ignore = isset($data['ignore']) ? $serializer->deserialize('Spray\Serializer\TestAssets\Ignore', $data['ignore']) : null;
        };
    }
}
