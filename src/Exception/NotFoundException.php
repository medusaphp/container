<?php declare(strict_types = 1);
namespace Medusa\Container\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;
use function sprintf;

/**
 * Class NotFoundException
 * @package medusa/container
 * @author  Pascal Schnell <pascal.schnell@getmedusa.org>
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface {

    public function __construct(string $id, int $code = 0, Throwable $previous = null) {
        $message = sprintf('No entry with id "%s" was found.', $id);
        parent::__construct($message, $code, $previous);
    }
}
