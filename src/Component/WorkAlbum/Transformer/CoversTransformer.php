<?php


namespace App\Component\WorkAlbum\Transformer;

use App\Component\WorkAlbum\Entity\WorkAlbum;
use ArrayObject;
use Symfony\Component\Form\DataTransformerInterface;

class CoversTransformer implements DataTransformerInterface
{
    /**
     * @var ArrayObject
     */
    private $transformers;

    public function __construct()
    {
        $transformers = new ArrayObject();

        $transformers
            ->offsetSet(
                WorkAlbum::TYPE_CONTEST,
                function () {

                }
            );
    }

    /**
     * @param WorkAlbum $workAlbum
     * @return mixed|null
     */
    public function transform($workAlbum)
    {
        if (!$this->supportTransformation($workAlbum)) {
            return null;
        }

        switch ($workAlbum['category']) {
            case WorkAlbum::TYPE_CONTEST:
                return null;
        }
    }

    private function supportTransformation($value)
    {
        return $value instanceof WorkAlbum;
    }

    public function reverseTransform($value)
    {
    }

    private function resolveTransformer($name)
    {

    }
}
