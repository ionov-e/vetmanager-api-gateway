<?php /** @noinspection PhpDocFinalChecksInspection */

namespace VetmanagerApiGateway\Hydrator;

use Closure;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/** Super wacky & hacky solution to change default Symfony ObjectNormalizer to access private methods.
 * @package "symfony/serializer": "^6.3"
 * Should be rewritten as my own. https://symfony.com/doc/current/serializer/custom_normalizer.html
 */
class ObjectNormalizer extends \Symfony\Component\Serializer\Normalizer\ObjectNormalizer
{
    protected $propertyAccessor;
    private readonly Closure $objectClassResolver;

    public function __construct()
    {
        parent::__construct();
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->objectClassResolver = (static fn ($class) => is_object($class) ? $class::class : $class)(...);
    }

    /** @throws ReflectionException */
    protected function getAttributes(object $object, ?string $format, array $context): array
    {
        $allowedAttributes = $this->getAllowedAttributes($object, $context, true);

        if (false !== $allowedAttributes) {
            return $allowedAttributes;
        }

        $attributes = $this->extractAttributes($object, $format, $context);

        if ($mapping = $this->classDiscriminatorResolver?->getMappingForMappedObject($object)) {
            array_unshift($attributes, $mapping->getTypeProperty());
        }

        return $attributes;
    }

    /** @throws ReflectionException */
    protected function extractAttributes(object $object, string $format = null, array $context = []): array
    {
        $attributes = [];
        $class = ($this->objectClassResolver)($object);
        $reflectionClass = new ReflectionClass($class);

        foreach ($reflectionClass->getProperties() as $reflProperty) {

            if ($reflProperty->isStatic() || !$this->isAllowedAttribute($object, $reflProperty->name, $format, $context)) {
                continue;
            }

            $attributes[$reflProperty->name] = true;
        }

        return array_keys($attributes);
    }
}