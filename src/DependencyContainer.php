<?php declare(strict_types = 1);
namespace Medusa\Container;

use Medusa\Container\Exception\NotFoundException;
use function array_values;
use function call_user_func;

/**
 * Class DependencyContainer
 * @package medusa/container
 * @author  Pascal Schnell <pascal.schnell@getmedusa.org>
 */
class DependencyContainer extends MedusaContainer {

    protected MedusaContainer $services;
    protected MedusaContainer $singletonServices;
    protected MedusaContainer $servicesCreated;

    public function __construct(array $services = [], array $singletonServices = []) {
        (function(callable ...$fn) {
        })(...array_values($services));
        (function(callable ...$fn) {
        })(...array_values($singletonServices));
        $this->singletonServices = new MedusaContainer($singletonServices);
        $this->services = new MedusaContainer($services);
        $this->servicesCreated = new MedusaContainer([]);
    }

    public function has(string $id): bool {
        return $this->services->has($id) || $this->singletonServices->has($id);
    }

    public function get(string $id): mixed {
        if ($this->servicesCreated->has($id)) {
            return $this->servicesCreated->get($id);
        }

        if ($this->singletonServices->has($id)) {
            $this->servicesCreated->storage[$id] = call_user_func($this->singletonServices->get($id), $this);
            $this->servicesCreated->keys[$id] = true;
            return $this->servicesCreated->storage[$id];
        }

        if ($this->services->has($id)) {
            return call_user_func($this->services->get($id), $this);
        }

        throw new NotFoundException($id);
    }
}
