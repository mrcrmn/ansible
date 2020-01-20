<?php

namespace Mrcrmn\Ansible;

use InvalidArgumentException;
use Mrcrmn\Ansible\Exceptions\InvalidParameterException;

class Task
{
    protected $taskName;
    protected $description;
    protected $parameters = [];

    public function __construct(string $description, string $taskName, array $parameters)
    {
        $this->setDescription($description);
        $this->setTaskName($taskName);
        $this->setParameters($parameters);
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function setTaskName(string $taskName): void
    {
        if (preg_match('/[a-z0-9_]/', $taskName) === 0) {
            throw new InvalidArgumentException("'{$taskName}' is not a valid task name. A task name should be lowercase and only include numbers and underscores.");
        }

        $this->taskName = $taskName;
    }

    public function validateParameter(string $parameterName, $parameterValue, array $validation)
    {
        if (! array_key_exists($parameterName, $validation)) {
            throw new InvalidParameterException("'{$parameterName}' is not a valid parameter for modules '{$this->taskName}'.");
        }

        $types = is_string($validation[$parameterName]) ? explode('|', $validation[$parameterName]) : false;

        if ($types !== false) {
            $check = false;

            foreach ($types as $type) {
                $typeCheck = call_user_func('is_' . $type, $parameterValue);

                if ($typeCheck) {
                    $check = true;
                    break;
                }
            }

            if (! $check) {
                throw new InvalidParameterException("'{$parameterName}' must be of type " . implode(' or ', $validation[$parameterName]) . ".");
            }
        }

        if (is_array($validation[$parameterName])) {
            $check = in_array($parameterValue, $validation[$parameterName]);

            if (! $check) {
                throw new InvalidParameterException("'{$parameterName}' must be of one of the following values: " . implode(', ', $validation[$parameterName]) . ".");
            }
        }
    }

    public function setParameter(string $parameterName, $parameterValue)
    {
        if (method_exists($this, 'validParameters')) {
            $this->validateParameter($parameterName, $parameterValue, $this->validParameters());
        }

        $this->parameters[$parameterName] = $parameterValue;
    }

    public function setParameters(array $parameters): void
    {
        foreach ($parameters as $parameterName => $parameterValue) {
            $this->setParameter($parameterName, $parameterValue);
        }
    }

    protected function getParameters(): array
    {
        return $this->parameters;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->description,
            $this->taskName => $this->getParameters()
        ];
    }
}