<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Enum\ContextGroup;
use App\Security\OwnershipValidator;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class AccessControlNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @var DenormalizerInterface|NormalizerInterface
     */
    private $normalizer;

    /**
     * @var OwnershipValidator
     */
    private $ownershipValidator;

    /**
     * @param NormalizerInterface $normalizer
     * @param OwnershipValidator $ownershipValidator
     */
    public function __construct(
        NormalizerInterface $normalizer,
        OwnershipValidator $ownershipValidator
    ) {
        $this->normalizer = $normalizer;
        $this->ownershipValidator = $ownershipValidator;
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     *
     * @return mixed
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if (
            !in_array(ContextGroup::OWNER_READ, $context)
            && $this->ownershipValidator->isObjectOwnedByCurrentUser($object)
        ) {
            $context['groups'][] = ContextGroup::OWNER_READ;
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    /**
     * @param mixed $data
     * @param string|null $format
     *
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->normalizer->supportsNormalization($data, $format);
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     *
     * @return array|object
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $initialDenormalizationContext = $context;
        $context['groups'][] = ContextGroup::OWNER_WRITE;
        $object = $this->normalizer->denormalize($data, $type, $format, $context);

        if (!$this->ownershipValidator->isObjectOwnedByCurrentUser($object)) {
            $object = $this->normalizer->denormalize($data, $type, $format, $initialDenormalizationContext);
        }

        return $object;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     *
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return $this->normalizer->supportsDenormalization($data, $type, $format);
    }

    private function addContextGroup(array &$context): void
    {

    }
}
