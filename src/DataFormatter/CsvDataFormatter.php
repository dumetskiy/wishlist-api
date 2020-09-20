<?php

declare(strict_types=1);

namespace App\DataFormatter;

use App\Enum\DataFormat;
use Symfony\Component\Serializer\SerializerInterface;

class CsvDataFormatter
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param array|null $headerData
     *
     * @return string
     */
    public function formatData(array $data, array $headerData = null): string
    {
        if ($headerData) {
            array_unshift($data, $headerData);
        }

        return $this->serializer->serialize($data, DataFormat::FORMAT_CSV);
    }
}
