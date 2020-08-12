<?php

declare(strict_types=1);

namespace {

    if (\PHP_VERSION_ID < 70300) {
        if (!\function_exists('is_countable')) {
            /**
             * @param mixed $var
             *
             * @return bool
             *
             * @noinspection PhpComposerExtensionStubsInspection
             */
            function is_countable($var)
            {
                return \is_array($var)
                       ||
                       $var instanceof Countable
                       ||
                       $var instanceof ResourceBundle
                       ||
                       $var instanceof SimpleXMLElement;
            }
        }

        if (!\function_exists('array_key_first')) {
            /**
             * @param array<mixed> $array
             *
             * @return int|string|null
             */
            function array_key_first(array $array)
            {
                foreach ($array as $key => $value) {
                    return $key;
                }

                return null;
            }
        }

        if (!\function_exists('array_key_last')) {
            /**
             * @param array<mixed> $array
             *
             * @return int|string|null
             */
            function array_key_last(array $array)
            {
                if (\count($array) === 0) {
                    return null;
                }

                return \array_keys(
                    \array_slice($array, -1, 1, true)
                )[0];
            }
        }
    }

}

namespace Arrayy {

    use Arrayy\Collection\Collection;
    use Arrayy\TypeCheck\TypeCheckArray;
    use Arrayy\TypeCheck\TypeCheckInterface;

    if (!\function_exists('Arrayy\create')) {
        /**
         * Creates a Arrayy object.
         *
         * @param mixed $data
         *
         * @return Arrayy<int|string,mixed>
         */
        function create($data): Arrayy
        {
            return new Arrayy($data);
        }
    }

    if (!\function_exists('Arrayy\collection')) {
        /**
         * Creates a Collection object.
         *
         * @param string|TypeCheckArray|TypeCheckInterface[] $type
         * @param array<mixed>                               $data
         *
         * @return Collection
         *
         * @template T
         * @psalm-param T $type
         * @psalm-return Collection<int|string,T>
         */
        function collection($type, $data = []): Collection
        {
            return Collection::construct($type, $data);
        }
    }

    /**
     * @param array<mixed> $array
     * @param mixed        $fallback <p>This fallback will be used, if the array is empty.</p>
     *
     * @return mixed|null
     *
     * @template TLast
     * @template TLastFallback
     * @psalm-param TLast[] $array
     * @psalm-param TLastFallback $fallback
     * @psalm-return TLast|TLastFallback
     */
    function array_last(array $array, $fallback = null)
    {
        $key_last = \array_key_last($array);
        if ($key_last === null) {
            return $fallback;
        }

        return $array[$key_last];
    }

    /**
     * @param array<mixed> $array
     * @param mixed        $fallback <p>This fallback will be used, if the array is empty.</p>
     *
     * @return mixed|null
     *
     * @template TFirst
     * @template TFirstFallback
     * @psalm-param TFirst[] $array
     * @psalm-param TFirstFallback $fallback
     * @psalm-return TFirst|TFirstFallback
     */
    function array_first(array $array, $fallback = null)
    {
        $key_first = array_key_first($array);
        if ($key_first === null) {
            return $fallback;
        }

        return $array[$key_first];
    }

}
