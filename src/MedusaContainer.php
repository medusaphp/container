<?php declare(strict_types = 1);
namespace Medusa\Container;

use Medusa\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;
use function array_flip;
use function array_keys;

/**
 * Class MedusaContainer
 * @package medusa/container
 * @author  Pascal Schnell <pascal.schnell@getmedusa.org>
 */
class MedusaContainer implements ContainerInterface {

    /** @var string[] */
    protected array $keys;

    /**
     * MedusaContainer constructor.
     * @param array $storage
     */
    public function __construct(protected array $storage = []) {
        $this->keys = array_flip(array_keys($this->storage));
    }

    /**
     * @param string $id
     * @return mixed
     * @throws NotFoundException
     */
    public function get(string $id): mixed {
        if (!$this->has($id)) {
            throw new NotFoundException($id);
        }

        return $this->storage[$id];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool {
        return ($this->keys[$id] ?? null) !== null;
    }
}
